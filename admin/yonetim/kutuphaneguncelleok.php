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
function AdresGuncelle($adres_id, $mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il)
{
    include('../../baglanti.php');

    $sql = "UPDATE adresler SET mahalle='" . $mahalle . "', cadde='" . $cadde . "', sokak='" . $sokak . "', binaNo='" . $binaNo . "', kapiNo='" . $kapiNo . "', ilce='" . $ilce . "', il='" . $il . "' WHERE adres_id='" . $adres_id . "'";
    mysqli_query($bagno, $sql);
}

function KutuphaneGuncelle($kutuphane_id, $kutuphaneAd, $adres_id)
{
    include('../../baglanti.php');
    $sql = "UPDATE tbl_kutuphane SET kutuphaneAd='" . $kutuphaneAd . "', adres_id='" . $adres_id . "' WHERE kutuphane_id='" . $kutuphane_id . "'";
    mysqli_query($bagno, $sql);
}

if (
    isset($_POST['kutuphane_id']) && isset($_POST['kutuphaneAd']) && isset($_POST['adres_id']) && isset($_POST['mahalle']) &&
    isset($_POST['cadde']) && isset($_POST['sokak']) && isset($_POST['binaNo']) && isset($_POST['kapiNo']) &&
    isset($_POST['ilce']) && isset($_POST['il'])
) {
    $kutuphane_id = ucwords(strtolower(trim($_POST['kutuphane_id'])));
    $kutuphaneAd = ucwords(strtolower(trim($_POST['kutuphaneAd'])));
    $adres_id = ucwords(strtolower(trim($_POST['adres_id'])));
    $mahalle = ucwords(strtolower(trim($_POST['mahalle'])));
    $cadde = ucwords(strtolower(trim($_POST['cadde'])));
    $sokak = ucwords(strtolower(trim($_POST['sokak'])));
    $binaNo = ucwords(strtolower(trim($_POST['binaNo'])));
    $kapiNo = ucwords(strtolower(trim($_POST['kapiNo'])));
    $ilce = ucwords(strtolower(trim($_POST['ilce'])));
    $il = ucwords(strtolower(trim($_POST['il'])));

    try {
        AdresGuncelle($adres_id, $mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il);
        KutuphaneGuncelle($kutuphane_id, $kutuphaneAd, $adres_id);

?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kütüphane Güncelle',
                    text: 'Kütüphane güncellendi!',
                    icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
<?php
        header("Refresh:2; url=kutuphaneislem.php");
    } catch (Exception $e) {
        //hata var ise burada yakalanır
        echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
    }
}
