<?php

require_once __DIR__ . '/../dotenv.php';

define('URL', '/');
define('UPLOAD_MAX_SIZE', 1000000);
define('ALLOWED_TYPES', ['image/jpeg', 'image/png']);
define('UPLOAD_DIR', 'src/avatars/');
define('COMMENT_DIR', 'comments/');

/**
 * @return mysqli
 */
function getDatabase(): mysqli
{
    $db_host     = $_ENV['DB_HOST'];
    $dp_port     = $_ENV['DB_PORT'];
    $db_database = $_ENV['DB_DATABASE'];
    $db_username = $_ENV['DB_USERNAME'];
    $db_password = $_ENV['DB_PASSWORD'];

    return new mysqli($db_host, $db_username, $db_password, $db_database);
}
