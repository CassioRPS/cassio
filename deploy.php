<?php
$secret = 'R0berth#';
$payload = file_get_contents('php://input');
$signature = 'sha1=' . hash_hmac('sha1', $payload, $secret);

if (!hash_equals($signature, $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '')) {
    http_response_code(403);
    exit('Acesso negado');
}

$repo = '/home4/cass3268/git.softflare.com.br';

exec("cd $repo && git pull origin main");

file_put_contents("$repo/deploy.log", date('Y-m-d H:i:s') . " Deploy executado\n", FILE_APPEND);