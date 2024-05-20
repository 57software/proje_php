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

function UyeYasakKaldir($kullaniciAdi)
{
    include('../../baglanti.php');

    $sql = "UPDATE tbl_uyeler SET yasaklimi = 0 WHERE kullaniciAdi='" . $kullaniciAdi . "'";
    mysqli_query($bagno, $sql);
}

if (isset($_GET['kullaniciAdi'])) {
    $kullaniciAdi = $_GET['kullaniciAdi'];
    try {
        UyeYasakKaldir($kullaniciAdi);
?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Üye Yasağını Kaldır',
                    text: 'Kullanıcının yasağı kaldırıldı!',
                    icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:2; url=uyeler.php");
    } catch (Exception $e) {
        //hata var ise burada yakalanır
        echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
    }
} else {
    ?>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Üye Yasakla',
                text: 'Bilgiler eksik!',
                icon: 'error', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=uyeler.php");
}
