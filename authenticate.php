<?php
require_once __DIR__. '/settings.php';

assert(in_array('code', $_GET), "O código de autenticação não foi informado.");

// autentica a requisição
$options = [
    'body' => [
        'grant_type' => 'authorization_code', 
        'code' => $_GET['code'], 
        'redirect_uri' => $base_authenticate_url, 
        'client_id' => $client_id, 
        'client_secret' => $client_secret
    ]
];
$response = wp_remote_post("$suap_base_url/o/token/", $options);
$auth_creditials = json_decode($response['body']);

// obtém os dados do usuário autenticado
$options = [
    'body' => [
        'scope' => $auth_creditials->scope
    ],
    'headers'=> [
        'Authorization' => 'Bearer ' . $auth_creditials->access_token, 
        'x-api-key' => $client_secret
    ]
];
$response = wp_remote_get("$suap_base_url/api/eu/", $options);
$user_data = json_decode($response['body']);

$username = $user_data->identificacao;
$user = get_user_by('login', $username);
if (!$user) {
    die("Usuário sem permissão de acessar este portal.");
}
// nome, primeiro_nome, ultimo_nome, campus, email_preferencial
// wp_update_user(['ID' => $user->id, 'user_login' => $username, 'user_nicename' => $username, 'user_email' => $user_data->email, 'user_email' => $user_data->email, 'display_name' => $user_data->nome]);
// add_user_meta( $user->id, 'first_name', $user_data->primeiro_nome );
// add_user_meta( $user->id, 'last_name', $user_data->ultimo_nome );
wp_set_current_user($user->id, $username);
wp_set_auth_cookie($user->id);
do_action( 'wp_login', $user->user_login, $user );
wp_safe_redirect(admin_url('/'));