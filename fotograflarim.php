<?php
session_start();

// Veritabanı bağlantısı ve fotoğrafları almak için gerekli işlemler burada yapılacak

// Örnek veritabanı bağlantısı için:
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

// Kullanıcının oturum açmış olup olmadığını kontrol et
if (!isset($_SESSION["user_id"])) {
    // Oturum açılmamışsa, kullanıcıyı başka bir sayfaya yönlendirin veya hata mesajı gösterin
    header("Location: login.php");
    exit();
}

// Fotoğrafları veritabanından al
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM fotograflar WHERE user_id = $user_id";
$result = $conn->query($sql);

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fotoğraflarım</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .gallery-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Fotoğraflarım</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="resim_yukle.php">Fotoğraf Yükle</a>
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

    <div class="container mt-4">
        <h2 class="text-center">Fotoğraflarım</h2>
        <div class="gallery mt-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $image_url = $row["image_url"];
                    ?>
                    <div class="gallery-item">
                        <img src="<?php echo $image_url; ?>" alt="Fotoğraf">
                        <p class="mt-2"><?php echo $row["upload_date"]; ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>Henüz yüklenmiş fotoğraf yok.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
