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
    <title>Yönetim Paneli</title>
</head>

<?php
include('../../baglanti.php');

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

function AdresGuncelle($adres_id, $mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il)
{
    include('../../baglanti.php');
    $sql = "UPDATE adresler SET mahalle='" . $mahalle . "', cadde='" . $cadde . "', sokak='" . $sokak . "', binaNo='" . $binaNo . "', kapiNo='" . $kapiNo . "', ilce='" . $ilce . "', il='" . $il . "' WHERE adres_id='" . $adres_id . "'";
    mysqli_query($bagno, $sql);
}

function UyeGuncelle($uye_id, $ad, $soyad, $kullanici, $sifre, $cinsiyet, $telefon, $eposta, $yetki)
{
    include('../../baglanti.php');

    $sql = "UPDATE tbl_uyeler SET  uyeAd='" . $ad . "', uyeSoyad='" . $soyad . "', kullaniciAdi='" . $kullanici . "', sifre='" . $sifre . "', cinsiyet='" . $cinsiyet . "', telefon='" . $telefon . "', eposta='" . $eposta . "', yetki='" . $yetki . "' WHERE uye_id='" . $uye_id . "'";
    mysqli_query($bagno, $sql);
}

if (
    isset($_POST["uye_id"]) && isset($_POST["adres_id"]) && isset($_POST["uyeAd"]) && isset($_POST["uyeSoyad"]) && isset($_POST["kullaniciAdi"])
    && isset($_POST["sifre"]) && isset($_POST["cinsiyet"]) && isset($_POST["telefon"]) && isset($_POST["eposta"]) && isset($_POST["yetki"])
    && isset($_POST["mahalle"]) && isset($_POST["cadde"]) && isset($_POST["sokak"]) && isset($_POST["binaNo"]) && isset($_POST["kapiNo"])
    && isset($_POST["ilce"]) && isset($_POST["il"])
) {
    $uye_id = ucwords(strtolower(trim($_POST["uye_id"])));
    $adres_id = ucwords(strtolower(trim($_POST["adres_id"])));

    $uyeAd = ucwords(strtolower(trim($_POST["uyeAd"])));
    $uyeSoyad = ucwords(strtolower(trim($_POST["uyeSoyad"])));
    $kullaniciAdi = trim($_POST["kullaniciAdi"]);
    $sifre = trim($_POST["sifre"]);
    $cinsiyet = ucwords(strtolower(trim($_POST["cinsiyet"])));
    $telefon = ucwords(strtolower(trim($_POST["telefon"])));
    $eposta = trim($_POST["eposta"]);
    $yetki = ucwords(strtolower(trim($_POST["yetki"])));

    $mahalle = ucwords(strtolower(trim($_POST["mahalle"])));
    $cadde = ucwords(strtolower(trim($_POST["cadde"])));
    $sokak = ucwords(strtolower(trim($_POST["sokak"])));
    $binaNo = ucwords(strtolower(trim($_POST["binaNo"])));
    $kapiNo = ucwords(strtolower(trim($_POST["kapiNo"])));
    $ilce = ucwords(strtolower(trim($_POST["ilce"])));
    $il = ucwords(strtolower(trim($_POST["il"])));

    if ($kullaniciAdi == "Admin" || $kullaniciAdi == "admin") {
?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Üye Güncelle',
                    text: 'Admin kullanıcısı güncellenemez!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:2; url=uyeislem.php");
    } else if (strlen($sifre) < 8) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Üye Güncelle',
                    text: 'Şifre 8 karakterden az olamaz!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:2; url=uyeislem.php");
    } else if (strlen($sifre) > 16) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Üye Güncelle',
                    text: 'Şifre 16 karakterden fazla olamaz!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
        <?php
        header("Refresh:2; url=uyeislem.php");
    } else {
        try {
            AdresGuncelle($adres_id, $mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il);

            $vt_sifre = Sifreleme($sifre);

            UyeGuncelle($uye_id, $uyeAd, $uyeSoyad, $kullaniciAdi, $vt_sifre, $cinsiyet, $telefon, $eposta, $yetki);

        ?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Üye Güncelle',
                        text: 'Bilgiler başarıyla güncellendi!',
                        icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
    <?php
            header("Refresh:2; url=uyeislem.php");
        } catch (Exception $e) {
            //hata var ise burada yakalanır
            echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
        }
    }
} else {
    ?>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Üye Güncelle',
                text: 'Bilgiler eksik!',
                icon: 'error', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=uyeislem.php");
}
