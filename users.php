<?php
session_start();

$page = array(
  'title' => 'User list'
);

include __DIR__ . '/layouts/header.php';

$query = "SELECT * FROM " . $db_table . " WHERE id > 0";
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
?>

    <main class="w-full h-full flex items-center flex-grow">
        <div class="w-4/5 mx-auto overflow-y-hidden grid divide-y-2 divide-gray-200">
            <div class="min-w-full grid grid-cols-5">
                <div class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Id</div>
                <div class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</div>
                <div class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Email</div>
                <div class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Role</div>
            </div>

            <?php
            foreach ($data as $key => $val) {
                echo '<div class="min-w-full grid grid-cols-5">';
                echo "<div class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>" . "#" . $val['id'] . "</div>";
                echo "<div class='text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap'>" . $val['name'] . "</div>";
                echo "<div class='text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap'>" . $val['email'] . "</div>";
                echo "<div class='text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap'>" . $val['role'] . "</div>";
                echo '</div>';
            }
            ?>
        </div>
    </main>

<?php
include './layouts/footer.php';
