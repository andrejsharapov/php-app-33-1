<?php
session_start();

include_once __DIR__ . '/../../config/config.php';

if (isset($_SESSION['user']['id'])) {
    $db_link = getDatabase() or die(mysqli_error($db_link));

    $table_msg = 'messages';
    $table_img = 'images';

    $incoming_id = mysqli_real_escape_string($db_link, $_POST['incoming_id']);
    $outgoing_id = mysqli_real_escape_string($db_link, $_POST['outgoing_id']);

    $output = '';

    $query = "SELECT * FROM $table_msg LEFT JOIN $table_img ON $table_img.user_id = $table_msg.outgoing_msg_id WHERE outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id' OR outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id' GROUP BY msg_id";
    $result = mysqli_query($db_link, $query);

    function getUserAvatar($user)
    {
        if (empty($user['path'])) {
            return "/../../src/avatars/default.png";
        } else {
            return $user['path'];
        }
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '
                    <div class="flex items-end">
                        <div class="outgoing_msg mb-5 ml-auto w-min px-3 py-2 shadow-md rounded-t-2xl rounded-bl-2xl bg-gray-700 text-white">
                            <p>' . $row['msg'] . ' </p>
                        </div>
                        <img alt="" class="w-8 h-8 object-cover rounded-full border-2 border-gray-100 ml-2" src="' . getUserAvatar($row) . '">
                    </div>
                ';
            } else {
                $output .= '
                    <div class="flex items-end">
                        <img alt="" class="w-8 h-8 object-cover rounded-full border-2 border-gray-100 mr-2" src="' . getUserAvatar($row) . '">
                        <div class="incoming_msg mb-5 mr-auto w-min px-3 py-2 shadow-md rounded-t-2xl rounded-br-2xl bg-white">
                            <p>' . $row['msg'] . ' </p>
                        </div>
                    </div>
                ';
            }
        }
    }
    echo $output;
} else {
    header('location: /');
}
