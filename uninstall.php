<?php

if ( !defined('WP_UNINSTALL_PLUGIN') || !current_user_can( 'delete_plugins' ) ) {
    exit();
}
delete_option('widget-easy_vbox7');

?>