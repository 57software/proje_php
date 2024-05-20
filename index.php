<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Kütüphane Yönetim Sistemi">
    <meta name="description" content="Bu kütüphane yönetim sistemi dönem projesidir.">
    <meta name="keywords" content="Kütüphane Yönetim Sistemi">
    <meta name="author" content="Ömer Faruk Ercan">
    <title>Giriş</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <img src="logo.png" style="width: 150px;">
    <h3>Hoşgeldiniz!</h3>
    <div>
        <?php
        if (isset($_SESSION['kullanici'])) {
            echo $_SESSION['kullanici'] . "<br>";
            echo "Yetkiniz: " . $_SESSION['yetki'];
        } else {
            echo "Oturum açık değil";
        }
        ?>
    </div>
    <div>
        <form action="girisyap.php" method="post">
            <input type="text" name="kullaniciAdi" placeholder="Kullanıcı Adı" required><br>
            <div class="password-container" style="margin: 0;">
                <input type="password" id="sifre" name="sifre" placeholder="Şifre" required>
                <span class="toggle-icon toggle-password" id="toggle-icon">👁️</span>
            </div>
            <br>
            <button>Giriş Yap</button>
            <br><br><br>
            <a href="sifremiunuttum.php">Şifremi Unuttum</a>
            <br><br>
            Hesabın yok mu?<br>
            <a href="kayitol.php">Kayıt ol</a>
        </form>
    </div>

    <script>
        const sifreInput = document.getElementById('sifre');
        const toggleIcon = document.getElementById('toggle-icon');

        toggleIcon.addEventListener('click', function () {
            const type = sifreInput.getAttribute('type') === 'password' ? 'text' : 'password';
            sifreInput.setAttribute('type', type);

            // İkonu değiştir
            if (type === 'text') {
                toggleIcon.textContent = '🙈'; // Şifreyi gizlemek için
            } else {
                toggleIcon.textContent = '👁️'; // Şifreyi göstermek için
            }
        });
    </script>
</body>

</html>