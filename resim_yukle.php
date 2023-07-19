<?php
session_start();

// Discord Webhook URL'nizi yazın
$webhook_url = "https://discord.com/api/webhooks/1130924588046495836/KsJIGj4RiR-PoTWLRqCxI5utxv--EVc5nD2y4Tljc0sOwPzOuXftGJyjFzGMZ7EyICmu";

// Veritabanı bağlantısı için gerekli bilgiler
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dcupload";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Oturum kontrolü yapın
if (!isset($_SESSION["user_id"])) {
    // Oturum açılmamışsa, kullanıcıyı başka bir sayfaya yönlendirin veya hata mesajı gösterin
    header("Location: login.php"); // Kullanıcıyı login.php sayfasına yönlendiriyoruz
    exit();
}

// Çıkış yapma işlemi
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Form gönderildiğinde işleme koyun
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Yüklenen dosyayı alın
    $file = $_FILES["photo"];
    $file_name = $file["name"];
    $file_type = $file["type"];
    $file_tmp = $file["tmp_name"];
    $file_error = $file["error"];

    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "mp4");

    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        echo "<div class='alert alert-danger'>HATA: Sadece JPG, JPEG, PNG, GIF veya MP4 dosya formatları desteklenmektedir!</div>";
    } elseif ($file_error !== UPLOAD_ERR_OK) {
        echo "<div class='alert alert-danger'>HATA: Dosya yükleme hatası!</div>";
    } else {
        // CURL öğesi ile resmi yükleyin
        $cfile = new CURLFile($file_tmp, $file_type, $file_name);
        $json_data = [
            "content" => "Resim Yüklendi!",
            "file" => $cfile
        ];
        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        // Yüklenen resmin bağlantısı
        $response = json_decode($result, true);
        $image_url = $response["attachments"][0]["url"];

        // Fotoğrafı veritabanına kaydet
        $user_id = $_SESSION["user_id"];
        $sql = "INSERT INTO fotograflar (user_id, image_url) VALUES ($user_id, '$image_url')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='container'>";
            echo "<div class='form-container'>";
            echo "<div class='alert alert-success'>Dosya başarıyla yüklendi: " . basename($file_name) . "</div>";
            echo "<div style='background-color:#f2f2f2;padding:10px;border-radius:5px'><strong>Yüklenen Resim:</strong><br><img src='$image_url' style='max-width:100%'></div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Disocrd Webhook Uploader</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        button.btn-custom {
            --glow-color: rgb(217, 176, 255);
            --glow-spread-color: rgba(191, 123, 255, 0.781);
            --enhanced-glow-color: rgb(231, 206, 255);
            --btn-color: rgb(100, 61, 136);
            border: .25em solid var(--glow-color);
            padding: 1em 3em;
            color: var(--glow-color);
            font-size: 15px;
            font-weight: bold;
            background-color: var(--btn-color);
            border-radius: 1em;
            outline: none;
            box-shadow: 0 0 1em .25em var(--glow-color), 0 0 4em 1em var(--glow-spread-color),
                inset 0 0 .75em .25em var(--glow-color);
            text-shadow: 0 0 .5em var(--glow-color);
            position: relative;
            transition: all 0.3s;
            margin-top: 20px;
        }

        button.btn-custom::after {
            pointer-events: none;
            content: "";
            position: absolute;
            top: 120%;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: var(--glow-spread-color);
            filter: blur(2em);
            opacity: .7;
            transform: perspective(1.5em) rotateX(35deg) scale(1, .6);
        }

        button.btn-custom:hover {
            color: var(--btn-color);
            background-color: var(--glow-color);
            box-shadow: 0 0 1em .25em var(--glow-color), 0 0 4em 2em var(--glow-spread-color),
                inset 0 0 .75em .25em var(--glow-color);
        }

        button.btn-custom:active {
            box-shadow: 0 0 0.6em .25em var(--glow-color), 0 0 2.5em 2em var(--glow-spread-color),
                inset 0 0 .5em .25em var(--glow-color);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Disocrd Webhook Uploader
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="fotograflarim.php">Fotograflarım</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Kullanıcı Paneli</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="cikis.php">
                            <button type="submit" class="btn btn-primary">Çıkış Yap</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data"
                class="text-center">
                <h2 class="mb-4">Disocrd Webhook Uploader</h2>
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" id="file" name="photo" accept="image/*">
                    <label class="custom-file-label" for="file">Resim Seçin</label>
                </div>
                <button type="submit" class="btn btn-custom">Yükle</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
