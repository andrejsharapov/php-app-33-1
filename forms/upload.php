<?php
session_start();

require __DIR__ . '/../config/config.php';

if (!empty($_FILES)) {
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];
        $name = $file['name'] ?? null;
        $size = $file['size'] ?? null;
        $type = $file['type'] ?? null;
        $tmp = $file['tmp_name'] ?? null;
        $path = '/../' . UPLOAD_DIR . $name;
        $errors = [];

        if (!move_uploaded_file($tmp, __DIR__ . $path)) {
            $errors[] = 'Файл не был загружен на сервер. Причина:';
        }

        if ($size > UPLOAD_MAX_SIZE) {
            $errors[] = 'Недопустимый размер файла ' . $name;
        }

        if (!in_array($type, ALLOWED_TYPES)) {
            $errors[] = 'Недопустимый формат файла ' . $name;
        }

        $db_link = getDatabase() or die(mysqli_error($db_link));

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        mysqli_query($db_link, "SET NAMES 'utf8'");

        // set database table
        $db_table = 'images';
        $user_id = (int)$_SESSION['user']['id'];

        // set query from database
        $query = "INSERT INTO " . $db_table . " (path, user_id) VALUES ('$path', '$user_id')";
        $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

        $join_table = 'users';
        $query = mysqli_query($db_link, "SELECT * FROM $db_table JOIN $join_table ON $db_table.user_id = $join_table.id");
        $counter_row = mysqli_query($db_link, "SELECT * FROM $db_table WHERE user_id = $user_id");

        // replace user image
        if (mysqli_num_rows($counter_row) >= 1) {
            mysqli_query($db_link, "DELETE FROM $db_table WHERE user_id = $user_id");

            $query = "INSERT INTO " . $db_table . " (path, user_id) VALUES ('$path', '$user_id')";
            $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
        }
        //end

        $q_rows = mysqli_query($db_link, "SELECT count(*) FROM " . $db_table);
        $row_cnt = mysqli_num_rows($q_rows);
    }

    $redirect = '/profile.php';

    header("location: $redirect");
}
