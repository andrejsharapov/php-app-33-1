<?php
include_once __DIR__ . '/../../config/config.php';

$db_link = getDatabase() or die(mysqli_error($db_link));
$user_id = mysqli_real_escape_string($db_link, $_GET['user_id']);

$table_users = 'users';
$table_img = 'images';

$query = "SELECT * FROM $table_img RIGHT JOIN $table_users ON $table_img.user_id = $user_id";
$sql = mysqli_query($db_link, $query);

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
}

function getUserAvatar($user)
{
    if (empty($user["path"])) {
        return "/../../src/avatars/default.png";
    } else {
        return $user["path"];
    }
}

function getUserName($user)
{
    if (!empty($user['name'])) {
        return $user["name"];
    } else {
        return $user["email"];
    }
}

?>

<div class="flex flex-col h-full divide-y-2 divide-gray-200">
    <!-- user -->
    <div class="chat-user__info shrink flex gap-x-4 items-center justify-center hover:bg-gray-100 px-3 py-3">
        <img
                alt=""
                class="w-9 h-9 object-cover rounded-md border-2 border-gray-100"
                src="<?php echo getUserAvatar($row) ?>
        ">
        <div class="block text-sm text-gray-900 whitespace-nowrap font-bold">
            <?php echo getUserName($row) ?>
        </div>
    </div>

    <!-- chat messages -->
    <div class="chat-user__messages grow p-3 overflow-auto">
        <!-- get-chat.php -->
    </div>

    <!-- form to send message -->
    <form action="#"
          class="chat-user__form form-messages flex items-center gap-x-4 w-full justify-between p-3 bg-white">
        <input type="hidden" name="incoming_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="outgoing_id" value="<?php echo $user['id']; ?>">
        <label class="grow">
            <input
                    type="text"
                    name="message"
                    placeholder="Enter a message"
                    class="chat-user__form__input bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <button class="chat-user__form__send cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
            <svg width="24" height="24" viewBox="0 0 24 24">
                <path fill="white"
                      d="M22 5.5H9C7.9 5.5 7 6.4 7 7.5V16.5C7 17.61 7.9 18.5 9 18.5H22C23.11 18.5 24 17.61 24 16.5V7.5C24 6.4 23.11 5.5 22 5.5M22 16.5H9V9.17L15.5 12.5L22 9.17V16.5M15.5 10.81L9 7.5H22L15.5 10.81M5 16.5C5 16.67 5.03 16.83 5.05 17H1C.448 17 0 16.55 0 16S.448 15 1 15H5V16.5M3 7H5.05C5.03 7.17 5 7.33 5 7.5V9H3C2.45 9 2 8.55 2 8S2.45 7 3 7M1 12C1 11.45 1.45 11 2 11H5V13H2C1.45 13 1 12.55 1 12Z"/>
            </svg>
        </button>
    </form>
</div>

<script src="/assets/chat.js"></script>
