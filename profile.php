<?php
session_start();

$user = $_SESSION['user'];
$page = array(
    'title' => ucfirst($user['name'] ?? "user #" . $user['id']) ?? 'Profile'
);
$user = $_SESSION['user'];

require __DIR__ . "/forms/upload.php";
require __DIR__ . "/layouts/header.php";

if (!isset($user)) {
    header('location: /');
}

$db_link = getDatabase() or die(mysqli_error($db_link));

$table_users = 'users';
$table_img = 'images';

$query_image = "SELECT * FROM $table_img RIGHT JOIN $table_users ON $table_img.user_id = $table_users.id";
$query = mysqli_query($db_link, $query_image) or die(mysqli_error($db_link));

for (
  $data = [];
  $row = mysqli_fetch_assoc($query);
  $data[] = $row
) {
}
?>

<main class="w-full h-full grid place-content-center flex-grow">
    <!-- image -->
    <div class="flex items-center gap-4 mb-6">
        <?php
        foreach ($data as $key => $val) {
            if ($user['id'] === $val['id']) {
                echo '<div class="flex w-full gap-x-4 items-center">';
                if (!empty($val['path'])) {
                    echo '<img class="w-48 mx-auto object-cover rounded-md border-2 border-gray-100" src="';
                    echo $val['path'];
                    echo '">';
                } else {
                    echo '<img alt="" class="w-48 mx-auto object-cover rounded-md border-2 border-gray-100" src="/src/avatars/default.png">';
                }

                echo '</div>';
            }
        }
        ?>
    </div>

    <!-- welcome message -->
    <div class="mb-6 text-center">
        <?php if (isset($user)): ?>
            <h1 class="text-2xl font-bold mb-4">
                <?php
                if ($user['name'] !== null) {
                    echo ucfirst($user['name']);
                } else {
                    echo $user['email'];
                }
                ?>, добро пожаловать! </h1>

            <p>Здесь вы можете добавить/изменить свой никнейм и загрузить изображение.</p>

        <?php else:
            $redirect = '/';

            header("location: $redirect");
            exit;
            ?>
        <?php endif; ?>
    </div>

    <!-- nickname -->
    <form action="forms/nickname.php"
          method="post"
          enctype="multipart/form-data"
          class="w-full mx-auto flex flex-col gap-5 mb-8"
    >
        <div>
            <div class="w-full flex gap-x-4 items-end">
                <label class="grow">
                    <input type="text"
                           name="login"
                           placeholder="Set nickname"
                           class="mt-2 appearance-none bg-gray-200 border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                </label>
                <input type="submit"
                       value="Готово"
                       class="cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                >
            </div>
            <small>Чтобы изменения вступили в силу, <a href="/forms/logout.php" title="Sign out"
                                                       class="font-bold text-blue-600 hover:text-blue-800">
                    выйдите из аккаунта
                </a> и войдите снова.</small>
        </div>


        <?php
        if (!empty($_SESSION['nickname'])) {
            echo "<div class='snackbar shadow-md max-w-lg mx-auto mt-5 rounded p-3 border border-$_SESSION[errors]-200 bg-$_SESSION[errors]-50 text-$_SESSION[errors]-600 font-medium'>";
            echo $_SESSION['nickname'];
            unset($_SESSION['nickname']);
            echo '</div>';
        }
        ?>
    </form>

    <!-- upload -->
    <form
            action="/forms/upload.php"
            method="post"
            enctype="multipart/form-data"
            class="w-full flex gap-5 items-start"
    >
        <div class="grow">
            <div class="column">
                <label class="block w-full h-10 custom-file-label cursor-pointer bg-gray-200 border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       for="customFile" data-browse="Select">
                    <span class="text-gray-700">Select image</span>
                    <input
                            id="customFile"
                            type="file"
                            name="file"
                            class="hidden"
                    >
                </label>
            </div>
            <div class="column">
                <small>
                    Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.<br/>
                    Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
                </small>
            </div>
        </div>
        <div class="column flex justify-between items-center">
            <button
                    type="submit"
                    name="submit"
                    class="cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
            >
                Загрузить
            </button>
        </div>
    </form>

    <?php if (!empty($_FILES) && !empty($errors)): ?>
        <ul class="max-w-md mx-auto mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($_FILES) && empty($errors)): ?>
        <div class="max-w-md mx-auto mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            Файл успешно загружен!
        </div>
    <?php endif; ?>

</main>

<?php //include 'layouts/footer.php'; ?>
