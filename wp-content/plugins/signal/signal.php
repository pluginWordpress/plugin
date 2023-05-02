<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
/*
Plugin Name: Signal
Plugin URI: https://github.com/pluginsWordpress/Signal/blob/main/signal.php
Description: Plugin de signal personnalisé pour WordPress
Version: 1.0
Author: Marouane
Author URI: https://github.com/marouane216
*/
// Fonction d'activation du plugin
function mon_plugin_activation()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'signal';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        fullName varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        numero varchar(13) NOT NULL,
        commentaire varchar(255) NOT NULL,
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
    $table_name = $wpdb->prefix . 'signal';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
register_deactivation_hook(__FILE__, 'mon_plugin_desactivation');
function signal_add_menu_page()
{
    add_menu_page(
        __('Signal', 'textdomain'),
        'Signal',
        'manage_options',
        'Signal',
        '',
        'dashicons-admin-plugins',
        6
    );
    add_submenu_page(
        'Signal',
        __('Books Shortcode Reference', 'textdomain'),
        __('Shortcode Reference', 'textdomain'),
        'manage_options',
        'Signal',
        'Signal_callback'
    );
}
add_action('admin_menu', 'signal_add_menu_page');

function Signal_callback()
{
?>
    <style>
        .form {
            margin-top: 10rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 50%;
            margin: 0 25%;
            justify-content: center;
        }

        form div {
            display: flex;
            flex-direction: row;
            justify-content: start;
        }

        form div label,
        form div input {
            cursor: pointer;
        }

        .Submit {
            background-color: #0d6efd;
            color: black;
            font-size: 1rem;
            width: 6rem;
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
    <form class="form" id="form">
        <div>
            <input type="radio" name="fullName" id="fullName">
            <label class="labelForm" for="fullName">Nom Complet:</label>
        </div>
        <div>
            <input type="radio" name="email" id="email">
            <label class="labelForm" for="email">Email:</label>
        </div>
        <div>
            <input type="radio" name="commentaire" id="commentaire">
            <label class="labelForm" for="commentaire">Commentaire:</label>
        </div>
        <div>
            <input type="radio" name="numero" id="numero">
            <label class="labelForm" for="numero">Numero Telephone:</label>
        </div>

        <input class="Submit" type="submit" value="Save">
    </form>
    <script>
        var form = document.getElementById('form')
        form.addEventListener('submit', event => {
            event.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            if (data.fullName == 'on') {
                var fullName = `<div>
                                    <label for="fullName">Nom Complet:</label>
                                    <input type="text" name="fullName" id="fullName">
                                </div>`
            } else {
                var fullName = `<input type="hidden" value=' ' name="fullName" id="fullName">`
            }
            if (data.email == 'on') {
                var emailInput = `<div>
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email">
                                </div>`
            } else {
                var emailInput = `<input type="hidden" value=' ' name="email" id="email">`
            }
            if (data.numero == 'on') {
                var numeroInput = `<div>
                                    <label for="numero">Numero Telephone:</label>
                                    <input type="numero" name="numero" id="numero">
                                </div>`
            } else {
                var numeroInput = `<input type="hidden" value=' ' name="numero" id="numero">`
            }
            if (data.commentaire == 'on') {
                var commentaireInput = `<div>
                                    <label for="commentaire">Commentaire:</label>
                                    <textarea name="commentaire" id="commentaire"></textarea>
                                </div>`
            } else {
                var commentaireInput = `<input type="hidden" value=' ' name="commentaire" id="commentaire">`
            }
            var formSelected = `<div>
                                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                        ${fullName}
                                        ${emailInput}
                                        ${numeroInput}
                                        ${commentaireInput}
                                        <div>
                                            <input type="hidden" name="action" value="mon_plugin_register">
                                            <input class="Submit" type="submit" value="Envoyer">
                                        </div>
                                    </form>
                                </div>`
            localStorage.setItem("formSelected", formSelected)
            location.reload();
        })
    </script>
<?php
}
function mon_plugin_shortcode_signal()
{
    ob_start();
?>
    <style>
        p div {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        p div form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            width: 100%;
        }

        p div form div {
            display: flex !important;
            flex-direction: row !important;
            width: 100%;
        }

        p div form div label {
            width: 27%;
        }

        p div form div input,
        p div form div textarea {
            width: 43%;
        }

        p div form div textarea {
            resize: none;
            height: 7rem;
        }

        .Submit {
            background-color: #0d6efd;
            color: black;
            font-size: 1rem;
            width: 6rem;
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
    <p id="p"></p>
    <script>
        var p = document.getElementById('p')
        var formSelected = localStorage.getItem("formSelected")
        p.innerHTML = formSelected
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('mon_plugin_form', 'mon_plugin_shortcode_signal');
function mon_plugin_register()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'signal';


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
    exit;
}
add_action('admin_post_mon_plugin_register', 'mon_plugin_register');
function affiche_signal_add_menu_page()
{
    add_menu_page(
        __('afficheSignal', 'textdomain'),
        'Affichage Signal',
        'manage_options',
        'affiche_Signal',
        '',
        'dashicons-format-gallery',
        6
    );
    add_submenu_page(
        'affiche_Signal',
        __('Books Shortcode Reference', 'textdomain'),
        __('Shortcode Reference', 'textdomain'),
        'manage_options',
        'affiche_Signal',
        'affiche_Signal_callback'
    );
}
add_action('admin_menu', 'affiche_signal_add_menu_page');

function affiche_Signal_callback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'signal';

    $results = $wpdb->get_results("SELECT * FROM $table_name");
?>
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th scope="col">Nom Complet</th>
                <th scope="col">Email</th>
                <th scope="col">Numero Telephone:</th>
                <th scope="col">Commentaire</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result) { ?>
                <tr>
                    <td><?= $result->fullName ?></td>
                    <td><?= $result->email ?></td>
                    <td><?= $result->numero ?></td>
                    <td><?= $result->commentaire ?></td>
                    <td><?= $result->date ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <button onclick="exportTableToExcel('myTable')">Export to Excel</button>
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
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">