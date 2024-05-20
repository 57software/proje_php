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

function AdresSil($adres_id)
{
    include('../../baglanti.php');

    $sql = "DELETE FROM adresler WHERE adres_id='" . $adres_id . "'";
    mysqli_query($bagno, $sql);
}

function UyeSil($kullaniciAdi)
{
    include('../../baglanti.php');

    $sql = "DELETE FROM tbl_uyeler WHERE kullaniciAdi='" . $kullaniciAdi . "'";
    mysqli_query($bagno, $sql);
}

if (isset($_GET["kullaniciAdi"]) && isset($_GET["adres_id"])) {
    $kullaniciAdi = $_GET["kullaniciAdi"];
    $adres_id = $_GET["adres_id"];
    if ($kullaniciAdi == "Admin" || $kullaniciAdi == "admin") {
?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Üye Sil',
                    text: 'Admin kullanıcısı silinemez!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
        <?php
        header("Refresh:2; url=uyeislem.php");
    } else {
        try {
            AdresSil($adres_id);
            UyeSil($kullaniciAdi);

        ?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Üye Sil',
                        text: 'Kullanıcı silindi!',
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
                title: 'Üye Sil',
                text: 'Bilgiler eksik bırakılamaz!',
                icon: 'error', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=uyeislem.php");
}
