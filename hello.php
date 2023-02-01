<?php
session_start();

$user = $_SESSION['user'];

if (!$user) {
    header('location: /');
}

$page = array(
  'title' => 'Hello, ' . ucfirst($user['name'] ?? "vk user №" . $user['id'])
);

?>

<?php include 'layouts/header.php'; ?>

<div class="flex divide-x-2 divide-gray-100">

    <main class="chat-page w-full flex flex-grow divide-x-2 divide-gray-200 overflow-hidden">
        <!-- sidebar -->
        <div id="sidebar-drawer"
             tabindex="-1"
             aria-labelledby="drawer-label"
             class="min-w-max left-0 h-full overflow-y-auto transition-transform w-80 bg-white dark:bg-gray-800"
        >
            <div class="flex items-center justify-between p-4 bg-gray-100 border-b-2 border-gray-200">
                <div class="text-xl font-bold">User list</div>
            </div>

            <ul class="user-list grid space-y-1 list-none list-inside dark:text-gray-400">
                <!-- user-list -->
            </ul>
        </div>

        <!-- content -->
        <div class="content grow w-full relative bg-gray-100">
            <?php
            if (isset($_GET['user_id']) && $user['id'] !== $_GET['user_id']) {
                include "layouts/components/chat.php";
            } else if ($user['id'] === $_GET['user_id']) {
                    echo '<div class="p-3 grid h-full place-content-center">';
                    echo '<span class="font-bold">Вы не можете отправлять себе сообщения, так как администратор не успел это проработать \'-__-</span>';
                    echo '<img src="src/hello.svg" alt="" class="max-w-lg mx-auto opacity-50">';
                    echo '</div>';
                } else {
                    echo '<img src="src/hello.svg" alt="" class="max-w-lg h-full mx-auto opacity-50">';
                }

            ?>
        </div>
    </main>

    <?php include 'layouts/components/aside.php'; ?>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
<script src="assets/users.js"></script>
