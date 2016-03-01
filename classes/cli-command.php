<?php

namespace WP_Background_Processing;

use WP_CLI;
use WP_CLI_Command;

/**
 * Manage queue.
 *
 * @package wp-cli
 */
class CLI_Command extends WP_CLI_Command {

	/**
	 * Creates the queue table.
	 *
	 * @subcommand create-table
	 */
	public function create_table( $args, $assoc_args = array() ) {
		global $wpdb;

		$wpdb->hide_errors();

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$wpdb->prefix}queue (
				id bigint(20) NOT NULL AUTO_INCREMENT,
                action varchar(255) NOT NULL,
                data longtext NOT NULL,
                locked tinyint(1) NOT NULL DEFAULT 0,
                locked_at datetime DEFAULT NULL,
                created_at datetime NOT NULL,
                PRIMARY KEY  (id)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );

		WP_CLI::success( "Table {$wpdb->prefix}queue created." );
	}

}