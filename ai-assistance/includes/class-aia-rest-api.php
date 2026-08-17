<?php
/**
 * REST API endpoints for AI WooCommerce Assistance.
 *
 * Registers /wp-json/aia/v1/chat and /wp-json/aia/v1/models endpoints.
 *
 * @package    AI_Woo_Assistance
 * @author     Kbizsoft Solutions Pvt. Ltd.
 * @copyright  2010-2026 Kbizsoft Solutions Pvt. Ltd.
 * @license    http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers and handles the /wp-json/aia/v1/chat endpoint.
 */
class AIA_Rest_Api {

    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    public function register_routes() {
        register_rest_route( 'aia/v1', '/chat', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_chat' ),
            'permission_callback' => array( $this, 'permission_check' ),
            'args'                => array(
                'history' => array(
                    'required' => true,
                    'type'     => 'array',
                ),
                'visitor_id' => array(
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'language' => array(
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            ),
        ) );

        register_rest_route( 'aia/v1', '/chat/history', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'handle_chat_history' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            },
            'args'                => array(
                'search' => array(
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'page' => array(
                    'required'          => false,
                    'type'              => 'integer',
                    'default'           => 1,
                ),
                'per_page' => array(
                    'required'          => false,
                    'type'              => 'integer',
                    'default'           => 20,
                ),
            ),
        ) );

        register_rest_route( 'aia/v1', '/chat/delete', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_delete_chat' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            },
            'args'                => array(
                'id' => array(
                    'required'          => true,
                    'type'              => 'integer',
                ),
            ),
        ) );

        register_rest_route( 'aia/v1', '/chat/clear', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_clear_chat' ),
            'permission_callback' => array( $this, 'permission_check' ),
            'args'                => array(
                'visitor_id' => array(
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            ),
        ) );

        register_rest_route( 'aia/v1', '/chat/session', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'handle_chat_session' ),
            'permission_callback' => array( $this, 'permission_check' ),
            'args'                => array(
                'visitor_id' => array(
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            ),
        ) );

        register_rest_route( 'aia/v1', '/chat/history', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'handle_chat_history' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            },
            'args'                => array(
                'search' => array(
                    'required'          => false,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'page' => array(
                    'required'          => false,
                    'type'              => 'integer',
                    'default'           => 1,
                ),
                'per_page' => array(
                    'required'          => false,
                    'type'              => 'integer',
                    'default'           => 20,
                ),
            ),
        ) );

        register_rest_route( 'aia/v1', '/models', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'handle_models' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            },
            'args'                => array(
                'provider' => array(
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => function( $v ) {
                        return in_array( $v, array( 'gemini', 'openai', 'claude' ), true );
                    },
                ),
            ),
        ) );
    }

    /**
     * Require a valid WP REST nonce so requests must originate from the
     * site's own frontend, not an arbitrary third party.
     */
    public function permission_check( WP_REST_Request $request ) {
        $nonce = $request->get_header( 'X-WP-Nonce' );
        if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
            return new WP_Error( 'AIA_forbidden', __( 'Invalid request.', 'ai-woo-assistance' ), array( 'status' => 403 ) );
        }
        return true;
    }

    // -------------------------------------------------------------------------
    // /aia/v1/models  — live model list for the Settings page dropdown
    // -------------------------------------------------------------------------

    /**
     * Fetch available models from the selected provider's API.
     * Returns array of { id, name } objects ordered by recency.
     *
     * @param  WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function handle_models( WP_REST_Request $request ) {
        $provider = $request->get_param( 'provider' );
        $opts     = wp_parse_args( get_option( AIA_OPTION_NAME, array() ), AIA_Settings::defaults() );
        $api_key  = trim( $opts['api_key'] ?? '' );

        if ( empty( $api_key ) ) {
            return new WP_Error(
                'AIA_no_key',
                __( 'No API key saved. Save your API key in Settings first, then the model list will load.', 'ai-woo-assistance' ),
                array( 'status' => 400 )
            );
        }

        switch ( $provider ) {
            case 'openai':
                $models = $this->fetch_openai_models( $api_key );
                break;
            case 'claude':
                $models = $this->fetch_claude_models( $api_key );
                break;
            default:
                $models = $this->fetch_gemini_models( $api_key );
                break;
        }

        if ( is_wp_error( $models ) ) {
            return $models;
        }

        return new WP_REST_Response( array( 'models' => $models ), 200 );
    }

    /**
     * Fetch models from Google Gemini (generativelanguage API).
     * Only returns generateContent-capable models, sorted newest first.
     *
     * @param  string $api_key
     * @return array|WP_Error  Array of {id, name} or WP_Error on failure.
     */
    private function fetch_gemini_models( $api_key ) {
        $url      = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . rawurlencode( $api_key ) . '&pageSize=100';
        $response = wp_remote_get( $url, array( 'timeout' => 15 ) );

        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'AIA_fetch', $response->get_error_message(), array( 'status' => 502 ) );
        }

        $code = wp_remote_retrieve_response_code( $response );
        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( $code !== 200 ) {
            $msg = $data['error']['message'] ?? __( 'Could not fetch Gemini models.', 'ai-woo-assistance' );
            return new WP_Error( 'AIA_fetch', $msg, array( 'status' => $code ) );
        }

        $raw    = $data['models'] ?? array();
        $models = array();

        foreach ( $raw as $m ) {
            // Only include models that support text generation.
            $methods = $m['supportedGenerationMethods'] ?? array();
            if ( ! in_array( 'generateContent', $methods, true ) ) {
                continue;
            }
            // Strip the "models/" prefix to get the usable ID.
            $id = str_replace( 'models/', '', $m['name'] );
            // Skip embedding / vision-only / legacy tuned models.
            if ( preg_match( '/embed|vision|aqa|learnlm|gemma|exp\b/i', $id ) ) {
                continue;
            }
            $models[] = array(
                'id'   => $id,
                'name' => $m['displayName'] ?? $id,
            );
        }

        // Sort: newer versions first (reverse-lex on the version number portion).
        usort( $models, function( $a, $b ) {
            return strcmp( $b['id'], $a['id'] );
        } );

        return $models;
    }

    /**
     * Fetch models from OpenAI API.
     * Filters to GPT chat-completion models only.
     *
     * @param  string $api_key
     * @return array|WP_Error
     */
    private function fetch_openai_models( $api_key ) {
        $response = wp_remote_get( 'https://api.openai.com/v1/models', array(
            'headers' => array( 'Authorization' => 'Bearer ' . $api_key ),
            'timeout' => 15,
        ) );

        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'AIA_fetch', $response->get_error_message(), array( 'status' => 502 ) );
        }

        $code = wp_remote_retrieve_response_code( $response );
        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( $code !== 200 ) {
            $msg = $data['error']['message'] ?? __( 'Could not fetch OpenAI models.', 'ai-woo-assistance' );
            return new WP_Error( 'AIA_fetch', $msg, array( 'status' => $code ) );
        }

        $raw    = $data['data'] ?? array();
        $models = array();

        foreach ( $raw as $m ) {
            $id = $m['id'] ?? '';
            // Only chat-completion GPT models.
            if ( ! preg_match( '/^gpt-(4|3\.5)/i', $id ) ) {
                continue;
            }
            // Skip instruct and base variants.
            if ( preg_match( '/instruct|base|vision-preview/i', $id ) ) {
                continue;
            }
            $models[] = array(
                'id'   => $id,
                'name' => strtoupper( $id ),
            );
        }

        usort( $models, function( $a, $b ) {
            return strcmp( $b['id'], $a['id'] );
        } );

        return $models;
    }

    /**
     * Fetch models from Anthropic Claude API.
     * The /v1/models endpoint is available on API version 2023-06-01+.
     *
     * @param  string $api_key
     * @return array|WP_Error
     */
    private function fetch_claude_models( $api_key ) {
        $response = wp_remote_get( 'https://api.anthropic.com/v1/models', array(
            'headers' => array(
                'x-api-key'         => $api_key,
                'anthropic-version' => '2023-06-01',
            ),
            'timeout' => 15,
        ) );

        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'AIA_fetch', $response->get_error_message(), array( 'status' => 502 ) );
        }

        $code = wp_remote_retrieve_response_code( $response );
        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( $code !== 200 ) {
            $msg = $data['error']['message'] ?? __( 'Could not fetch Claude models.', 'ai-woo-assistance' );
            return new WP_Error( 'AIA_fetch', $msg, array( 'status' => $code ) );
        }

        $raw    = $data['data'] ?? array();
        $models = array();

        foreach ( $raw as $m ) {
            $id = $m['id'] ?? '';
            if ( empty( $id ) ) {
                continue;
            }
            $models[] = array(
                'id'   => $id,
                'name' => $m['display_name'] ?? $id,
            );
        }

        // Newest first.
        usort( $models, function( $a, $b ) {
            return strcmp( $b['id'], $a['id'] );
        } );

        return $models;
    }

    // -------------------------------------------------------------------------
    // /aia/v1/chat
    // -------------------------------------------------------------------------

    public function handle_chat( WP_REST_Request $request ) {
        $opts = wp_parse_args( get_option( AIA_OPTION_NAME, array() ), AIA_Settings::defaults() );
        if ( empty( $opts['enabled'] ) ) {
            return new WP_REST_Response( array( 'reply' => __( 'The Assistance is currently unavailable.', 'ai-woo-assistance' ) ), 200 );
        }

        if ( empty( $opts['api_key'] ) ) {
            return new WP_REST_Response( array(
                'reply' => __( 'The Assistance is not configured yet. Please set an API key in Settings → AI Assistance.', 'ai-woo-assistance' ),
            ), 200 );
        }

        $rate_check = $this->check_rate_limit( $opts['rate_limit'] );
        if ( is_wp_error( $rate_check ) ) {
            return new WP_REST_Response( array(
                'reply' => __( "You've sent a lot of messages — please try again in a bit.", 'ai-woo-assistance' ),
            ), 200 );
        }

        $warning = '';
        if ( is_array( $rate_check ) && ! empty( $rate_check['warning'] ) ) {
            $warning = $rate_check['warning'];
        }

        $history_raw = $request->get_param( 'history' );
        $history     = $this->sanitize_history( $history_raw );

        if ( empty( $history ) ) {
            return new WP_REST_Response( array( 'reply' => __( 'Please type a message.', 'ai-woo-assistance' ) ), 200 );
        }

        $visitor_id = sanitize_text_field( $request->get_param( 'visitor_id' ) );
        $language   = sanitize_text_field( $request->get_param( 'language' ) );

        if ( empty( $language ) ) {
            $language = get_locale();
        }

        $user_id = get_current_user_id();

        // Concatenate all of the visitor's messages so an order ID given in
        // one turn and the email given in a later turn can still be matched.
        $all_user_text = array();
        foreach ( $history as $m ) {
            if ( 'user' === $m['role'] ) {
                $all_user_text[] = $m['content'];
            }
        }
        $combined_user_text = implode( "\n", $all_user_text );

        $custom_types  = isset( $opts['custom_post_types'] ) && is_array( $opts['custom_post_types'] )
            ? $opts['custom_post_types']
            : array();
        $woo_context   = ( new AIA_Woo_Context() )->build( $combined_user_text, $opts['sources'], $custom_types );
        $system_prompt = $opts['system_prompt'] . "\n\n" . $woo_context;

        if ( ! empty( $language ) ) {
            $system_prompt = sprintf( "%s\n\nRespond in %s. If the question is related to this website, answer in the selected language.", $system_prompt, $language );
        }

        $provider = isset( $opts['provider'] ) ? $opts['provider'] : 'gemini';
        $model    = $this->resolve_model( $provider, isset( $opts['model'] ) ? $opts['model'] : '' );

        $reply = $this->call_provider( $provider, $opts['api_key'], $model, $system_prompt, $history );

        if ( $visitor_id || $user_id ) {
            $history[] = array( 'role' => 'assistant', 'content' => $reply );
            AIA_History::instance()->save_conversation( $visitor_id, $user_id, $language, $history );
        }

        $response_data = array( 'reply' => $reply );
        if ( ! empty( $warning ) ) {
            $response_data['warning'] = $warning;
        }

        return new WP_REST_Response( $response_data, 200 );
    }

    public function handle_chat_session( WP_REST_Request $request ) {
        $visitor_id = sanitize_text_field( $request->get_param( 'visitor_id' ) );
        $user_id    = get_current_user_id();
        $session    = AIA_History::instance()->get_conversation( $visitor_id, $user_id );

        return new WP_REST_Response( array( 'conversation' => $session ), 200 );
    }

    public function handle_clear_chat( WP_REST_Request $request ) {
        $visitor_id = sanitize_text_field( $request->get_param( 'visitor_id' ) );
        $user_id    = get_current_user_id();

        $cleared = AIA_History::instance()->clear_conversation( $visitor_id, $user_id );
        return new WP_REST_Response( array( 'cleared' => (bool) $cleared ), 200 );
    }

    public function handle_chat_history( WP_REST_Request $request ) {
        $search   = sanitize_text_field( $request->get_param( 'search' ) );
        $page     = max( 1, intval( $request->get_param( 'page' ) ) );
        $per_page = max( 1, min( 100, intval( $request->get_param( 'per_page' ) ) ) );

        $result = AIA_History::instance()->query_conversations( $search, $page, $per_page );
        return new WP_REST_Response( $result, 200 );
    }

    public function handle_delete_chat( WP_REST_Request $request ) {
        $id      = absint( $request->get_param( 'id' ) );
        $deleted = AIA_History::instance()->delete_conversation( $id );

        return new WP_REST_Response( array( 'deleted' => (bool) $deleted ), 200 );
    }

    /**
     * Ensures we always have a valid model for the active provider.
     * Since the model list is now fetched live from the API, we trust
     * whatever is saved as long as it is a non-empty string.
     */
    private function resolve_model( $provider, $saved_model ) {
        if ( ! empty( $saved_model ) ) {
            return $saved_model;
        }

        // Per-provider sensible fallbacks if nothing is saved.
        $defaults = array(
            'gemini' => 'gemini-2.5-flash',
            'openai' => 'gpt-4o-mini',
            'claude' => 'claude-3-5-haiku-latest',
        );

        return $defaults[ $provider ] ?? 'gemini-2.5-flash';
    }

    private function sanitize_history( $history ) {
        $clean = array();
        if ( ! is_array( $history ) ) {
            return $clean;
        }
        // Cap history length to control token usage / cost.
        $history = array_slice( $history, -12 );

        foreach ( $history as $m ) {
            if ( ! isset( $m['role'], $m['content'] ) ) {
                continue;
            }
            $role    = ( 'assistant' === $m['role'] ) ? 'assistant' : 'user';
            $content = sanitize_textarea_field( wp_unslash( $m['content'] ) );
            if ( '' === trim( $content ) ) {
                continue;
            }
            // Truncate any single message to keep requests bounded.
            $content   = mb_substr( $content, 0, 2000 );
            $clean[] = array( 'role' => $role, 'content' => $content );
        }
        return $clean;
    }

    /**
     * Simple per-IP hourly cap using transients.
     */
    private function check_rate_limit( $limit ) {
        $ip    = $this->get_client_ip();
        $key   = 'AIA_rl_' . md5( $ip );
        $count = (int) get_transient( $key );

        if ( $count >= $limit ) {
            return new WP_Error( 'AIA_rate_limited', 'Rate limit exceeded' );
        }

        $next_count = $count + 1;
        set_transient( $key, $next_count, HOUR_IN_SECONDS );

        $threshold = max( 1, ceil( $limit * 0.9 ) );
        if ( $next_count >= $threshold && $next_count < $limit ) {
            return array(
                'warning' => sprintf(
                    /* translators: 1: current message count, 2: hourly limit */
                    __( 'You are at %1$d of %2$d allowed messages this hour. Please use the chat sparingly until the limit resets.', 'ai-woo-assistance' ),
                    $next_count,
                    $limit
                ),
            );
        }

        return true;
    }

    private function get_client_ip() {
        if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $parts = explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
            return trim( $parts[0] );
        }
        return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0.0.0.0';
    }

    private function call_provider( $provider, $api_key, $model, $system_prompt, $messages ) {
        if ( 'openai' === $provider ) return $this->call_openai( $api_key, $model, $system_prompt, $messages );
        if ( 'claude' === $provider ) return $this->call_claude( $api_key, $model, $system_prompt, $messages );
        return $this->call_gemini( $api_key, $model, $system_prompt, $messages );
    }

    /**
     * Shared response error handler — returns a string on error, array on success.
     */
    private function parse_response( $response, $provider ) {
        if ( is_wp_error( $response ) ) {
            error_log( 'AI Woo Assistance [' . $provider . '] connection error: ' . $response->get_error_message() );
            return __( 'Error contacting the AI service. Please try again shortly.', 'ai-woo-assistance' );
        }
        $code = wp_remote_retrieve_response_code( $response );
        $data = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( $code < 200 || $code >= 300 ) {
            $detail = isset( $data['error']['message'] ) ? $data['error']['message'] : wp_remote_retrieve_body( $response );
            error_log( 'AI Woo Assistance [' . $provider . '] HTTP ' . $code . ': ' . $detail );
            if ( current_user_can( 'manage_options' ) ) {
                return sprintf( '[Debug %s HTTP %s] %s', $provider, $code, $detail );
            }
            return __( 'The AI service returned an error. Please try again shortly.', 'ai-woo-assistance' );
        }
        return $data;
    }

    // -------------------------------------------------------------------------
    // OpenAI
    // -------------------------------------------------------------------------
    private function call_openai( $api_key, $model, $system_prompt, $messages ) {
        $chat = array( array( 'role' => 'system', 'content' => $system_prompt ) );
        foreach ( $messages as $m ) {
            $chat[] = array( 'role' => $m['role'], 'content' => $m['content'] );
        }

        $response = wp_remote_post( 'https://api.openai.com/v1/chat/completions', array(
            'headers' => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
            ),
            'body'    => wp_json_encode( array(
                'model'      => $model,
                'messages'   => $chat,
                'max_tokens' => 600,
            ) ),
            'timeout' => 30,
        ) );

        $data = $this->parse_response( $response, 'OpenAI' );
        if ( is_string( $data ) ) return $data;

        return isset( $data['choices'][0]['message']['content'] )
            ? trim( $data['choices'][0]['message']['content'] )
            : __( 'Sorry, I could not generate a response right now.', 'ai-woo-assistance' );
    }

    // -------------------------------------------------------------------------
    // Anthropic Claude
    // -------------------------------------------------------------------------
    private function call_claude( $api_key, $model, $system_prompt, $messages ) {
        $chat = array();
        foreach ( $messages as $m ) {
            $chat[] = array(
                'role'    => ( 'assistant' === $m['role'] ) ? 'assistant' : 'user',
                'content' => $m['content'],
            );
        }

        $response = wp_remote_post( 'https://api.anthropic.com/v1/messages', array(
            'headers' => array(
                'Content-Type'      => 'application/json',
                'x-api-key'         => $api_key,
                'anthropic-version' => '2023-06-01',
            ),
            'body'    => wp_json_encode( array(
                'model'      => $model,
                'system'     => $system_prompt,
                'messages'   => $chat,
                'max_tokens' => 600,
            ) ),
            'timeout' => 30,
        ) );

        $data = $this->parse_response( $response, 'Claude' );
        if ( is_string( $data ) ) return $data;

        return isset( $data['content'][0]['text'] )
            ? trim( $data['content'][0]['text'] )
            : __( 'Sorry, I could not generate a response right now.', 'ai-woo-assistance' );
    }

    // -------------------------------------------------------------------------
    // Google Gemini
    // Gemini format: roles are 'user' / 'model', system goes in systemInstruction,
    // API key is passed as a query param.
    // -------------------------------------------------------------------------
    private function call_gemini( $api_key, $model, $system_prompt, $messages ) {
        $contents = array();
        foreach ( $messages as $m ) {
            $contents[] = array(
                'role'  => ( 'assistant' === $m['role'] ) ? 'model' : 'user',
                'parts' => array( array( 'text' => $m['content'] ) ),
            );
        }

        $body = array(
            'systemInstruction' => array(
                'parts' => array( array( 'text' => $system_prompt ) ),
            ),
            'contents'          => $contents,
            'generationConfig'  => array(
                'maxOutputTokens' => 600,
            ),
        );

        $url = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
            rawurlencode( $model ),
            rawurlencode( $api_key )
        );

        $response = wp_remote_post( $url, array(
            'headers' => array( 'Content-Type' => 'application/json' ),
            'body'    => wp_json_encode( $body ),
            'timeout' => 30,
        ) );

        $data = $this->parse_response( $response, 'Gemini' );
        if ( is_string( $data ) ) return $data;

        $reply = '';
        if ( isset( $data['candidates'][0]['content']['parts'] ) && is_array( $data['candidates'][0]['content']['parts'] ) ) {
            foreach ( $data['candidates'][0]['content']['parts'] as $part ) {
                if ( isset( $part['text'] ) ) {
                    $reply .= $part['text'];
                }
            }
        }

        return $reply !== ''
            ? $reply
            : __( 'Sorry, I could not generate a response right now.', 'ai-woo-assistance' );
    }
}
