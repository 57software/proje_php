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
    <link rel="stylesheet" type="text/css" href="../admin/style.css">
    <link rel="stylesheet" type="text/css" href="../admin/1.css">
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

        .table-container {
            margin: auto;
            /* Yatay ortalama */
            width: 100%;
            /* Genişliği ayarla */
            text-align: center;
            /* Metni ortala */
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
                <a href="../admin/oturumukapat.php">Çıkış Yap</a>
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

    <!-- İçerik kısmı -->

    <div class="content" style="text-align: center; vertical-align: middle; max-width:100%; max-height:100%;">
        <!-- Kullanıcı Adı Arama -->
        <div class="search-container">
            <h2>Kullanıcı Kitap Arama</h2>
            <form action="modemanetver.php" method="post">
                <input type="text" id="user-name" name="kullanici" placeholder="Kullanıcı adı yazınız" required>
                <input type="text" id="user-name" name="kitapAdi" placeholder="Kitap adını yazınız" required>
                <button id="search-button">Ara</button>
            </form>
            <div class="table-container">
                <div class="results" id="results">
                    <center>
                        <!-- Arama sonuçları burada gösterilecek -->
                        <table border=1 cellpadding=10 cellspacing=0">
                            <tr>
                                <td>Kullanıcı Adı</td>
                                <!--<td>Emanet ID</td>
                                <td>Üye ID</td>
                                <td>Kitap ID</td>-->
                                <td>Kitap Adı</td>
                                <!--<td>Kütüphane ID</td>-->
                                <td>Emanet Tarihi</td>
                                <td>Teslim Tarihi</td>
                                <td>Ücret</td>
                                <td>Emanet mi</td>
                            </tr>
                            <?php
                            include('../baglanti.php');

                            try {
                                @$kullaniciAdi = trim($_POST['kullanici']);

                                if (isset($_POST['kullanici'])) {
                                    $kullaniciAdi = trim($_POST['kullanici']);

                                    $sql = "SELECT tbl_uyeler.kullaniciAdi, tbl_emanet.emanet_id, tbl_emanet.uye_id, tbl_emanet.kitap_id, tbl_kitaplar.kitapAdi, tbl_emanet.kutuphane_id, tbl_emanet.emanetTarihi, tbl_emanet.teslimTarihi, tbl_emanet.ucret, tbl_emanet.emanetmi FROM tbl_uyeler, tbl_emanet, tbl_kitaplar WHERE tbl_uyeler.uye_id = tbl_emanet.uye_id AND tbl_kitaplar.kitap_id = tbl_emanet.kitap_id AND tbl_uyeler.kullaniciAdi = '" . $kullaniciAdi . "' AND tbl_emanet.emanetmi = 1";
                                    $sorgu = mysqli_query($bagno, $sql);

                                    while ($kisi = mysqli_fetch_array($sorgu)) {
                                        // ücret hesaplama
                                        date_default_timezone_set('Europe/Istanbul');
                                        $bugunun_tarihi = new DateTime(date('Y-m-d')); // bugünü DateTime nesnesi olarak alır
                                        @$teslimTarihiDizi = explode(".", $kisi[7]); // teslim tarihi parçalarını alır

                                        // Tarih parçalarını birleştirerek DateTime nesnesine çevirir
                                        @$teslimTarihi = new DateTime($teslimTarihiDizi[2] . "-" . $teslimTarihiDizi[1] . "-" . $teslimTarihiDizi[0]);

                                        // Tarihler arasındaki farkı alır
                                        $interval = $bugunun_tarihi->diff($teslimTarihi);

                                        if ($bugunun_tarihi > $teslimTarihi) {
                                            $sql_ucret_guncelle = "UPDATE tbl_emanet SET ucret = '" . $interval->format('%a') . "' WHERE emanet_id='" . $kisi[1] . "'";
                                            $sorgu_ucret_guncelle = mysqli_query($bagno, $sql_ucret_guncelle);
                                        }

                                        echo "<tr bgcolor=\"#f2f7f1\">";
                                        echo "<td>" . $kisi[0] . "</td>"; // kullaniciAdi
                                        //echo "<td>" . $kisi[1] . "</td>"; // emanet_id
                                        //echo "<td>" . $kisi[2] . "</td>"; // uye_id
                                        //echo "<td>" . $kisi[3] . "</td>"; // kitap_id
                                        echo "<td>" . $kisi[4] . "</td>"; // kitapAdi
                                        //echo "<td>" . $kisi[5] . "</td>"; // kutuphane_id
                                        echo "<td>" . $kisi[6] . "</td>"; // emanetTarihi
                                        echo "<td>" . $kisi[7] . "</td>"; // teslimTarihi
                                        echo "<td>" . $kisi[8] . " TL</td>"; // ucret
                                        if ($kisi[9] == 1) {
                                            echo "<td>Evet</td>"; // emanet mi
                                        }
                                    }
                                } else {
                                    $kullaniciAdi = "";
                                }
                            } catch (Exception $e) {
                                //hata var ise burada yakalanır
                                echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
                            }
                            ?>
                        </table>

                        <br>
                        <!-- Arama sonuçları burada gösterilecek -->
                        <table border=1 cellpadding=10 cellspacing=0>
                            <tr>
                                <td>Yayınevi Adı</td>
                                <td>Kategori Adı</td>
                                <!--<td>Kütüphane ID</td>-->
                                <td>Kitap Adeti</td>
                                <td>Yazar Adı</td>
                                <td>Yazar Soyadı</td>
                                <td>ISBN</td>
                                <td>Kitap Adı</td>
                                <td>Yayın Tarihi</td>
                                <td>Sayfa Sayısı</td>
                                <td>Kitap Dili</td>
                                <td>Emanet İşlemi</td>
                            </tr>
                            <?php

                            try {
                                @$kitapAdi = trim($_POST['kitapAdi']);

                                if (isset($_POST['kitapAdi'])) {
                                    $kitapAdi = trim($_POST['kitapAdi']);

                                    $sql_kitapAra = "SELECT tbl_yayin_evleri.yayinEviAdi, kategoriler.kategoriAdi, kitaplar_kutuphane.kutuphane_id, 
                                    kitaplar_kutuphane.adet, yazarlar.yazarAd, yazarlar.yazarSoyad, tbl_kitaplar.ISBN, tbl_kitaplar.kitapAdi, 
                                    tbl_kitaplar.yayinTarihi, tbl_kitaplar.sayfaSayisi, tbl_kitaplar.kitapDili 
                                    FROM tbl_yayin_evleri, tbl_kitaplar, kitaplar_kutuphane, yazarlar, kategoriler 
                                    WHERE tbl_yayin_evleri.yayinEvi_id = tbl_kitaplar.yayinEvi_id AND 
                                    tbl_kitaplar.kitap_id = kitaplar_kutuphane.kitap_id AND yazarlar.kitap_id = tbl_kitaplar.kitap_id AND 
                                    kategoriler.kitap_id = tbl_kitaplar.kitap_id
                                    AND kitapAdi LIKE '%" . $kitapAdi . "%'";
                                    $sorgu_kitapAra = mysqli_query($bagno, $sql_kitapAra);

                                    while ($kitap = mysqli_fetch_array($sorgu_kitapAra)) {

                                        echo "<tr bgcolor=\"#f2f7f1\">";
                                        echo "<td>" . $kitap[0] . "</td>"; // Yayınevi Adı
                                        echo "<td>" . $kitap[1] . "</td>"; // Kategori Adı
                                        //echo "<td>" . $kitap[2] . "</td>"; // Kütüphane ID
                                        echo "<td>" . $kitap[3] . "</td>"; // Kitap Adeti
                                        echo "<td>" . $kitap[4] . "</td>"; // Yazar Adı
                                        echo "<td>" . $kitap[5] . "</td>"; // Yazar Soyadı
                                        echo "<td>" . $kitap[6] . "</td>"; // ISBN
                                        echo "<td>" . $kitap[7] . "</td>"; // Kitap Adı
                                        echo "<td>" . $kitap[8] . "</td>"; // Yayın Tarihi
                                        echo "<td>" . $kitap[9] . "</td>"; // Sayfa Sayısı
                                        echo "<td>" . $kitap[10] . "</td>"; // Kitap Dili

                                        $kullaniciAdi1 = trim($_POST['kullanici']);
                                        $sql_kullaniciAdi = "SELECT kullaniciAdi FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi1 . "' ";
                                        $sorgu_kullaniciAdi = mysqli_query($bagno, $sql_kullaniciAdi);
                                        $kullaniciAdi1_1 = mysqli_fetch_array($sorgu_kullaniciAdi);

                                        echo "<td><a href='emanetver1.php?kullaniciAdi=" . $kullaniciAdi1_1[0] . "&ISBN=" . $kitap[6] . "&kutuphaneID=" . $kitap[2] . "' class='button'>Emanet Ver</a></td>";

                                        echo "</tr>";
                                    }
                                } else {
                                    $kitapAdi = "";
                                }
                            } catch (Exception $e) {
                                //hata var ise burada yakalanır
                                echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
                            }
                            ?>
                        </table>
                    </center>
                </div>
            </div>
        </div>

        <!-- JS script'i kullanıcı adına göre sonuçları almak için -->
        <script>
            document.getElementById("search-button").addEventListener("click", function() {
                var userName = document.getElementById("user-name").value;

                // Ajax veya benzeri bir yöntemle PHP tarafından gelen verileri almanız gerekebilir
                // Burada sonuçları örnek olarak konsola yazacağız
                console.log("Kullanıcı Adı: " + userName);
                // Alınan verilere göre sonuçları "results" div'inde gösterebilirsiniz
            });
        </script>
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