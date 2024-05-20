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

$kutuphane_id = $_GET['kutuphane_id'];
$adres_id = $_GET['adres_id'];

function AdresSil($adres_id)
{
    include('../../baglanti.php');

    $sql = "DELETE FROM adresler WHERE adres_id='" . $adres_id . "'";
    mysqli_query($bagno, $sql);
}

function KutuphaneSil($kutuphane_id)
{
    include('../../baglanti.php');

    $sql = "DELETE FROM tbl_kutuphane WHERE kutuphane_id='" . $kutuphane_id . "'";
    mysqli_query($bagno, $sql);
}


try {
    AdresSil($adres_id);
    KutuphaneSil($kutuphane_id);
?>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Kütüphane Sil',
                text: 'Kütüphane silindi!',
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
