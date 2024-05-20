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
$ISBN = $_GET['ISBN'];

function KitapID($ISBN)
{
    include('../../baglanti.php');
    $sql = "SELECT kitap_id FROM tbl_kitaplar WHERE ISBN = '" . $ISBN . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $KitapID = mysqli_fetch_array($sorgu);
    return $KitapID[0];
}

function KitapSil($kitapID)
{
    include('../../baglanti.php');
    $sql = "DELETE FROM tbl_kitaplar WHERE kitap_id='" . $kitapID . "'";
    mysqli_query($bagno, $sql);
}

function YazarSil($kitapID)
{
    include('../../baglanti.php');
    $sql = "DELETE FROM yazarlar WHERE kitap_id='" . $kitapID . "'";
    mysqli_query($bagno, $sql);
}

function KutuphanedenKitap_Sil($kitapID)
{
    include('../../baglanti.php');
    $sql = "DELETE FROM kitaplar_kutuphane WHERE kitap_id='" . $kitapID . "'";
    mysqli_query($bagno, $sql);
}

function KategoriSil($kitapID)
{
    include('../../baglanti.php');
    $sql = "DELETE FROM kategoriler WHERE kitap_id='" . $kitapID . "'";
    mysqli_query($bagno, $sql);
}

try {
    $kitap_id = KitapID($ISBN);

    KitapSil($kitap_id);
    YazarSil($kitap_id);
    KutuphanedenKitap_Sil($kitap_id);
    KategoriSil($kitap_id);

?>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Kitap Sil',
                text: 'Kitap silindi!',
                icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=kitapislem.php");
} catch (Exception $e) {
    //hata var ise burada yakalanır
    echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
}
