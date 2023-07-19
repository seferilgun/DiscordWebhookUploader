<?php
session_start();

// Veritabanı bilgilerinizi girin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dcupload";

// Veritabanı bağlantısını oluşturun
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol edin
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Kayıt olma ve giriş işlemleri
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signup"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Veritabanında kullanıcının mevcut olup olmadığını kontrol edin
        $check_user_query = "SELECT * FROM users WHERE email = '$email'";
        $check_user_result = $conn->query($check_user_query);

        if ($check_user_result->num_rows > 0) {
            echo "<div class='alert alert-danger'>Bu e-posta adresi zaten kullanılıyor.</div>";
        } else {
            // Veritabanına kayıt ekleme
            $insert_user_query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

            if ($conn->query($insert_user_query) === TRUE) {
                $_SESSION["user_id"] = $conn->insert_id;
                header("Location: resim_yukle.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>HATA: Kayıt olma işlemi başarısız oldu.</div>";
            }
        }
    } elseif (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Kullanıcıyı veritabanında kontrol etme
        $check_user_query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $check_user_result = $conn->query($check_user_query);

        if ($check_user_result->num_rows > 0) {
            $user_row = $check_user_result->fetch_assoc();
            $_SESSION["user_id"] = $user_row["id"];
            header("Location: resim_yukle.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>HATA: Giriş başarısız oldu. Lütfen doğru e-posta ve şifre girin.</div>";
        }
    }
}

// Veritabanı bağlantısını kapatın
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kayıt Ol ve Giriş Yap Sayfası</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .wrapper {
            width: 300px;
            text-align: center;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: lightgrey;
            border-radius: 5px;
            border: 2px solid #323232;
            box-shadow: 4px 4px #323232;
        }

        .title {
            font-size: 25px;
            font-weight: 900;
            color: #323232;
        }

        .input-field {
            width: 250px;
            height: 40px;
            border-radius: 5px;
            border: 2px solid #323232;
            background-color: #fff;
            box-shadow: 4px 4px #323232;
            font-size: 15px;
            font-weight: 600;
            color: #323232;
            padding: 5px 10px;
            outline: none;
        }

        .input-field::placeholder {
            color: #666;
            opacity: 0.8;
        }

        .input-field:focus {
            border: 2px solid #2d8cf0;
        }

        .btn {
            width: 120px;
            height: 40px;
            border-radius: 5px;
            border: 2px solid #323232;
            background-color: #fff;
            box-shadow: 4px 4px #323232;
            font-size: 17px;
            font-weight: 600;
            color: #323232;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2d8cf0;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <div class="form-container">
                <div class="title">Giriş Yap</div>
                <form method="POST">
                    <input class="input-field" name="email" placeholder="E-posta" type="email" required>
                    <input class="input-field" name="password" placeholder="Şifre" type="password" required>
                    <button class="btn" name="login">Giriş Yap</button>
                </form>
            </div>
            <div class="form-container">
                <div class="title">Kayıt Ol</div>
                <form method="POST">
                    <input class="input-field" name="name" placeholder="İsim" type="text" required>
                    <input class="input-field" name="email" placeholder="E-posta" type="email" required>
                    <input class="input-field" name="password" placeholder="Şifre" type="password" required>
                    <button class="btn" name="signup">Kayıt Ol</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
