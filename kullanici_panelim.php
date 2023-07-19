<?php
session_start();

// Kullanıcının giriş yapmış olup olmadığını kontrol edin
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

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

// Kullanıcının bilgilerini güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["user_id"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Veritabanında kullanıcının mevcut olup olmadığını kontrol edin
    $check_user_query = "SELECT * FROM users WHERE id = $userId";
    $check_user_result = $conn->query($check_user_query);

    if ($check_user_result->num_rows > 0) {
        // Kullanıcının bilgilerini güncelleme
        $update_user_query = "UPDATE users SET email = '$email', password = '$password' WHERE id = $userId";

        if ($conn->query($update_user_query) === TRUE) {
            echo "<div class='alert alert-success'>Bilgiler başarıyla güncellendi.</div>";
        } else {
            echo "<div class='alert alert-danger'>HATA: Bilgiler güncellenirken bir sorun oluştu.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>HATA: Kullanıcı bulunamadı.</div>";
    }
}

// Kullanıcının mevcut bilgilerini almak için veritabanından sorgu yapma
$userId = $_SESSION["user_id"];
$get_user_query = "SELECT * FROM users WHERE id = $userId";
$get_user_result = $conn->query($get_user_query);
$user_row = $get_user_result->fetch_assoc();
$email = $user_row["email"];
$password = $user_row["password"];

// Veritabanı bağlantısını kapatın
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kullanıcı Paneli</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Kullanıcı Paneli</h2>
        <form method="POST">
            <div class="form-group">
                <label for="email">E-posta:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Bilgileri Güncelle</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
