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

// Kayıt olma işlemi
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
}

// Veritabanı bağlantısını kapatın
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kayıt Ol Sayfası</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            --input-focus: #2d8cf0;
            --font-color: #323232;
            --font-color-sub: #666;
            --bg-color: #fff;
            --main-color: #323232;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .flip-card__inner {
            width: 300px;
            height: 350px;
            position: relative;
            background-color: transparent;
            perspective: 1000px;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .flip-card__front,
        .flip-card__back {
            padding: 20px;
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: center;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            background: lightgrey;
            gap: 20px;
            border-radius: 5px;
            border: 2px solid var(--main-color);
            box-shadow: 4px 4px var(--main-color);
        }

        .flip-card__back {
            width: 100%;
            transform: rotateY(180deg);
        }

        .flip-card__form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .title {
            margin: 20px 0 20px 0;
            font-size: 25px;
            font-weight: 900;
            text-align: center;
            color: var(--main-color);
        }

        .flip-card__input {
            width: 250px;
            height: 40px;
            border-radius: 5px;
            border: 2px solid var(--main-color);
            background-color: var(--bg-color);
            box-shadow: 4px 4px var(--main-color);
            font-size: 15px;
            font-weight: 600;
            color: var(--font-color);
            padding: 5px 10px;
            outline: none;
        }

        .flip-card__input::placeholder {
            color: var(--font-color-sub);
            opacity: 0.8;
        }

        .flip-card__input:focus {
            border: 2px solid var(--input-focus);
        }

        .flip-card__btn:active,
        .button-confirm:active {
            box-shadow: 0px 0px var(--main-color);
            transform: translate(3px, 3px);
        }

        .flip-card__btn {
            margin: 20px 0 20px 0;
            width: 120px;
            height: 40px;
            border-radius: 5px;
            border: 2px solid var(--main-color);
            background-color: var(--bg-color);
            box-shadow: 4px 4px var(--main-color);
            font-size: 17px;
            font-weight: 600;
            color: var(--font-color);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <div class="flip-card__inner">
                <div class="flip-card__back">
                    <div class="title">Kayıt Ol</div>
                    <form class="flip-card__form" method="POST">
                        <input class="flip-card__input" name="name" placeholder="İsim" type="text" required>
                        <input class="flip-card__input" name="email" placeholder="E-posta" type="email" required>
                        <input class="flip-card__input" name="password" placeholder="Şifre" type="password" required>
                        <button class="flip-card__btn" name="signup">Kayıt Ol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
