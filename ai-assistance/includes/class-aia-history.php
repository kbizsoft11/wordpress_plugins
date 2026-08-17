<?php
/**
 * Chat history storage and cleanup for AI Assistance.
 *
 * @package    AI_Woo_Assistance
 * @author     Kbizsoft Solutions Pvt. Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AIA_History {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'aia_delete_old_chats', array( $this, 'delete_old_chats' ) );
    }

    public static function create_tables() {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $table_name      = $wpdb->prefix . 'aia_chat_history';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            visitor_id varchar(128) NOT NULL,
            user_id bigint(20) unsigned NOT NULL DEFAULT 0,
            language varchar(20) NOT NULL DEFAULT '',
            messages longtext NOT NULL,
            created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            updated_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY  (id),
            KEY visitor_id (visitor_id),
            KEY user_id (user_id),
            KEY updated_at (updated_at)
        ) $charset_collate;";

        dbDelta( $sql );
    }

    public function schedule_cleanup() {
        if ( ! wp_next_scheduled( 'aia_delete_old_chats' ) ) {
            wp_schedule_event( time(), 'daily', 'aia_delete_old_chats' );
        }
    }

    public function clear_cleanup_schedule() {
        $timestamp = wp_next_scheduled( 'aia_delete_old_chats' );
        if ( $timestamp ) {
            wp_unschedule_event( $timestamp, 'aia_delete_old_chats' );
        }
    }

        public function delete_old_chats() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'aia_chat_history';
        $opts       = get_option( AIA_OPTION_NAME, array() );
        $days       = isset( $opts['auto_delete_days'] ) ? absint( $opts['auto_delete_days'] ) : 7;
        $threshold  = gmdate( 'Y-m-d H:i:s', time() - ( $days * DAY_IN_SECONDS ) );

        $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE updated_at < %s", $threshold ) );
    }


    public function save_conversation( $visitor_id, $user_id, $language, $history ) {
        global $wpdb;

        if ( empty( $visitor_id ) ) {
            return false;
        }

        $row = $this->find_conversation( $visitor_id, $user_id );
        $now = gmdate( 'Y-m-d H:i:s' );
        $data = wp_json_encode( $history, JSON_UNESCAPED_UNICODE );

        if ( $row ) {
            return (bool) $wpdb->update(
                $wpdb->prefix . 'aia_chat_history',
                array(
                    'language'   => sanitize_text_field( $language ),
                    'messages'   => $data,
                    'updated_at' => $now,
                ),
                array( 'id' => $row->id ),
                array( '%s', '%s', '%s' ),
                array( '%d' )
            );
        }

        return (bool) $wpdb->insert(
            $wpdb->prefix . 'aia_chat_history',
            array(
                'visitor_id' => sanitize_text_field( $visitor_id ),
                'user_id'    => absint( $user_id ),
                'language'   => sanitize_text_field( $language ),
                'messages'   => $data,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array( '%s', '%d', '%s', '%s', '%s', '%s' )
        );
    }

    public function get_conversation( $visitor_id, $user_id ) {
        $row = $this->find_conversation( $visitor_id, $user_id );
        if ( ! $row ) {
            return array();
        }

        $messages = json_decode( $row->messages, true );
        if ( ! is_array( $messages ) ) {
            $messages = array();
        }

        return array(
            'id'         => absint( $row->id ),
            'visitor_id' => $row->visitor_id,
            'user_id'    => absint( $row->user_id ),
            'language'   => $row->language,
            'messages'   => $messages,
            'created_at' => $row->created_at,
            'updated_at' => $row->updated_at,
        );
    }

    public function clear_conversation( $visitor_id, $user_id ) {
        global $wpdb;

        if ( empty( $visitor_id ) && empty( $user_id ) ) {
            return false;
        }

        $where     = array();
        $where_sql = array();

        if ( ! empty( $user_id ) ) {
            $where_sql[] = 'user_id = %d';
            $where[]     = absint( $user_id );
        }

        if ( ! empty( $visitor_id ) ) {
            $where_sql[] = 'visitor_id = %s';
            $where[]     = sanitize_text_field( $visitor_id );
        }

        if ( empty( $where_sql ) ) {
            return false;
        }

        return (bool) $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}aia_chat_history WHERE " . implode( ' AND ', $where_sql ), $where ) );
    }

    public function delete_conversation( $id ) {
        global $wpdb;
        return (bool) $wpdb->delete( $wpdb->prefix . 'aia_chat_history', array( 'id' => absint( $id ) ), array( '%d' ) );
    }

    public function query_conversations( $search = '', $page = 1, $per_page = 20 ) {
        global $wpdb;

        $offset = max( 0, ( $page - 1 ) * $per_page );
        $where  = '1=1';

        if ( '' !== trim( $search ) ) {
            $like = esc_sql( '%' . $wpdb->esc_like( $search ) . '%' );
            $where .= " AND (visitor_id LIKE '$like' OR language LIKE '$like' OR messages LIKE '$like'";
            if ( ctype_digit( $search ) ) {
                $where .= ' OR user_id = ' . absint( $search );
            }
            $where .= ')';
        }

        $table_name = $wpdb->prefix . 'aia_chat_history';
        $rows       = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE $where ORDER BY updated_at DESC LIMIT %d, %d", $offset, $per_page ), ARRAY_A );
        $total      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE $where" );

        return array(
            'rows'  => $rows,
            'total' => $total,
        );
    }

    public function export_conversations( $search = '' ) {
        global $wpdb;

        $where = '1=1';
        if ( '' !== trim( $search ) ) {
            $like = esc_sql( '%' . $wpdb->esc_like( $search ) . '%' );
            $where .= " AND (visitor_id LIKE '$like' OR language LIKE '$like' OR messages LIKE '$like'";
            if ( ctype_digit( $search ) ) {
                $where .= ' OR user_id = ' . absint( $search );
            }
            $where .= ')';
        }

        return $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}aia_chat_history WHERE $where ORDER BY updated_at DESC", ARRAY_A );
    }

    private function find_conversation( $visitor_id, $user_id ) {
        global $wpdb;

        if ( ! empty( $user_id ) ) {
            $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}aia_chat_history WHERE user_id = %d ORDER BY updated_at DESC LIMIT 1", absint( $user_id ) ) );
            if ( $row ) {
                return $row;
            }
        }

        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}aia_chat_history WHERE visitor_id = %s ORDER BY updated_at DESC LIMIT 1", sanitize_text_field( $visitor_id ) ) );
    }
}
