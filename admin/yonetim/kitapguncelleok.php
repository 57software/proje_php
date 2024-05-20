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

function KitapID($ISBN)
{
    include('../../baglanti.php');

    $sql = "SELECT kitap_id FROM tbl_kitaplar WHERE ISBN = '" . $ISBN . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $kitap_id = mysqli_fetch_array($sorgu);
    return $kitap_id[0];
}

function YayineviID($yayineviAdi)
{
    include('../../baglanti.php');
    $sql = "SELECT yayinEvi_id FROM tbl_yayin_evleri WHERE yayinEviAdi = '" . $yayineviAdi . "' ";
    $sorgu = mysqli_query($bagno, $sql);
    $yayineviID = mysqli_fetch_array($sorgu);
    return $yayineviID[0];
}

function YazarID($kitapID)
{
    include('../../baglanti.php');
    $sql = "SELECT yazar_id FROM yazarlar WHERE kitap_id = '" . $kitapID . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $kitap_id = mysqli_fetch_array($sorgu);
    return $kitap_id[0];
}

function KategoriID($kitapID)
{
    include('../../baglanti.php');
    $sql = "SELECT kategori_id FROM kategoriler WHERE kitap_id = '" . $kitapID . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $KategoriID = mysqli_fetch_array($sorgu);
    return $KategoriID[0];
}

function KitapGuncelle($kitapID, $yayineviID, $ISBN, $kitapAdi, $yayinTarihi, $sayfaSayisi, $kitapDili)
{
    include('../../baglanti.php');
    $sql = "UPDATE tbl_kitaplar SET yayinEvi_id='" . $yayineviID . "', ISBN='" . $ISBN . "', kitapAdi='" . $kitapAdi . "', yayinTarihi='" . $yayinTarihi . "', sayfaSayisi='" . $sayfaSayisi . "', kitapDili='" . $kitapDili . "' WHERE kitap_id='" . $kitapID . "'";
    mysqli_query($bagno, $sql);
}

function YazarGuncelle($yazarID, $kitapID, $yazarAd, $yazarSoyad)
{
    include('../../baglanti.php');
    $sql = "UPDATE yazarlar SET kitap_id='" . $kitapID . "', yazarAd='" . $yazarAd . "', yazarSoyad='" . $yazarSoyad . "' WHERE yazar_id='" . $yazarID . "'";
    mysqli_query($bagno, $sql);
}

function KutuphanedekiKitabi_Guncelle($kitapID, $kutuphaneID, $adet)
{
    include('../../baglanti.php');
    $sql = "UPDATE kitaplar_kutuphane SET kitap_id='" . $kitapID . "', kutuphane_id='" . $kutuphaneID . "', adet='" . $adet . "' WHERE kitap_id='" . $kitapID . "'";
    mysqli_query($bagno, $sql);
}

function KategoriGuncelle($kategoriID, $kitapID, $kategori)
{
    include('../../baglanti.php');
    $sql = "UPDATE kategoriler SET kitap_id='" . $kitapID . "', kategoriAdi='" . $kategori . "' WHERE kategori_id='" . $kategoriID . "'";
    mysqli_query($bagno, $sql);
}

if (
    isset($_POST['yayinEvi']) && isset($_POST['kategori']) && isset($_POST['kutuphaneID']) && isset($_POST['kitapAdeti']) &&
    isset($_POST['yazarAdi']) && isset($_POST['yazarSoyadi']) && isset($_POST['ISBN']) && isset($_POST['kitapAdi']) &&
    isset($_POST['yayinTarihi']) && isset($_POST['sayfaSayisi']) && isset($_POST['kitapDili'])
) {
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

    $tarihDizi = explode("-",$yayinTarihi); // yyyy0 aa1 gg2
    $tarih = $tarihDizi[2].".".$tarihDizi[1].".".$tarihDizi[0]; // gg.aa.yyyy

    try {
        $kitap_id = KitapID($ISBN);
        $yayinevi_id = YayineviID($yayinEvi);
        $yazar_id = YazarID($kitap_id);
        $kategori_id = KategoriID($kitap_id);

        KitapGuncelle($kitap_id, $yayinevi_id, $ISBN, $kitapAdi, $tarih, $sayfaSayisi, $kitapDili);
        YazarGuncelle($yazar_id, $kitap_id, $yazarAdi, $yazarSoyadi);
        KutuphanedekiKitabi_Guncelle($kitap_id, $kutuphaneID, $kitapAdeti);
        KategoriGuncelle($kategori_id, $kitap_id, $kategori);

?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kitap Güncelle',
                    text: 'Kitap güncellendi!',
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
} else {
    ?>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Kitap Güncelle',
                text: 'Bilgiler eksik!',
                icon: 'error', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
<?php
    header("Refresh:2; url=kitapislem.php");
}
?>