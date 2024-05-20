<?php
session_start();
include('../baglanti.php');
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
    <link rel="stylesheet" type="text/css" href="../admin/style.css">
    <link rel="stylesheet" type="text/css" href="../admin/gostergepanel.css">
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
        <img src="../logo.png" style="height: 100px;">
        <div class="menu" onclick="toggleMenu()">
            <!-- Kullanıcı adı ve yetki gösterimi -->
            <?php
            echo $_SESSION['kullanici'] . ", ";
            echo $_SESSION['yetki'];
            ?>

            <!-- Açılır menü -->
            <div id="submenu" class="submenu">
                <a href="oturumukapat.php">Çıkış Yap</a>
            </div>
        </div>
    </div>

    <!-- Sabit yan menü -->
    <div class="sidebar">
        <a href="moderator.php">Anasayfa</a>
        <a href="modgostergepaneli.php">Gösterge Paneli</a>
        <a href="modemanetver.php">Emanet Ver</a>
        <a href="modemanetal.php">Emanet Al</a>
        <a href="kitaplar.php">Kitaplar</a>
        <a href="../admin/oturumukapat.php" style="bottom: 0; position: fixed; width:168px;">Oturumu Kapat</a>
    </div>

    <br>

    <!-- İçerik kısmı -->
    <div class="content" style="text-align: center; vertical-align: middle; max-width:100%; max-height:100%;">
        <div class="container">
            <h1>Gösterge Paneli</h1>
            <div class="panel">
                <div class="card">
                    <h2>Mevcut Kitaplar</h2>
                    <?php
                    $sql_mevcutKitaplar = "SELECT SUM(adet) FROM kitaplar_kutuphane WHERE adet > 0";
                    $sorgu_mevcutKitaplar = mysqli_query($bagno, $sql_mevcutKitaplar);
                    $mevcutKitaplar = mysqli_fetch_array($sorgu_mevcutKitaplar);
                    echo $mevcutKitaplar[0];
                    ?>
                </div>
                <div class="card">
                    <h2>Emanet Verilenler</h2>
                    <?php
                    $sql_emanetVerilenler = "SELECT COUNT(emanet_id) FROM tbl_emanet WHERE emanetmi = 1";
                    $sorgu_emanetVerilenler = mysqli_query($bagno, $sql_emanetVerilenler);
                    $emanetVerilenler = mysqli_fetch_array($sorgu_emanetVerilenler);
                    echo $emanetVerilenler[0];
                    ?>
                </div>
                <div class="card">
                    <h2>Emanet Alınanlar</h2>
                    <?php
                    $sql_emanetAlinanlar = "SELECT COUNT(kitap_id) FROM tbl_emanet WHERE emanetmi = 0";
                    $sorgu_emanetAlinanlar = mysqli_query($bagno, $sql_emanetAlinanlar);
                    $emanetAlinanlar = mysqli_fetch_array($sorgu_emanetAlinanlar);
                    echo $emanetAlinanlar[0];
                    ?>
                </div>
                <div class="card">
                    <h2>Üye Sayısı</h2>
                    <?php
                    $sql_uyeSayisi = "SELECT COUNT(uye_id) FROM tbl_uyeler";
                    $sorgu_uyeSayisi = mysqli_query($bagno, $sql_uyeSayisi);
                    $uyeSayisi = mysqli_fetch_array($sorgu_uyeSayisi);
                    echo $uyeSayisi[0];
                    ?>
                </div>
            </div>
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