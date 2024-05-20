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
include('../baglanti.php');

function KitapAdetiArtir($kitap_id, $kutuphane_id)
{
    include('../baglanti.php');

    $sql = "SELECT adet FROM kitaplar_kutuphane WHERE kitap_id = '" . $kitap_id . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $adet = mysqli_fetch_array($sorgu);

    $kitapSayisi = 0;
    $kitapSayisi = $adet[0] + 1;

    $sql_adet = "UPDATE kitaplar_kutuphane SET kitap_id='" . $kitap_id . "', kutuphane_id='" . $kutuphane_id . "', adet='" . $kitapSayisi . "' WHERE kitap_id='" . $kitap_id . "'";
    mysqli_query($bagno, $sql_adet);
}

try {
    $emanet_id = $_GET['emanet_id'];
    $kitap_id = $_GET['kitap_id'];
    $kutuphane_id = $_GET['kutuphane_id'];

    $sql = "UPDATE tbl_emanet SET emanetmi = 0 WHERE emanet_id ='" . $emanet_id . "'";
    $sorgu = mysqli_query($bagno, $sql);

    KitapAdetiArtir($kitap_id, $kutuphane_id);
?>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Emanet Al',
                text: 'Emanet geri alındı!',
                icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=modemanetal.php");
} catch (Exception $e) {
    //hata var ise burada yakalanır
    echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
}
