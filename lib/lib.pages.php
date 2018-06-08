<?php
if (!defined('ABSPATH')) die('You do not have sufficient permissions to access this file.');

/***** Přidání stránek do menu v administraci *************************/
function WPHE_admin_menu()
{
    global $WPHE_dirname, $WPHE_dirurl;
    if(current_user_can('activate_plugins')){
		add_menu_page('Htaccess File Editor', 'Htaccess', 'activate_plugins', $WPHE_dirname, 'WPHE_view_page', $WPHE_dirurl.'assets/images/htfe-mini.png');
		htfe_add_page('Htaccess Editor','Htaccess Editor', 'activate_plugins', $WPHE_dirname, 'WPHE_view_page');
		htfe_add_page(__('Backup', 'wphe'),__('Backup', 'wphe'), 'activate_plugins', $WPHE_dirname.'_backup', 'WPHE_view_page');

		// přidání css stylu do administrace
		wp_enqueue_style('htfe-style', $WPHE_dirurl.'assets/css/htaccess-file-editor.css');
	}
	unset($WPHE_dirname);
	unset($WPHE_dirurl);
}

/***** Zobrazení stránky podle požadavku ******************************/
function WPHE_view_page()
{
	global $WPHE_dirname, $WPHE_root, $WPHE_dirurl, $WPHE_version;

    switch (strip_tags(addslashes($_GET['page'])))
	{
		case $WPHE_dirname:
			if(file_exists($WPHE_root.'pages/htfe-dashboard.php')){
				require $WPHE_root.'pages/htfe-dashboard.php';
			}else{
				wp_die(__('Fatal error: Plugin <strong>Htaccess File Editor</strong> is corrupted', 'wphe'));
			}
		break;
		case $WPHE_dirname.'_backup':
			if(file_exists($WPHE_root.'pages/htfe-backup.php')){
				require $WPHE_root.'pages/htfe-backup.php';
			}else{
				wp_die(__('Fatal error: Plugin <strong>Htaccess File Editor</strong> is corrupted', 'wphe'));
			}
		break;
		default:
		    if(file_exists($WPHE_root.'pages/htfe-dashboard.php')){
				require $WPHE_root.'pages/htfe-dashboard.php';
			}else{
				wp_die(__('Fatal error: Plugin <strong>Htaccess File Editor</strong> is corrupted', 'wphe'));
			}
		break;
	}

	unset($WPHE_dirname);
	unset($WPHE_root);
	unset($WPHE_dirurl);
	unset($WPHE_version);
}

/***** Pomocná funkce pro vytvoření menu ******************************/
function htfe_add_page($page_title, $menu_title, $access_level, $file, $function = '')
{
	global $WPHE_dirname;
	add_submenu_page($WPHE_dirname, $page_title, $menu_title, $access_level, $file, $function);

	unset($WPHE_dirname);
	unset($page_title);
	unset($menu_title);
	unset($access_level);
	unset($file);
	unset($function);
}
