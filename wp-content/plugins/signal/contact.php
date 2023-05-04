<?php
/*
Plugin Name: Contact
Plugin URI: https://github.com/pluginsWordpress/Contact/blob/main/Contact.php
Description: Plugin de Contact personnalisé pour WordPress
Version: 1.0
Author: Marouane
Author URI: https://github.com/marouane216
*/
// Fonction d'activation du plugin
function mon_plugin_activation()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        fullName varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        numero varchar(13) NOT NULL,
        commentaire varchar(255) NOT NULL,
        vue TINYINT NOT NULL DEFAULT '0',
        date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'mon_plugin_activation');

// Fonction de désactivation du plugin
function mon_plugin_desactivation()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
register_deactivation_hook(__FILE__, 'mon_plugin_desactivation');
function mon_plugin_shortcode_Contact()
{
    ob_start();
?>
    <style>
        .divForm {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .divForm form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            width: 100%;
        }

        .divForm form div {
            display: flex !important;
            flex-direction: row !important;
            width: 100%;
            justify-content: center;
        }

        .divForm form div label {
            width: 27%;
        }

        .divForm form div input,
        .divForm form div textarea {
            width: 43%;
        }

        .divForm form div textarea {
            resize: none;
            height: 7rem;
        }

        .Submit {
            background-color: #0d6efd;
            color: black;
            font-size: 1rem;
            width: 6rem !important;
            display: flex;
            justify-content: center;
            border: 1px solid;
            border-radius: 7px;
            cursor: pointer;
        }

        .Submit:hover {
            color: aliceblue;
        }
    </style>
    <div class="divForm">
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <div>
                <label for="fullName">Nom Complet:</label>
                <input type="text" name="fullName" id="fullName">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="numero">Numero Telephone:</label>
                <input type="numero" name="numero" id="numero">
            </div>
            <div>
                <label for="commentaire">Commentaire:</label>
                <textarea name="commentaire" id="commentaire"></textarea>
            </div>
            <div>
                <input type="hidden" name="action" value="mon_plugin_register">
                <input class="Submit" type="submit" value="Envoyer">
            </div>
        </form>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('mon_plugin_form', 'mon_plugin_shortcode_Contact');
function mon_plugin_register()
{
    ob_start();
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $commentaire = $_POST['commentaire'];

    $wpdb->insert(
        $table_name,
        array(
            'fullName' => $fullName,
            'email' => $email,
            'numero' => $numero,
            'commentaire' => $commentaire
        )
    );

    wp_redirect(home_url(''));
    return ob_get_clean();
}
add_action('admin_post_mon_plugin_register', 'mon_plugin_register');
function affiche_Contact_add_menu_page()
{
    add_menu_page(
        __('afficheContact', 'textdomain'),
        'Affichage Contact',
        'manage_options',
        'affiche_Contact',
        '',
        'dashicons-format-chat',
        6
    );
    add_submenu_page(
        'affiche_Contact',
        __('Books Shortcode Reference', 'textdomain'),
        __('Shortcode Reference', 'textdomain'),
        'manage_options',
        'affiche_Contact',
        'affiche_Contact_callback'
    );
}
add_action('admin_menu', 'affiche_Contact_add_menu_page');

function affiche_Contact_callback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $results = $wpdb->get_results("SELECT * FROM $table_name");
?>
    <style>
        #myTable {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
        }

        #myTable th,
        #myTable td {
            text-align: left;
            padding: 8px;
        }

        #myTable th {
            background-color: #f2f2f2;
        }

        #myTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #myTable tr:hover {
            background-color: #ddd;
        }

        #myTable tr {
            border-bottom: 1px solid black;
        }

        #myTable td,
        #myTable th {
            border-right: 1px solid black;
            padding: 5px;
            /* facultatif : pour ajouter de l'espace autour du contenu des cellules */
        }

        .actionDiv {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            width: 0rem;
            border-right: none !important;
        }

        .action {
            width: auto;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-sizing: border-box;
            border: 1.20968px solid #000000;
            border-radius: 4.83871px;
            color: white;
        }

        .delete {
            background-color: #FF0000;
        }

        .edit {
            background-color: #80FF00;
        }

        .edit a i {
            color: white;
        }

        .Role {
            background: #00d1ff;
        }

        .btnExport {
            background-color: green;
            border: 1px solid black;
            color: #ffffff;
            cursor: pointer;
        }

        .btnExport:hover {
            background-color: lime;
            color: black;
        }

        a {
            color: #ffb40a;
            text-decoration: none;
        }
    </style>
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th scope="col">Nom Complet</th>
                <th scope="col">Email</th>
                <th scope="col">Numero Telephone</th>
                <th scope="col">Commentaire</th>
                <th scope="col">Date</th>
                <th scope="col">Vue</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result) { ?>
                <tr>
                    <td><?= $result->fullName ?></td>
                    <td>
                        <a href="mailto:<?= $result->email ?>">
                            <?= $result->email ?>
                        </a>
                    </td>
                    <td><?= $result->numero ?></td>
                    <td><?= $result->commentaire ?></td>
                    <td><?= $result->date ?></td>
                    <td>
                        <?php
                        if ($result->vue == 0) {
                            echo 'Non Lue';
                        }
                        if ($result->vue == 1) {
                            echo 'Lue';
                        }
                        ?>
                    </td>
                    <td class="actionDiv">
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="delete_Contact">
                            <input type="hidden" name="id_contact" value="<?= $result->id ?>">
                            <button title="delete" type="submit" class="action delete">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.68 5H17.72V3.8C17.72 3.05739 17.3955 2.3452 16.8179 1.8201C16.2403 1.295 15.4569 1 14.64 1H9.36C8.54313 1 7.75972 1.295 7.18211 1.8201C6.6045 2.3452 6.28 3.05739 6.28 3.8V5H2.32C1.96991 5 1.63417 5.12643 1.38662 5.35147C1.13907 5.57652 1 5.88174 1 6.2C1 6.51826 1.13907 6.82348 1.38662 7.04853C1.63417 7.27357 1.96991 7.4 2.32 7.4H2.76V21C2.76 21.5304 2.99179 22.0391 3.40437 22.4142C3.81695 22.7893 4.37652 23 4.96 23H19.04C19.6235 23 20.1831 22.7893 20.5956 22.4142C21.0082 22.0391 21.24 21.5304 21.24 21V7.4H21.68C22.0301 7.4 22.3658 7.27357 22.6134 7.04853C22.8609 6.82348 23 6.51826 23 6.2C23 5.88174 22.8609 5.57652 22.6134 5.35147C22.3658 5.12643 22.0301 5 21.68 5ZM8.92 3.8C8.92 3.69391 8.96636 3.59217 9.04887 3.51716C9.13139 3.44214 9.2433 3.4 9.36 3.4H14.64C14.7567 3.4 14.8686 3.44214 14.9511 3.51716C15.0336 3.59217 15.08 3.69391 15.08 3.8V5H8.92V3.8ZM18.6 20.6H5.4V7.4H18.6V20.6ZM10.68 10.6V17C10.68 17.3183 10.5409 17.6235 10.2934 17.8485C10.0458 18.0736 9.71009 18.2 9.36 18.2C9.00991 18.2 8.67417 18.0736 8.42662 17.8485C8.17907 17.6235 8.04 17.3183 8.04 17V10.6C8.04 10.2817 8.17907 9.97652 8.42662 9.75147C8.67417 9.52643 9.00991 9.4 9.36 9.4C9.71009 9.4 10.0458 9.52643 10.2934 9.75147C10.5409 9.97652 10.68 10.2817 10.68 10.6ZM15.96 10.6V17C15.96 17.3183 15.8209 17.6235 15.5734 17.8485C15.3258 18.0736 14.9901 18.2 14.64 18.2C14.2899 18.2 13.9542 18.0736 13.7066 17.8485C13.4591 17.6235 13.32 17.3183 13.32 17V10.6C13.32 10.2817 13.4591 9.97652 13.7066 9.75147C13.9542 9.52643 14.2899 9.4 14.64 9.4C14.9901 9.4 15.3258 9.52643 15.5734 9.75147C15.8209 9.97652 15.96 10.2817 15.96 10.6Z" fill="white" />
                                </svg>

                            </button>
                        </form>
                        <?php if ($result->vue == 0) : ?>
                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type="hidden" name="action" value="lue_Contact">
                                <input type="hidden" name="id_contact" value="<?= $result->id ?>">
                                <button title="Lue?" class="action Role">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" fill="white" />
                                    </svg>
                                </button>
                            </form>
                        <?php endif ?>
                        <?php if ($result->vue == 1) : ?>
                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type="hidden" name="action" value="non_lue_Contact">
                                <input type="hidden" name="id_contact" value="<?= $result->id ?>">
                                <button title="Non Lue?" class="action Role">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_4)">
                                            <path d="M12 4C6.54545 4 1.88727 7.31733 0 12C1.88727 16.6827 6.54545 20 12 20C17.4545 20 22.1127 16.6827 24 12C22.1127 7.31733 17.4545 4 12 4ZM12 17.3333C8.98909 17.3333 6.54545 14.944 6.54545 12C6.54545 9.056 8.98909 6.66667 12 6.66667C15.0109 6.66667 17.4545 9.056 17.4545 12C17.4545 14.944 15.0109 17.3333 12 17.3333ZM12 8.8C10.1891 8.8 8.72727 10.2293 8.72727 12C8.72727 13.7707 10.1891 15.2 12 15.2C13.8109 15.2 15.2727 13.7707 15.2727 12C15.2727 10.2293 13.8109 8.8 12 8.8Z" fill="white" />
                                            <line x1="0.801388" y1="-0.801388" x2="24.8014" y2="23.1986" stroke="white" stroke-width="2.26667" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_4">
                                                <rect width="24" height="24" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                            </form>
                        <?php endif ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <button class="btnExport" onclick="exportTableToExcel('myTable')">Export to Excel</button>
    <script>
        function exportTableToExcel(tableID, filename = '') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
        }
    </script>
<?php
}
function delete_Contact()
{
    ob_start();
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $id = $_POST['id_contact'];

    $wpdb->get_results("DELETE FROM $table_name WHERE id = $id");

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = wp_get_referer();
        wp_redirect($referer);
        return ob_get_clean();
    }
}
add_action('admin_post_delete_Contact', 'delete_Contact');

function lue_Contact()
{
    ob_start();
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $id = $_POST['id_contact'];

    $wpdb->get_results("UPDATE $table_name SET vue = 1 WHERE id = $id");

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = wp_get_referer();
        wp_redirect($referer);
        return ob_get_clean();
    }
}
add_action('admin_post_lue_Contact', 'lue_Contact');
function non_lue_Contact()
{
    ob_start();
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact';

    $id = $_POST['id_contact'];

    $wpdb->get_results("UPDATE $table_name SET vue = 0 WHERE id = $id");

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = wp_get_referer();
        wp_redirect($referer);
        return ob_get_clean();
    }
}
add_action('admin_post_non_lue_Contact', 'non_lue_Contact');
?>