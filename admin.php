<?php
require_once dirname(dirname(dirname( __DIR__ ))) . '/wp-load.php';

function suap_sso_settings_init() {
    $page = 'suap_sso';
    $section = 'suap_sso';

    add_options_page("Configure o SUAP SSO", "SUAP SSO", 'manage_options', $page, 'suap_sso_options_page_html', 7);

    add_settings_section($section, 'SUAP SSO', 'suap_sso_section_callback', $page);

    register_setting($page, 'suap_sso-client_id');
    add_settings_field ('suap_sso-client_id', 'Client ID', 'suap_sso_client_id_callback', $page, $section, []);

    register_setting($page, 'suap_sso-client_secret');
    add_settings_field ('suap_sso-client_secret', 'Client Secret', 'suap_sso_client_secret_callback', $page, $section, []);

    register_setting($page, 'suap_sso-suap_base_url');
    add_settings_field ('suap_sso-suap_base_url', 'URL base do SUAP', 'suap_sso_suap_base_url_callback', $page, $section, []);
}


function suap_sso_section_callback( $args ) {
    ?>
        <p>Para obter o '<b>Client ID</b>' e o '<b>Client Secret</b>', acesse o seu SUAP, autentique-se e abra a URL 
         <b><?php echo get_option( 'suap_sso-suap_base_url' ) ?: '%suap_base_url%'; ?>/api/applications</b>. No SUAP, ao configurar a aplicações, 
         preencha os campos conforme sugerido abaixo:</p>
        <ol>
            <li><b>Client type:</b> <i>public</i></li>
            <li><b>Authorization grant type:</b> <i>authorization-code</i></li>
            <li><b>Redirect uris:</b> <i><?php echo home_url('/wp-content/plugins/suap-sso/authenticate.php') ?></i></li>
        </ol>
    <?php
}

function suap_sso_client_id_callback( $args ) {
    ?>
    <input id="suap_sso-client_id" name="suap_sso-client_id" value="<?php echo get_option( 'suap_sso-client_id' ); ?>" style="width: 100%;" >
    <p class='description'>Para sua segurança, evite usar o client_id em mais de uma instalação.</p>
    <?php
}

function suap_sso_client_secret_callback( $args ) {
    ?>
    <input id="suap_sso-client_secret" name="suap_sso-client_secret" value="<?php echo get_option( 'suap_sso-client_secret' ); ?>" style="width: 100%;" >
    <p class='description'>Para sua segurança, evite usar o client_secret em mais de uma instalação.</p>
    <?php
}

function suap_sso_suap_base_url_callback( $args ) {
    ?>
    <input id="suap_sso-suap_base_url" name="suap_sso-suap_base_url" value="<?php echo get_option( 'suap_sso-suap_base_url' ); ?>" style="width: 100%;"  >
    <p class='description'>Exemplo: https://suap.ifrn.edu.br.</p>
    <p class='description'>Para sua segurança, use https.</p>
    <p class='description'>Não coloque a barra ('/') no final.</p>
    <?php
}

function suap_sso_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'suap_sso_messages', 'suap_sso_message', __( 'Settings Saved', 'suap_sso' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'suap_sso_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "suap_sso"
            settings_fields( 'suap_sso' );
            // output setting sections and their fields
            // (sections are registered for "suap_sso", each field is registered to a specific section)
            do_settings_sections( 'suap_sso' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

add_action( 'admin_menu', 'suap_sso_settings_init' );
