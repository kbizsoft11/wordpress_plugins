<?php

declare(strict_types=1);

// Report all PHP errors
error_reporting(E_ALL);

// Force errors to display on the screen
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

/**
 * Standalone Save For Later activation endpoint.
 *
 * Deploy this directory on a PHP server. It does not load WordPress.
 * Configure database credentials in config.php before deployment.
 */

// Edit these values before deploying this endpoint to the live server.
$config = array(
	'dsn' => 'mysql:host=localhost;dbname=freshlea_stuhhho;charset=utf8mb4',
	'username' => 'freshlea_stuhhho',
	'password' => '0yifPb(QM5Wh',
	'table' => 'wsflla_activations',
	'mail_from' => 'no-reply@kbizsoft.com',
	'mail_from_name' => 'Kbizsoft Save For Later',
	'mail_subject' => 'Your Save For Later activation code',
);

$table = $config['table'] ?? 'wsflla_activations';

if (!preg_match('/^[A-Za-z0-9_]+$/', $table)) {
	activation_fail('Invalid activation table name.', 500);
}

header('Content-Type: application/json; charset=utf-8');

try {
	$pdo = new PDO(
		$config['dsn'],
		$config['username'],
		$config['password'],
		array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		)
	);

	$pdo->exec("CREATE TABLE IF NOT EXISTS `$table` (
		activation_key CHAR(64) NOT NULL PRIMARY KEY,
		email VARCHAR(254) NOT NULL,
		site_url VARCHAR(2048) NOT NULL,
		token_hash CHAR(64) NOT NULL,
		active TINYINT(1) NOT NULL DEFAULT 1,
		created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		last_checked_at TIMESTAMP NULL DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

	$action = isset($_POST['action']) ? trim((string) $_POST['action']) : '';

	if ($action === 'check_activation') {
		$email = normalize_email($_POST['xxemail'] ?? '');
		$site_url = normalize_site_url($_POST['site'] ?? '');
		$token = trim((string) ($_POST['to_check'] ?? ''));
		$key = activation_key($email, $site_url);

		$stmt = $pdo->prepare("SELECT token_hash, active FROM `$table` WHERE activation_key = :activation_key LIMIT 1");
		$stmt->execute(array('activation_key' => $key));
		$row = $stmt->fetch();

		$valid = $row && (int) $row['active'] === 1 && hash_equals($row['token_hash'], hash('sha256', $token));

		if ($valid) {
			$update = $pdo->prepare("UPDATE `$table` SET last_checked_at = CURRENT_TIMESTAMP WHERE activation_key = :activation_key");
			$update->execute(array('activation_key' => $key));
		}

		activation_json(array('success' => true, 'active' => (bool) $valid));
		exit;
	}

	$email = normalize_email($_POST['email'] ?? '');
	$site_url = normalize_site_url($_POST['site_url'] ?? '');

	if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !filter_var($site_url, FILTER_VALIDATE_URL)) {
		activation_fail('Invalid email or site URL.', 400);
	}

	$token = bin2hex(random_bytes(16));
	$key = activation_key($email, $site_url);
	$token_hash = hash('sha256', $token);

	$stmt = $pdo->prepare("INSERT INTO `$table` (activation_key, email, site_url, token_hash, active)
		VALUES (:activation_key, :email, :site_url, :token_hash, 1)
		ON DUPLICATE KEY UPDATE email = VALUES(email), site_url = VALUES(site_url), token_hash = VALUES(token_hash), active = 1");
	$stmt->execute(array(
		'activation_key' => $key,
		'email' => $email,
		'site_url' => $site_url,
		'token_hash' => $token_hash,
	));

	// if (!send_activation_email($config, $email, $site_url, $token)) {
	// 	activation_fail('Activation token was created, but the email could not be sent. Configure the server mail transport.', 502);
	// }

	activation_json(array('success' => true, 'token' => $token));
} catch (Throwable $error) {
	activation_fail('Activation server error.' . $error->getMessage(), 500);
	error_log('Save For Later activation error: ' . $error->getMessage());
}

function activation_json(array $payload, int $status = 200): void
{
	http_response_code($status);
	echo json_encode($payload, JSON_UNESCAPED_SLASHES);
}

function activation_fail(string $message, int $status = 400): void
{
	activation_json(array('success' => false, 'message' => $message), $status);
	exit;
}

function normalize_email($value): string
{
	return strtolower(trim((string) $value));
}

function normalize_site_url($value): string
{
	return rtrim(trim((string) $value), '/');
}

function activation_key(string $email, string $site_url): string
{
	return hash('sha256', $email . '|' . $site_url);
}

// function send_activation_email(array $config, string $email, string $site_url, string $token): bool
// {
// 	$from = trim((string) ($config['mail_from'] ?? ''));
// 	$from_name = trim((string) ($config['mail_from_name'] ?? 'Save For Later'));
// 	$subject = trim((string) ($config['mail_subject'] ?? 'Save For Later activation code'));

// 	if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
// 		error_log('Save For Later activation email error: invalid mail_from configuration.');
// 		return false;
// 	}

// 	$message = "Hello,\n\n" .
// 		"Your Save For Later activation code is:\n\n" .
// 		$token . "\n\n" .
// 		"Site: " . $site_url . "\n\n" .
// 		"If you did not request this code, you can ignore this email.\n";

// 	$headers = array(
// 		'From: ' . $from_name . ' <' . $from . '>',
// 		'Reply-To: ' . $from,
// 		'Content-Type: text/plain; charset=UTF-8',
// 	);

// 	return mail($email, $subject, $message, implode("\r\n", $headers), '-f' . $from);
// }
