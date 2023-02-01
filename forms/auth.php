<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database/db.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$name = $_POST['email'];
$password = !empty($_POST['password']) ? openssl_digest($_POST['password'], "sha512") : null;
$token = $_POST['token'];

// check token
if ($_POST["token"] == $_SESSION["CSRF"]) {
    // get user info
    $checkUser = "SELECT * FROM " . $db_table . " WHERE `email` = '$name' AND `password` = '$password'";
    $auth = mysqli_query($db_link, $checkUser) or die(mysqli_error($db_link));

    // check user in database
    if (mysqli_num_rows($auth) > 0) {
        $user = mysqli_fetch_assoc($auth);

        // write data to session
        $_SESSION['user'] = [
          'id' => $user['id'],
          'name' => $user['name'],
          'email' => $user['email'],
          'password' => openssl_digest($user['password'], "sha512"),
          'date' => $user['date'],
          'role' => $user['role'],
        ];

        if (isset($_SESSION['user'])) {
            $_SESSION['checkAuth'] = 'Авторизация прошла успешно.';
            $_SESSION['errors'] = 'green';
        }

        header('location: /hello.php');
    } else {
        $_SESSION['errors'] = 'red';
        $checkUserName = "SELECT * FROM " . $db_table . " WHERE `name` = '$name'";
        $userName = mysqli_query($db_link, $checkUserName) or die(mysqli_error($db_link));

        if (mysqli_num_rows($userName) > 0) {
            $_SESSION['checkAuth'] = 'Введен не правильный пароль.';

            // create new logger
            $log = new Logger('AUTH_LOGGER');

            // set handlers
            $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/auth.log', Logger::INFO));

            // add records
            $log->info('auth errors:', array('user' => $name, 'datetime' => (new DateTime())->format('Y-m-d H:i:s'), 'password' => $password));
        } else {
            $_SESSION['checkAuth'] = 'Не верный логин или пароль.';
        }

        header('location: /');
    }
}
