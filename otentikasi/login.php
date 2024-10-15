<?php
session_start();
include "../db/koneksi.php";
include "../fungsi.php";

if (!empty($_SESSION["username"]) || !empty($_SESSION["email"]) || !empty($_SESSION["password"])) {
    header("Location: ../index.php");
}

if (isset($_POST["login"])) {
    // var_dump($_POST);
    // die;
    if (login($_POST) > 0) {
        echo "
        <script>
            alert('Berhasil login');
            window.location.href='../index.php';
        </script>
    ";
    } else {
        echo "
        <script>
            alert('Email atau Password salah');
        </script>
    ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/bootstrap.css">
    <link rel="stylesheet" href="../asset/css/style.css">
    <!-- Bs Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Login - Macro Store Computer</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-1 border-0">
        <div class="container justify-content-center justify-content-md-between align-items-center">
            <a class="navbar-brand" href="../index.php">Macro Store Computer</a>
            <span class="ln-30 fw-400">Belum punya akun? <a href="registrasi.php">Registrasi</a></span>
        </div>
    </nav>
    <section class="auth">
        <div class="container">
            <div class="row justify-content-center align-items-center px-3">
                <div class="col-12 col-md-6 col-lg-5 col-xl-4 my-4 mb-lg-0 text-center text-md-start">
                    <img src="../asset/img/login-dk.svg" alt="icon">
                </div>
                <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                    <div class="mb-4 text-md-start text-center">
                        <h3>Login ke Macro Store Computer</h3>
                        <p>Selamat datang di Macro Store Computer. Masukan email anda untuk memulai aplikasi.</p>
                    </div>
                    <form action="" method="post">
                        <div class="mb-2">
                            <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Email" required>
                        </div>
                        <div class="mb-2">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-2">
                            <button type="submit" name="login" class="btn btn-green w-100 fw-500">Login</button>
                        </div>
                    </form>
                    <p class="text-center">Belum punya akun? <a href="registrasi.php" class="text-green">Registrasi</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include "../footer.php" ?>

    <script src="../asset/js/bootstrap.js"></script>
    <script src="../asset/js/script.js"></script>
</body>

</html>