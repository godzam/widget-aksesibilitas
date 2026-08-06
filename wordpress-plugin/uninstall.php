<?php
/**
 * Dijalankan saat plugin dihapus dari WordPress.
 * Membersihkan semua data yang disimpan plugin ini.
 */
defined('WP_UNINSTALL_PLUGIN') || exit;

delete_option('wak_settings');
