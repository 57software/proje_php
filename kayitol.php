<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Kütüphane Yönetim Sistemi">
    <meta name="description" content="Bu kütüphane yönetim sistemi dönem projesidir.">
    <meta name="keywords" content="Kütüphane Yönetim Sistemi">
    <meta name="author" content="Ömer Faruk Ercan">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 38.5%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <img src="logo.png" style="width: 150px;">

    <div>
        <h3>Yeni Kayıt</h3>
        <form action="kayit.php" method="post">
            <input type="text" name="kullaniciAdi" placeholder="Kullanıcı Adı" required><br>
            <div class="password-container" style="margin: 0;">
                <input type="password" id="sifre" name="sifre" placeholder="Şifre" required>
                <span class="toggle-icon toggle-password" id="toggle-icon">👁️</span>
            </div>
            <br>
            <input type="text" name="ad" placeholder="İsim" required>
            <input type="text" name="soyad" placeholder="Soyisim" required><br>
            <input type="email" name="eposta" placeholder="Eposta" required>
            <input type="tel" name="telefon" placeholder="Telefon" required>
            <select name="cinsiyet" style="width: 200px; height: 38px; vertical-align: middle; border-radius: 5px; font-size: 16px;" required>
                <option value="Erkek">Erkek</option>
                <option value="Kadın">Kadın</option>
            </select><br>
            <input type="text" name="mahalle" placeholder="Mahalle" required>
            <input type="text" name="cadde" placeholder="Cadde" required>
            <input type="text" name="sokak" placeholder="Sokak" required><br>
            <input type="text" name="binaNo" placeholder="Bina No" required>
            <input type="text" name="kapiNo" placeholder="Kapı No" required>
            <input type="text" name="ilce" placeholder="İlçe" required>
            <input type="text" name="il" placeholder="İl" required><br><br>
            <button type="submit">Kayıt Ol</button>
            &nbsp;&nbsp;
            <input type="reset" value="Temizle">
            <br><br>
            Bir hesabın var mı?<br>
            <a href="index.php">Giriş Yap</a>
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