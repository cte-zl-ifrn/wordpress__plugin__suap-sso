<?php
require_once dirname(dirname(dirname( __DIR__ ))) . '/wp-load.php';

$original_url = urlencode(in_array('next', $_GET) ? $_GET['next'] : admin_url());
$base_authenticate_url = home_url('wp-content/plugins/suap-sso/authenticate.php');
$authenticate_url = urlencode($base_authenticate_url . "?next={$original_url}");

$client_id=get_option( 'suap_sso-client_id' );
$client_secret=get_option( 'suap_sso-client_secret' );
$suap_base_url = get_option( 'suap_sso-suap_base_url' );
