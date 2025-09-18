<?php
// deploy.php

// Seu segredo do GitHub (mesmo que você colocou no webhook)
$secret = 'R0berth#';

// Payload enviado pelo GitHub
$payload = file_get_contents('php://input');

// Cabeçalho enviado pelo GitHub
$hubSignature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';

if (!$hubSignature) {
    http_response_code(403);
    exit('Acesso negado: sem assinatura');
}

// Calcula hash com HMAC-SHA1
$hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);

// Compara de forma segura
if (!hash_equals($hash, $hubSignature)) {
    http_response_code(403);
    exit('Acesso negado: assinatura inválida');
}

// Caminho do repositório local no cPanel
$repo = '/home4/cass3268/git.softflare.com.br';

// Roda git pull
exec("cd $repo && git pull origin main");

// Log opcional
file_put_contents("$repo/deploy.log", date('Y-m-d H:i:s') . " Deploy executado\n", FILE_APPEND);

echo "Deploy realizado com sucesso!";
