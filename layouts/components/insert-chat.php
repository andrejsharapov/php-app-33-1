<?php
session_start();

include_once __DIR__ . '/../../config/config.php';

if (isset($_SESSION['user']['id'])) {
    $db_link = getDatabase() or die(mysqli_error($db_link));
    $db_table = 'messages';

    $incoming_id = mysqli_real_escape_string($db_link, $_POST['incoming_id']);
    $outgoing_id = mysqli_real_escape_string($db_link, $_POST['outgoing_id']);
    $message = mysqli_real_escape_string($db_link, $_POST['message']);
    $date = (new DateTime())->format('Y-m-d H:i:s') ?? null;

    if (!empty($message)) {
        $query = "INSERT INTO " . $db_table . " (incoming_msg_id, outgoing_msg_id, msg, date) VALUES ('$incoming_id', '$outgoing_id', '$message', '$date')";
        $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
    }
} else {
    header('location: /');
}
