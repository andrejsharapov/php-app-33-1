<?php
session_start();

require_once __DIR__ . '/../database/db.php';

$app_name = $_ENV['APP_NAME'];
$user = $_SESSION['user'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $page['title'] . ' | ' . $app_name; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/app.css">
</head>

<body class="m-0 min-h-screen flex flex-col dark:bg-gray-800 dark:text-gray-300">

<header class="flex flex-col sm:flex-row gap-y-4 justify-between items-center px-4 py-3 z-10 bg-white shadow-sm">

    <div></div>

    <div class="flex items-center divide-x">
        <?php
        $query = "SELECT * FROM " . $db_table . " ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

        if (!empty($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="px-4 py-1">New user: ';
                echo '<a href="/users.php" title="" class="font-bold text-gray-500 hover:text-gray-800">';
                echo '<strong class="text-green-500">' . lcfirst($row["email"]) . '</strong>';
                echo '</a>';
                echo '</div>';
            }
        }
        ?>

        <a href="/"
           title=""
           class="px-4 py-1 font-bold text-gray-500 hover:text-gray-800"
        >
            Chat
        </a>
        <a href="https://github.com/andrejsharapov/<?php echo $_ENV['APP_NAME']; ?>"
           title="GitHub project"
           target="_blank"
           class="px-4 py-1 font-bold text-gray-500 hover:text-gray-800"
        >
            GitHub
        </a>
    </div>
</header>
