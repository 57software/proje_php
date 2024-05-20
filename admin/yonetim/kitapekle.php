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

function isbnKontrol($ISBN)
{
    include('../../baglanti.php');

    $sql = "SELECT COUNT(ISBN) FROM tbl_kitaplar WHERE ISBN = '" . $ISBN . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $count = mysqli_fetch_array($sorgu); // $count[0]

    if ($count[0] == 0) return 1; // isbn kayıtlı değil ise 1
    else return 0;               // isbn kayıtlı ise 0
}

function YayineviID($yayineviAdi)
{
    include('../../baglanti.php');

    $sql = "SELECT yayinEvi_id FROM tbl_yayin_evleri WHERE yayinEviAdi = '" . $yayineviAdi . "' ";
    $sorgu = mysqli_query($bagno, $sql);
    $yayineviID = mysqli_fetch_array($sorgu); // $yayineviID[0]

    return $yayineviID[0];
}

function EnSonKayitKitapID()
{
    include('../../baglanti.php');

    $sql = "SELECT kitap_id FROM tbl_kitaplar ORDER BY kitap_id DESC LIMIT 1";
    $sorgu = mysqli_query($bagno, $sql);
    $kitapID = mysqli_fetch_array($sorgu);
    return $kitapID[0];
}

function YazarEkle($kitapID, $yazarAd, $yazarSoyad)
{
    include('../../baglanti.php');

    $sql = "INSERT INTO yazarlar VALUES(NULL,'" . $kitapID . "','" . $yazarAd . "','" . $yazarSoyad . "')";
    mysqli_query($bagno, $sql);
}

function KategoriEkle($kitapID, $kategoriAdi)
{
    include('../../baglanti.php');

    $sql = "INSERT INTO kategoriler VALUES(NULL,'" . $kitapID . "','" . $kategoriAdi . "')";
    mysqli_query($bagno, $sql);
}

function KutuphaneyeKitap_Ekle($kitapID, $kutuphaneID, $adet)
{
    include('../../baglanti.php');

    $sql = "INSERT INTO kitaplar_kutuphane VALUES('" . $kitapID . "','" . $kutuphaneID . "','" . $adet . "')";
    mysqli_query($bagno, $sql);
}

if (
    isset($_POST['yayinEvi']) && isset($_POST['kategori']) && isset($_POST['kutuphaneID']) && isset($_POST['kitapAdeti']) &&
    isset($_POST['yazarAdi']) && isset($_POST['yazarSoyadi']) && isset($_POST['ISBN']) && isset($_POST['kitapAdi']) &&
    isset($_POST['yayinTarihi']) && isset($_POST['sayfaSayisi']) && $_POST['kitapDili']
) {
    try {
        $yayinEvi = $_POST['yayinEvi'];
        $kategori = $_POST['kategori'];
        $kutuphaneID = trim($_POST['kutuphaneID']);
        $kitapAdeti = trim($_POST['kitapAdeti']);
        $yazarAdi = ucwords(strtolower(trim($_POST['yazarAdi'])));
        $yazarSoyadi = ucwords(strtolower(trim($_POST['yazarSoyadi'])));
        $ISBN = ucwords(strtolower(trim($_POST['ISBN'])));
        $kitapAdi = ucwords(strtolower(trim($_POST['kitapAdi'])));
        $yayinTarihi = $_POST['yayinTarihi']; // yyyy-aa-gg
        $sayfaSayisi = ucwords(strtolower(trim($_POST['sayfaSayisi'])));
        $kitapDili = ucwords(strtolower(trim($_POST['kitapDili'])));

        // vt kayıt için tarih çevirme
        $yayinTarihiDizi = explode("-", $yayinTarihi); // y0 a1 g2
        $yayinTarihiDizi_VT = $yayinTarihiDizi[2] . "." . $yayinTarihiDizi[1] . "." . $yayinTarihiDizi[0]; // gg.aa.yyyy

        $isbnKontrol = isbnKontrol($ISBN);
        if ($isbnKontrol == 0) {
?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Kayıt',
                        text: 'Bu kitap kayıtlı!',
                        icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
        <?php
            header("Refresh:2; url=kitaplar.php");
        } else {
            $yayinevi_ID = YayineviID($yayinEvi);
            $sql_kitapKayit = "INSERT INTO tbl_kitaplar VALUES(NULL,'" . $yayinevi_ID . "','" . $ISBN . "','" . $kitapAdi . "','" . $yayinTarihiDizi_VT . "','" . $sayfaSayisi . "','" . $kitapDili . "')";
            $sorgu_kitapKayit = mysqli_query($bagno, $sql_kitapKayit);

            $enSonki_kitapID = EnSonKayitKitapID();
            YazarEkle($enSonki_kitapID, $yazarAdi, $yazarSoyadi);
            KategoriEkle($enSonki_kitapID, $kategori);
            KutuphaneyeKitap_Ekle($enSonki_kitapID, $kutuphaneID, $kitapAdeti);
        ?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Kayıt',
                        text: 'Kitap başarıyla eklendi!',
                        icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
    <?php
            header("Refresh:2; url=kitaplar.php");
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
                title: 'Kayıt',
                text: 'Kitap bilgileri eksik!',
                icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=kitaplar.php");
}
