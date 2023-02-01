<?php
session_start();

if (!isset($_SESSION['token'])) {
    $token = hash('gost-crypto', random_int(0, 999999));
} else {
    $token = $_SESSION['token'];
}

if (isset($_SESSION['user'])) {
    header('location: /hello.php');
}

$page = ['title' => 'Registration and login'];

include __DIR__ . '/layouts/header.php';
?>

<main class="flex-grow home-page">
    <div class="lg:absolute top-24 right-6 left-6 bg-blue-500 text-white mix-blend-multiply lg:rounded-lg">
        <div class="text-center text-5xl font-extrabold pt-3 pb-5 lg:pl-12">
            Welcome to <?php echo ucfirst($app_name); ?>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 items-stretch divide-x divide-2 w-full min-h-full bg-white bg-no-repeat bg-cover bg-center">
        <!-- register -->
        <div class="pb-12 pt-12 lg:pt-32 px-6 w-full mx-auto text-gray-800 transition ease-in-out delay-200 duration-300">
            <img src="src/signup.svg" class="hidden lg:block w-full max-w-xs mx-auto" alt="auth">

            <div class="container mx-auto max-w-lg">
                <h2 class="text-4xl mb-6 text-bold">Registration</h2>
                <form method="post" action="forms/reg.php" class="mx-auto">
                    <div class="w-full inline-flex flex-col gap-y-4">
<!--                        <label>Login-->
<!--                            <input type="text" name="login" placeholder="Login"-->
<!--                                   class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">-->
<!--                        </label>-->
                        <label>Email
                            <input type="email" name="email" placeholder="Email"
                                   class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </label>
                        <label>Password
                            <input type="password" name="password" placeholder="Password"
                                   class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </label>
                    </div>
                    <div class="w-full inline-flex justify-between">
                        <input type="submit"
                               value="Регистрация"
                               class="mt-4 cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        >
                    </div>
                </form>
            </div>

            <?php
            if (!empty($_SESSION['checkReg'])) {
                echo "<div class='snackbar shadow-md max-w-lg mx-auto mt-5 rounded p-3 border border-$_SESSION[errors]-200 bg-$_SESSION[errors]-50 text-$_SESSION[errors]-600 font-medium'>";
                echo $_SESSION['checkReg'];
                unset($_SESSION['checkReg']);
                echo '</div>';
            }
            ?>
        </div>

        <!-- auth -->
        <div class="pb-12 pt-12 lg:pt-32 px-6 w-full mx-auto text-gray-800 transition ease-in-out delay-200 duration-300">
            <img src="src/signin.svg" class="hidden lg:block w-full max-w-xs mx-auto" alt="login">

            <div class="container mx-auto max-w-lg">
                <h2 class="text-4xl mb-6 text-bold">Sign in</h2>
                <form method="post" action="forms/auth.php" class="mx-auto">
                    <div class="w-full inline-flex flex-col gap-y-4">
<!--                        <label>Login-->
<!--                            <input type="text" name="login" placeholder="Login"-->
<!--                                   class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">-->
<!--                        </label>-->
                        <label>Email
                            <input type="email" name="email" placeholder="Email"
                                   class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </label>
                        <label>Password
                            <input type="password" name="password" placeholder="Password"
                                   class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </label>
                        <input type="hidden" name="token" value="<? echo $token; ?>">
                    </div>
                    <div class="w-full inline-flex justify-between">
                        <input type="submit"
                               value="Вход"
                               class="mt-4 cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        >
                    </div>
                </form>
            </div>

            <?php
            if (!empty($_SESSION['checkAuth'])) {
                echo "<div class='snackbar shadow-md max-w-lg mx-auto mt-5 rounded p-3 border border-$_SESSION[errors]-200 bg-$_SESSION[errors]-50 text-$_SESSION[errors]-600 font-medium'>";
                echo $_SESSION['checkAuth'];
                unset($_SESSION['checkAuth']);
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>

<?php include 'layouts/footer.php'; ?>

<?php
$_SESSION["CSRF"] = $token;
?>
