<?php
session_start();
include('../../baglanti.php');
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
    <link rel="stylesheet" type="text/css" href="../1.css">
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
            max-width: 1300px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #28a745;
            color: #fff;
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

        /* Button stilini tanımla */
        .custom-button1 {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(198, 15, 15);
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
        .custom-button1:hover {
            background-color: rgb(122, 10, 10);
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
        <img src="../../logo.png" style="height: 100px;">
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

    <!-- İçerik kısmı -->
    <div class="content" style="text-align: center; vertical-align: middle; max-width:100%; max-height:100%;">
        <br><br>
        <a href="yayinevilistesi.php" class="custom-button">Yayınevi Listesi</a>&nbsp;&nbsp;
        <a href="yayinevleri.php" class="custom-button">Yayınevi Ekle</a>
        <h1>Kütüphane Listesi</h1>
        <form action="yayineviislem.php" method="post">
            <input type="text" id="user-name" name="yayinevi_arama" placeholder="Yayınevi adı yazınız">
            <button id="search-button">Ara</button>
        </form>
        <div class="container">
            <?php
            // Veritabanı bağlantısı
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "kutuphane";

            // Bağlantı oluşturma
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Bağlantı kontrolü
            if ($conn->connect_error) {
                die("Bağlantı hatası: " . $conn->connect_error);
            }

            // Sayfalama işlemleri
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $per_page = 25;
            $start_from = ($page - 1) * $per_page;

            if (isset($_POST['yayinevi_arama'])) {
                $arama_yayineviAdi = trim($_POST['yayinevi_arama']);

                // SQL sorgusu
                $sql = "SELECT tbl_yayin_evleri.yayinEvi_id, tbl_yayin_evleri.yayinEviAdi, tbl_yayin_evleri.adres_id, adresler.mahalle, 
                adresler.cadde, adresler.sokak, adresler.binaNo, adresler.kapiNo, adresler.ilce, adresler.il 
                FROM tbl_yayin_evleri, adresler 
                WHERE tbl_yayin_evleri.yayinEviAdi LIKE '%" . $arama_yayineviAdi . "%' AND adresler.adres_id = tbl_yayin_evleri.adres_id
                LIMIT $start_from, $per_page";

                $result = $conn->query($sql);

                // Tablo başlıkları
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                //echo "<th>Yayınevi ID</th>";
                echo "<th>Yayınevi Adı</th>";
                //echo "<th>Adres ID</th>";
                echo "<th>Mahalle</th>";
                echo "<th>Cadde</th>";
                echo "<th>Sokak</th>";
                echo "<th>Bina No</th>";
                echo "<th>Kapı No</th>";
                echo "<th>İlçe</th>";
                echo "<th>İl</th>";
                echo "<th>Güncelle</th>";
                echo "<th>Sil</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Verileri tablo içinde gösterme
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        //echo "<td>" . $row["yayinEvi_id"] . "</td>";
                        echo "<td>" . $row["yayinEviAdi"] . "</td>";
                        //echo "<td>" . $row["adres_id"] . "</td>";
                        echo "<td>" . $row["mahalle"] . "</td>";
                        echo "<td>" . $row["cadde"] . "</td>";
                        echo "<td>" . $row["sokak"] . "</td>";
                        echo "<td>" . $row["binaNo"] . "</td>";
                        echo "<td>" . $row["kapiNo"] . "</td>";
                        echo "<td>" . $row["ilce"] . "</td>";
                        echo "<td>" . $row["il"] . "</td>";
                        echo "<td><a href='yayineviguncelle.php?yayinEvi_id=" . $row["yayinEvi_id"] . "&yayinEviAdi=" . $row["yayinEviAdi"] . "&
                        adres_id=" . $row["adres_id"] . "&mahalle=" . $row["mahalle"] . "&cadde=" . $row["cadde"] . "&sokak=" . $row["sokak"] . "&
                        binaNo=" . $row["binaNo"] . "&kapiNo=" . $row["kapiNo"] . "&ilce=" . $row["ilce"] . "&il=" . $row["il"] . "' class='custom-button'>Güncelle</a></td>";
                        echo "<td><a href='yayinevisil.php?yayinEvi_id=" . $row["yayinEvi_id"] . "&adres_id=" . $row["adres_id"] . "' class='custom-button1'>Sil</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Veri bulunamadı.</td></tr>";
                }

                echo "</tbody>";
                echo "</table>";

                // Sayfalama bağlantıları
                $sql = "SELECT COUNT(*) AS total FROM tbl_yayin_evleri, adresler 
                WHERE tbl_yayin_evleri.yayinEviAdi LIKE '%" . $arama_yayineviAdi . "%' AND adresler.adres_id = tbl_yayin_evleri.adres_id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $total_pages = ceil($row["total"] / $per_page);

                echo "<div class='pagination'>";
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?page=$i'>$i</a>";
                }
                echo "</div>";

                // Bağlantıyı kapat
                $conn->close();
            } else {
                // SQL sorgusu
                $sql = "SELECT tbl_yayin_evleri.yayinEvi_id, tbl_yayin_evleri.yayinEviAdi, tbl_yayin_evleri.adres_id, adresler.mahalle, 
                adresler.cadde, adresler.sokak, adresler.binaNo, adresler.kapiNo, adresler.ilce, adresler.il 
                FROM tbl_yayin_evleri, adresler 
                WHERE adresler.adres_id = tbl_yayin_evleri.adres_id
                LIMIT $start_from, $per_page";

                $result = $conn->query($sql);

                // Tablo başlıkları
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                //echo "<th>Yayınevi ID</th>";
                echo "<th>Yayınevi Adı</th>";
                //echo "<th>Adres ID</th>";
                echo "<th>Mahalle</th>";
                echo "<th>Cadde</th>";
                echo "<th>Sokak</th>";
                echo "<th>Bina No</th>";
                echo "<th>Kapı No</th>";
                echo "<th>İlçe</th>";
                echo "<th>İl</th>";
                echo "<th>Güncelle</th>";
                echo "<th>Sil</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Verileri tablo içinde gösterme
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        //echo "<td>" . $row["yayinEvi_id"] . "</td>";
                        echo "<td>" . $row["yayinEviAdi"] . "</td>";
                        //echo "<td>" . $row["adres_id"] . "</td>";
                        echo "<td>" . $row["mahalle"] . "</td>";
                        echo "<td>" . $row["cadde"] . "</td>";
                        echo "<td>" . $row["sokak"] . "</td>";
                        echo "<td>" . $row["binaNo"] . "</td>";
                        echo "<td>" . $row["kapiNo"] . "</td>";
                        echo "<td>" . $row["ilce"] . "</td>";
                        echo "<td>" . $row["il"] . "</td>";
                        echo "<td><a href='yayineviguncelle.php?yayinEvi_id=" . $row["yayinEvi_id"] . "&yayinEviAdi=" . $row["yayinEviAdi"] . "&
                        adres_id=" . $row["adres_id"] . "&mahalle=" . $row["mahalle"] . "&cadde=" . $row["cadde"] . "&sokak=" . $row["sokak"] . "&
                        binaNo=" . $row["binaNo"] . "&kapiNo=" . $row["kapiNo"] . "&ilce=" . $row["ilce"] . "&il=" . $row["il"] . "' class='custom-button'>Güncelle</a></td>";
                        echo "<td><a href='yayinevisil.php?yayinEvi_id=" . $row["yayinEvi_id"] . "&adres_id=" . $row["adres_id"] . "' class='custom-button1'>Sil</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Veri bulunamadı.</td></tr>";
                }

                echo "</tbody>";
                echo "</table>";

                // Sayfalama bağlantıları
                $sql = "SELECT COUNT(*) AS total FROM tbl_yayin_evleri, adresler 
                WHERE adresler.adres_id = tbl_yayin_evleri.adres_id";   
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $total_pages = ceil($row["total"] / $per_page);

                echo "<div class='pagination'>";
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?page=$i'>$i</a>";
                }
                echo "</div>";

                // Bağlantıyı kapat
                $conn->close();
            }
            ?>
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