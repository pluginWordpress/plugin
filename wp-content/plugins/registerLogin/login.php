<!-- get_results( "SELECT * FROM $table_name WHERE column1 = 'value1' AND column2 = 'value2'" ); -->
<?php
/*
Plugin Name: Login
Plugin URI: https://github.com/marouane216
Description: Plugin de login users personnalisé pour WordPress
Version: 1.0
Author: Marouane
Author URI: https://github.com/marouane216
*/

// Fonction d'activation du plugin
function mon_plugin_activation()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'usersCreated';

    
}
register_activation_hook(__FILE__, 'mon_plugin_activation');

// Fonction de désactivation du plugin
function mon_plugin_desactivation()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'usersCreated';

    
}
register_deactivation_hook(__FILE__, 'mon_plugin_desactivation');
?>