<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Kütüphane Yönetim Sistemi">
    <meta name="description" content="Bu kütüphane yönetim sistemi dönem projesidir.">
    <meta name="keywords" content="Kütüphane Yönetim Sistemi">
    <meta name="author" content="Ömer Faruk Ercan">
    <title>Yönetim Paneli</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="kitaplar.css">
    <style>
        /* Menü stilini belirleme */
        .menu {
            position: absolute;
            /* Absolute positioning kullanarak menüyü sayfanın sağ üst köşesine yerleştiriyoruz */
            top: 10px;
            /* Yukarıdan 10 piksel boşluk bırak */
            right: 10px;
            /* Sağdan 10 piksel boşluk bırak */
            cursor: pointer;
            /* Mouse imlecini işaretçi yap */
            padding: 10px;
            /* Kenarlara dolgu ekle */
            border: 1px solid #ccc;
            /* Kenarlık ekle */
            background-color: #f9f9f9;
            /* Arka plan rengini ayarla */
            transition: background-color 0.3s;
            /* Arka plan renginin yavaşça değişmesini sağla */
            position: fixed;
            /* Sabit menü */
        }

        /* Menü üzerinde hover olduğunda arka plan rengini değiştir */
        .menu:hover {
            background-color: #eaeaea;
            /* Hover durumunda daha koyu bir renk */
        }

        /* Alt menü (açılır menü) stilini belirleme */
        .submenu {
            display: none;
            /* Başlangıçta alt menüyü gizle */
            position: absolute;
            /* Alt menüyü ana menü ile ilişkilendir */
            top: 100%;
            /* Ana menünün hemen altından başla */
            right: 0;
            /* Sağ hizalama */
            background-color: white;
            /* Arka plan rengi */
            border: 1px solid #ccc;
            /* Kenarlık */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Gölgelendirme efekti */
            width: 100%;
            /* Alt menünün genişliğini ana menü ile aynı yap */
            transition: all 0.3s;
            /* Animasyon için geçiş ekle */
        }

        /* Alt menü içindeki bağlantılar */
        .submenu a {
            display: block;
            /* Bağlantıları blok eleman yap */
            padding: 10px;
            /* Kenarlara dolgu ekle */
            text-decoration: none;
            /* Alt çizgiyi kaldır */
            color: black;
            /* Metin rengini ayarla */
        }

        /* Alt menüdeki bağlantılar üzerine gelindiğinde arka plan rengini değiştir */
        .submenu a:hover {
            background-color: #f1f1f1;
            /* Hover durumunda daha koyu bir renk */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination .active {
            background-color: #007bff;
            color: #fff;
            pointer-events: none;
        }

        /* Button stilini tanımla */
        .custom-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Yeşil tonu */
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Buttonun hover hali */
        .custom-button:hover {
            background-color: #45a049;
            /* Hover'da biraz daha koyu yeşil */
        }
    </style>
    <script>
        // JavaScript ile menüyü açma/kapatma işlevi
        function toggleMenu() {
            var submenu = document.getElementById("submenu");
            if (submenu.style.display === "none" || submenu.style.display === "") {
                submenu.style.display = "block"; /* Menüyü aç */
            } else {
                submenu.style.display = "none"; /* Menüyü kapat */
            }
        }
    </script>
</head>

<body>

    <div class="content" style="text-align: center; height: 50px; padding: 10px;">
        <div class="menu" onclick="toggleMenu()">
            <!-- Kullanıcı adı ve yetki gösterimi -->
            <?php
            echo $_SESSION['kullanici'] . ", ";
            echo $_SESSION['yetki'];
            ?>

            <!-- Açılır menü -->
            <div id="submenu" class="submenu">
                <a href="../oturumukapat.php">Çıkış Yap</a>
            </div>
        </div>
    </div>

    <!-- Sabit yan menü -->
    <div class="sidebar">
        <a href="../admin.php">Anasayfa</a>

        <!-- Yönetim Paneli ve açılır menüsü -->
        <div class="dropdown" onclick="toggleDropdown()">
            <!-- Yönetim Paneli bağlantısı -->
            <a href="#">Yönetim Paneli</a>

            <!-- Açılır menü -->
            <div id="dropdown-content" class="dropdown-content">
                <a href="uyeler.php">Üyeler</a>
                <a href="kitaplar.php">Kitaplar</a>
                <a href="yayinevleri.php">Yayınevleri</a>
                <a href="kutuphane.php">Kütüphane</a>
            </div>
        </div>

        <a href="../gostergepaneli.php">Gösterge Paneli</a>
        <a href="../emanetver.php">Emanet Ver</a>
        <a href="../emanetal.php">Emanet Al</a>
        <a href="../oturumukapat.php" style="bottom: 0; position: fixed; width:168px;">Oturumu Kapat</a>
    </div>

    <?php
    $yayinEvi_id = $_GET["yayinEvi_id"];
    $yayinEviAdi = $_GET["yayinEviAdi"];
    $adres_id = $_GET["adres_id"];
    $mahalle = $_GET["mahalle"];
    $cadde = $_GET["cadde"];
    $sokak = $_GET["sokak"];
    $binaNo = $_GET["binaNo"];
    $kapiNo = $_GET["kapiNo"];
    $ilce = $_GET["ilce"];
    $il = $_GET["il"];

    ?>

    <!-- İçerik kısmı -->
    <div class="content" style="margin-left: 400px; text-align: center; vertical-align: middle; max-width:100%; max-height:100%;">
        <br>
        <a href="yayinevilistesi.php" class="custom-button">Yayınevi Listesi</a>&nbsp;&nbsp;
        <a href="yayineviislem.php" class="custom-button">Güncelle / Sil</a>
        <br><br>
        <div>
            <form action="yayineviguncelleok.php" method="post">
                <input type="hidden" name="yayinEvi_id" placeholder="Yayınevi ID" value="<?php echo $yayinEvi_id; ?>" required>
                <input type="text" name="yayinEviAdi" placeholder="Yayınevi Adı" value="<?php echo $yayinEviAdi; ?>" required>
                <input type="hidden" name="adres_id" placeholder="Adres ID" value="<?php echo $adres_id; ?>" required>
                <input type="text" name="mahalle" placeholder="Mahalle" value="<?php echo $mahalle; ?>" required>
                <input type="text" name="cadde" placeholder="Cadde" value="<?php echo $cadde; ?>" required>
                <input type="text" name="sokak" placeholder="Sokak" value="<?php echo $sokak; ?>" required>
                <input type="text" name="binaNo" placeholder="Bina No" value="<?php echo $binaNo; ?>" required>
                <input type="text" name="kapiNo" placeholder="Kapı No" value="<?php echo $kapiNo; ?>" required>
                <input type="text" name="ilce" placeholder="İlçe" value="<?php echo $ilce; ?>" required>
                <input type="text" name="il" placeholder="İl" value="<?php echo $il; ?>" required>
                <input type="submit" value="Yayınevi Güncelle">
            </form>
        </div>
    </div>
    <script>
        // JavaScript ile açılır menüyü açma/kapatma işlevi
        function toggleDropdown() {
            var dropdownContent = document.getElementById("dropdown-content");
            if (dropdownContent.style.display === "none" || dropdownContent.style.display === "") {
                dropdownContent.style.display = "block"; /* Açılır menüyü aç */
                dropdownContent.style.maxHeight = "200px"; /* İstenilen boyuta genişlet */
            } else {
                dropdownContent.style.display = "none"; /* Açılır menüyü kapat */
                dropdownContent.style.maxHeight = "0"; /* Kapat */
            }
        }
    </script>

</body>

</html>