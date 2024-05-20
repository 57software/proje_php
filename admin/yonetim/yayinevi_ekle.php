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
    <title>Emanet Al</title>
</head>

<?php
include('../../baglanti.php');

function YayineviAdiKontrol($yayineviAdi)
{
    include('../../baglanti.php');

    $sql = "SELECT COUNT(*) FROM tbl_yayin_evleri WHERE yayinEviAdi = '" . $yayineviAdi . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $yayineviAdi = mysqli_fetch_array($sorgu);
    if ($yayineviAdi[0] == 1) return 1; // Yayınevi kayıtlı
    else return 0;                     // Yayınevi kayıtlı değil
}

function AdresKayit($mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il)
{
    include('../../baglanti.php');
    $sql = "INSERT INTO adresler VALUES(NULL,'" . $mahalle . "','" . $cadde . "','" . $sokak . "','" . $binaNo . "','" . $kapiNo . "','" . $ilce . "','" . $il . "')";
    mysqli_query($bagno, $sql);
}

function SonAdresID()
{
    include('../../baglanti.php');

    $sql = "SELECT adres_id FROM adresler ORDER BY adres_id DESC LIMIT 1";
    $sorgu = mysqli_query($bagno, $sql);
    $SonAdresID = mysqli_fetch_array($sorgu);
    return $SonAdresID[0];
}

function YayineviEkle($yayineviAdi, $adresID)
{
    include('../../baglanti.php');

    $sql = "INSERT INTO tbl_yayin_evleri VALUES(NULL,'" . $yayineviAdi . "','" . $adresID . "')";
    mysqli_query($bagno, $sql);
}

if (
    isset($_POST['yayineviAd']) && isset($_POST['mahalle']) && isset($_POST['cadde']) && isset($_POST['sokak']) && isset($_POST['binaNo']) &&
    isset($_POST['kapiNo']) && isset($_POST['ilce']) && isset($_POST['il'])
) {
    $yayineviAd = ucwords(strtolower(trim($_POST['yayineviAd'])));
    $mahalle = ucwords(strtolower(trim($_POST['mahalle'])));
    $cadde = ucwords(strtolower(trim($_POST['cadde'])));
    $sokak = ucwords(strtolower(trim($_POST['sokak'])));
    $binaNo = ucwords(strtolower(trim($_POST['binaNo'])));
    $kapiNo = ucwords(strtolower(trim($_POST['kapiNo'])));
    $ilce = ucwords(strtolower(trim($_POST['ilce'])));
    $il = ucwords(strtolower(trim($_POST['il'])));

    $yayineviAdiKontrol = YayineviAdiKontrol($yayineviAd);

    if ($yayineviAdiKontrol == 1) {
?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Yayınevi Kayıt',
                    text: 'Bu yayınevi daha önce kaydedilmiş!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:2; url=yayinevleri.php");
    } else {
        AdresKayit($mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il);
        $sonAdresID = SonAdresID();
        YayineviEkle($yayineviAd, $sonAdresID);
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Yayınevi Kayıt',
                    text: 'Yayınevi başarıyla kaydedildi!',
                    icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
<?php
        header("Refresh:2; url=yayinevleri.php");
    }
}
