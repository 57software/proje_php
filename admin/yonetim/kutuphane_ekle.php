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

function KutuphaneAdiKontrol($kutuphaneAd)
{
    include('../../baglanti.php');

    $sql = "SELECT COUNT(*) FROM tbl_kutuphane WHERE kutuphaneAd = '" . $kutuphaneAd . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $kutuphaneAdi = mysqli_fetch_array($sorgu);

    if ($kutuphaneAdi[0] == 1) return 1; // Kütüphane adı kayıtlı
    else return 0;                      // Kütüphane adı kayıtlı değil
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
    $sonAdresID = mysqli_fetch_array($sorgu);
    return $sonAdresID[0];
}

function KutuphaneEkle($kutuphaneAdi, $adresID)
{
    include('../../baglanti.php');

    $sql = "INSERT INTO tbl_kutuphane VALUES(NULL,'" . $kutuphaneAdi . "','" . $adresID . "')";
    mysqli_query($bagno, $sql);
}

if (
    isset($_POST['kutuphaneAd']) && isset($_POST['mahalle']) && isset($_POST['cadde']) && $_POST['sokak'] && isset($_POST['binaNo']) &&
    isset($_POST['kapiNo']) && isset($_POST['ilce']) && isset($_POST['il'])
) {
    try {
        $kutuphaneAd = ucwords(strtolower(trim($_POST['kutuphaneAd'])));
        $mahalle = ucwords(strtolower(trim($_POST['mahalle'])));
        $cadde = ucwords(strtolower(trim($_POST['cadde'])));
        $sokak = ucwords(strtolower(trim($_POST['sokak'])));
        $binaNo = ucwords(strtolower(trim($_POST['binaNo'])));
        $kapiNo = ucwords(strtolower(trim($_POST['kapiNo'])));
        $ilce = ucwords(strtolower(trim($_POST['ilce'])));
        $il = ucwords(strtolower(trim($_POST['il'])));

        $kutuphaneKontrol = KutuphaneAdiKontrol($kutuphaneAd);

        if ($kutuphaneKontrol == 1) {
?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Kütüphane Kayıt',
                        text: 'Bu kütüphane daha önce kaydedilmiş!',
                        icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
        <?php
            header("Refresh:2; url=kutuphane.php");
        } else {
            AdresKayit($mahalle, $cadde, $sokak, $binaNo, $kapiNo, $ilce, $il);
            $sonAdresID = SonAdresID();
            KutuphaneEkle($kutuphaneAd, $sonAdresID);

        ?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Kütüphane Kayıt',
                        text: 'Kütüphane başarıyla kaydedildi!',
                        icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
    <?php
            header("Refresh:2; url=kutuphane.php");
        }
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
                title: 'Kütüphane Kayıt',
                text: 'Kütüphane bilgileri eksik!',
                icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=kutuphane.php");
}
