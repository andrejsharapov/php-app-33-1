<?php
session_start();

include __DIR__ . '/../../database/db.php';

$db_link = getDatabase() or die(mysqli_error($db_link));

$table_users = 'users';
$table_img = 'images';

$query_image = "SELECT * FROM $table_img RIGHT JOIN $table_users ON $table_img.user_id = $table_users.id";
$query = mysqli_query($db_link, $query_image) or die(mysqli_error($db_link));
$output = '';

function getUserAvatar($user)
{
    if (empty($user['path'])) {
        return "/../../src/avatars/default.png";
    } else {
        return $user['path'];
    }
}

function getUserName($user)
{
    if ($user['name'] !== null) {
        return $user['name'];
    } else {
        return $user['email'];
    }
}

function userCheck($user) {
    if($user['id'] === $_SESSION['user']['id']) {
        return 'You';
    }
}

if (mysqli_num_rows($query) <= 1) {
    $output .= '
        <div class="p-3">
            No users to send messages.
        </div>
    ';
} elseif (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $output .= '<li class="flex gap-x-4 items-center hover:bg-gray-100 p-2">
        <img alt="" class="w-10 h-10 object-cover rounded-md border-2 border-gray-100" src="' . getUserAvatar($row) . '">
        <a href="hello.php?user_id=' . $row['id'] . '" title="" class="block text-sm text-gray-900 whitespace-nowrap">'
          . getUserName($row) . '<small class="block text-gray-400">' . userCheck($row) . '</small>
          </a>
        </li>';
    }
}

echo $output;
