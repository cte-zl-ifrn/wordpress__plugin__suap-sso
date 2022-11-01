<?php
require_once __DIR__. '/settings.php';
wp_redirect("$suap_base_url/o/authorize/?response_type=code&client_id=$client_id&redirect_uri={$base_authenticate_url}");
