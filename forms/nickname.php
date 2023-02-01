<?php
session_start();

require __DIR__ . '/../config/config.php';

$user = $_SESSION['user'];
$login = $_POST['login'] ?? null;
$user['name'] = $login ?? null;
$db_link = getDatabase() or die(mysqli_error($db_link));
$db_table = 'users';
$user_id = (int)$user['id'] ?? null;
$query = "SELECT * FROM " . $db_table . " WHERE id = " . $user_id;
$get_user_by_id = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

if (empty($login)) {
    $_SESSION['errors'] = 'red';
    $_SESSION['nickname'] = 'Поле не заполнено.';
} else {
    // check nickname in database
    $findUserName = "SELECT * FROM $db_table WHERE name = '$user[name]'";
    $result = mysqli_query($db_link, $findUserName) or die(mysqli_error($db_link));
    $rows = mysqli_num_rows($result) > 0;

    if ($rows) {
        $_SESSION['nickname'] = 'Пользователь с таким ником уже существует.';
        $_SESSION['errors'] = 'yellow';
    } else {

        // replace username if not empty
        if (mysqli_num_rows($get_user_by_id) > 0) {
            mysqli_query($db_link, "UPDATE $db_table SET name = '$login' WHERE id = $user_id");
        }

        $query = "UPDATE $db_table SET name = '$login' WHERE id = $user_id";
        $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

        unset($_SESSION['errors']);

        if ($query) {
            $_SESSION['nickname'] = 'Никнейм успешно установлен.';
            $_SESSION['errors'] = 'green';
        }
    }
}

$redirect = '/profile.php';

header("location: $redirect");