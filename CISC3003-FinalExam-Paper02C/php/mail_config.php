<?php
const SMTP_HOST = 'smtp.gmail.com';
const SMTP_PORT = 465;
const SMTP_FROM_NAME = 'CISC3003 Paper02C Account System';

$localCredentials = __DIR__ . '/gmail_credentials.local.php';
if (file_exists($localCredentials)) {
    require $localCredentials;
}

function gmail_username(): string
{
    return getenv('GMAIL_USERNAME') ?: (defined('GMAIL_USERNAME') ? GMAIL_USERNAME : '');
}

function gmail_app_password(): string
{
    return getenv('GMAIL_APP_PASSWORD') ?: (defined('GMAIL_APP_PASSWORD') ? GMAIL_APP_PASSWORD : '');
}

function gmail_is_configured(): bool
{
    return gmail_username() !== '' && gmail_app_password() !== '';
}
?>
