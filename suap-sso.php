<?php
/**
 * SUAP SSO
 *
 * Plugin Name: SUAP SSO
 * Description: Plugin de autenticação para Wordpress que usa o oAuth2 SSO do SUAP.
 * Plugin URI: https://github.com/cte-zl-ifrn/wordpress__plugin__suap-sso
 * Author: CTE-ZL-IFRN
 * Author URI: https://opensource.google.com/
 * Version: 0.1.1
 * Requires at least: 5.7
 * Requires PHP: 7.2
 * Text Domain: suap-sso
 * License: The MIT License (MIT)
 * License URI: https://mit-license.org/
 *
 * @copyright 2022 IFRN
 * @license   https://mit-license.org/ The MIT License (MIT)
 */

require_once __DIR__. '/settings.php';

if (is_admin()) {
    require_once __DIR__. '/admin.php';
}

function suap_sso_login_page() { 
    wp_safe_redirect(home_url('wp-content/plugins/suap-sso/login.php'));
    die();
    ?>

    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(https://ead.ifrn.edu.br/portal/wp-content/uploads/2022/10/ifrn-logo-marca-zl.png);
		height:61px;
		width:252px;
		background-size: 252px 61px;
		background-repeat: no-repeat;
        	padding-bottom: 00px;
        }
        .user-pass-wrap, #loginform > p, #wp-submit, .mo_oauth_or_division, #nav, .language-switcher {display: none}
        .submit {display: block !important;}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'suap_sso_login_page' );