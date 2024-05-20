<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Kütüphane Yönetim Sistemi">
    <meta name="description" content="Bu kütüphane yönetim sistemi dönem projesidir.">
    <meta name="keywords" content="Kütüphane Yönetim Sistemi">
    <meta name="author" content="Ömer Faruk Ercan">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Kayıt</title>
</head>

<body>
    <?php
    include('baglanti.php');

    function KullaniciAdiKontrol($kullaniciAdi)
    {
        include('baglanti.php');
        $sql = "SELECT COUNT(*) FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "'";
        $sorgu = mysqli_query($bagno, $sql);
        $count = mysqli_fetch_array($sorgu);
        if ($count[0] == 1) return 1;
    }

    function EpostaKontrol($ePosta)
    {
        include('baglanti.php');
        $sql = "SELECT COUNT(*) FROM tbl_uyeler WHERE eposta = '" . $ePosta . "'";
        $sorgu = mysqli_query($bagno, $sql);
        $count = mysqli_fetch_array($sorgu);
        if ($count[0] == 1) return 1;
    }

    function telefonKontrol($telefon)
    {
        include('baglanti.php');
        $sql = "SELECT COUNT(*) FROM tbl_uyeler WHERE telefon = '" . $telefon . "'";
        $sorgu = mysqli_query($bagno, $sql);
        $count = mysqli_fetch_array($sorgu);
        if ($count[0] == 1) return 1;
    }

    function Sifreleme($kullanici_sifre)
    {
        $rastgeleSayi = "411349"; // 6
        $guvenlikBas = "Library"; // 7
        $guvenlikSon = "123987";  // 6
        // Min: 7+8+6+6=27
        // Max: 7+16+6+6=35

        $yapilanSifre = $guvenlikBas . $kullanici_sifre . $rastgeleSayi . $guvenlikSon; // 27 ya da 35

        $uretilenSifre = "1234567890"; // 10

        $sifre = $yapilanSifre . $uretilenSifre; // 27+10 = 37 ya da 35+10=45

        return $sifre;
    }

    $kullaniciAdi = trim($_POST['kullaniciAdi']);
    $sifre = trim($_POST['sifre']);

    $ad = ucwords(strtolower(trim($_POST['ad'])));
    $soyad = ucwords(strtolower(trim($_POST['soyad'])));
    $eposta = trim($_POST['eposta']);
    $telefon = trim($_POST['telefon']);
    $cinsiyet = trim($_POST['cinsiyet']);
    $mahalle = ucwords(strtolower(trim($_POST['mahalle'])));
    $cadde = ucwords(strtolower(trim($_POST['cadde'])));
    $sokak = ucwords(strtolower(trim($_POST['sokak'])));
    $binaNo = ucwords(strtolower(trim($_POST['binaNo'])));
    $kapiNo = ucwords(strtolower(trim($_POST['kapiNo'])));
    $ilce = ucwords(strtolower(trim($_POST['ilce'])));
    $il = ucwords(strtolower(trim($_POST['il'])));

    $tarih = date("d/m/Y");
    $diziTarih = explode("/", $tarih);

    $kayitTarihi = $diziTarih[0] . "." . $diziTarih[1] . "." . $diziTarih[2];

    $kullaniciKontrol = KullaniciAdiKontrol($kullaniciAdi);
    $epostaKontrol = EpostaKontrol($eposta);
    $TelefonKontrol = telefonKontrol($telefon);

    if ($kullaniciKontrol == 1) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kayıt',
                    text: 'Bu kullanıcı adı başkası tarafından kullanılmakta!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:3; url=kayitol.php");
    } else if (strlen($sifre) < 8) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kayıt',
                    text: 'Şifre 8 karakterden az olamaz!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:3; url=kayitol.php");
    } else if (strlen($sifre) > 16) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kayıt',
                    text: 'Şifre 16 karakterden fazla olamaz!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:3; url=kayitol.php");
    } else if ($epostaKontrol == 1) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kayıt',
                    text: 'Bu E-Posta başkası tarafından kullanılmakta!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:3; url=kayitol.php");
    } else if ($TelefonKontrol == 1) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kayıt',
                    text: 'Bu telefon başkası tarafından kullanılmakta!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
        <?php
        header("Refresh:3; url=kayitol.php");
    } else {
        try {
            $sql_adres = "INSERT INTO adresler VALUES(NULL,'" . $mahalle . "','" . $cadde . "','" . $sokak . "','" . $binaNo . "','" . $kapiNo . "','" . $ilce . "','" . $il . "')";
            $sorgu_adres = mysqli_query($bagno, $sql_adres);

            $guvenliSifre = Sifreleme($sifre);

            $sql_sonAdresID = "SELECT adres_id FROM adresler ORDER BY adres_id DESC LIMIT 1";
            $sorgu_sonAdresID = mysqli_query($bagno, $sql_sonAdresID);
            $adresID = mysqli_fetch_array($sorgu_sonAdresID); // $adresID[0] <- son kayıt adresID

            $sql_kayit = "INSERT INTO tbl_uyeler VALUES(NULL,'" . $adresID[0] . "','" . $ad . "','" . $soyad . "','" . $kullaniciAdi . "','" . $guvenliSifre . "','" . $cinsiyet . "','" . $telefon . "','" . $eposta . "', 'Üye', '" . $kayitTarihi . "', 0)";
            $sorgu_kayit = mysqli_query($bagno, $sql_kayit);
            if ($sorgu_kayit) {
        ?>
                <script>
                    // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: 'Kayıt',
                            text: 'Kayıt başarıyla tamamlandı!',
                            icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                            confirmButtonText: 'Tamam'
                        });
                    });
                </script>
    <?php
                header("Refresh:3; url=kayitol.php");
            }
        } catch (Exception $e) {
            //hata var ise burada yakalanır
            echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
        }
    }
    ?>
</body>

</html>