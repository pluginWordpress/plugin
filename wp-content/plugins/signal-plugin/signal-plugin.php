<?php
/*
Plugin Name: Mon Plugin de Signal
Plugin URI: https://example.com/
Description: Plugin de signal personnalisé pour WordPress
Version: 1.0
Author: marouane
Author URI: https://example.com/
*/

// Fonction d'activation du plugin
function mon_plugin_activation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signaux';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nom varchar(50) NOT NULL,
        prenom varchar(50) NOT NULL,
        email varchar(50) NOT NULL,
        type_signal varchar(50) NOT NULL,
        raison varchar(255) NOT NULL,
        commentaire text NOT NULL,
        date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook( __FILE__, 'mon_plugin_activation' );

// Fonction de désactivation du plugin
function mon_plugin_desactivation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'signaux';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
register_deactivation_hook( __FILE__, 'mon_plugin_desactivation' );

// Fonction pour afficher le formulaire de signal
function mon_plugin_shortcode() {
    ob_start();
    ?>
<form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
    <input type="hidden" name="action" value="mon_plugin_signal">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom">
    <label for="prenom">Prenom:</label>
    <input type="text" name="prenom" id="prenom">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <label for="type_signal">Type de signal:</label>
    <select name="type_signal" id="type_signal">
        <option value="spam">Spam</option>
        <option value="abus">Abus</option>
        <option value="autre">Autre</option>
    </select>
    <label for="raison">Raison:</label>
    <input type="text" name="raison" id="raison">
    <label for="commentaire">Commentaire:</label>
    <textarea name="commentaire" id="commentaire"></textarea>
    <input type="submit" value="Envoyer">
</form>
<?php
return ob_get_clean();
}
add_shortcode( 'mon_plugin_form', 'mon_plugin_shortcode' );

// Fonction pour enregistrer le signal dans la base de données
function mon_plugin_signal() {
global $wpdb;
$table_name = $wpdb->prefix . 'signaux';


$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$type_signal = $_POST['type_signal'];
$raison = $_POST['raison'];
$commentaire = $_POST['commentaire'];

$wpdb->insert(
    $table_name,
    array(
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'type_signal' => $type_signal,
        'raison' => $raison,
        'commentaire' => $commentaire
    )
);

wp_redirect( home_url() );
exit;
}
add_action( 'admin_post_nopriv_mon_plugin_signal', 'mon_plugin_signal' );
add_action( 'admin_post_mon_plugin_signal', 'mon_plugin_signal' );