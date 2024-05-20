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

function EmanetKontrol($kullaniciAdi, $ISBN)
{
    include('../baglanti.php');

    // uye id
    $sql_uyeID = "SELECT uye_id FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "'";
    $sorgu_uyeID = mysqli_query($bagno, $sql_uyeID);
    $uyeID = mysqli_fetch_array($sorgu_uyeID); // $uyeID[0]

    // kitap id
    $sql_kitapID = "SELECT kitap_id FROM tbl_kitaplar WHERE ISBN = '" . $ISBN . "'";
    $sorgu_kitapID = mysqli_query($bagno, $sql_kitapID);
    $kitapID = mysqli_fetch_array($sorgu_kitapID); // $kitapID[0]

    // emanet kontrol
    $sql = "SELECT COUNT(kitap_id) FROM tbl_emanet WHERE uye_id = '" . $uyeID[0] . "' AND kitap_id = '" . $kitapID[0] . "' AND emanetmi = 1";
    $sorgu = mysqli_query($bagno, $sql);
    $count = mysqli_fetch_array($sorgu);

    if ($count[0] == 0) return true; // emanet alınmamış
    else return false;               // emanet alınmış
}

function HesapKontrol($kullaniciAdi)
{
    include('../baglanti.php');
    $sql = "SELECT COUNT(uye_id) FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $count = mysqli_fetch_array($sorgu);
    return $count[0];
}

function KitapAdet($ISBN)
{
    include('../baglanti.php');

    // kitap id
    $sql_kitapID = "SELECT kitap_id FROM tbl_kitaplar WHERE ISBN = '" . $ISBN . "'";
    $sorgu_kitapID = mysqli_query($bagno, $sql_kitapID);
    $kitapID = mysqli_fetch_array($sorgu_kitapID); // $kitapID[0]

    // adet
    $sql = "SELECT adet FROM kitaplar_kutuphane WHERE kitap_id = '" . $kitapID[0] . "'";
    $sorgu = mysqli_query($bagno, $sql);
    $adet = mysqli_fetch_array($sorgu); // $adet[0]

    return $adet[0];
}

try {
    if (isset($_GET['kullaniciAdi']) && isset($_GET['ISBN']) && isset($_GET['kutuphaneID'])) {
        $kullaniciAdi = $_GET['kullaniciAdi'];
        $ISBN = $_GET['ISBN'];
        $kutuphaneID = $_GET['kutuphaneID'];

        $emanetTarihi = date('d.m.Y'); // emanet verilen tarih

        $teslimTarihi = date("d.m.Y", strtotime("+10 days", strtotime($emanetTarihi))); // emanet verilen tarihten 10 gün sonrası

        $emanetKontrol = EmanetKontrol($kullaniciAdi, $ISBN);
        $hesapKontrol = HesapKontrol($kullaniciAdi);
        $kitapAdet = KitapAdet($ISBN);

        if ($hesapKontrol == 0) {
?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Uyarı',
                        text: 'Kullanıcı kayıtlı değil!',
                        icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
            <?php
            header("Refresh:2; url=emanetver.php");
        } else {
            if ($kitapAdet == 0) {
            ?>
                <script>
                    // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: 'Uyarı',
                            text: 'Kitap stokta yok!',
                            icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                            confirmButtonText: 'Tamam'
                        });
                    });
                </script>
                <?php
                header("Refresh:2; url=emanetver.php");
            } else {
                if ($emanetKontrol) { // Kitap emanet alınmamışsa çalışacak
                    try {
                        $sql_uyeID = "SELECT uye_id FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "'";
                        $sorgu_uyeID = mysqli_query($bagno, $sql_uyeID);
                        $uyeID = mysqli_fetch_array($sorgu_uyeID); // $uyeID[0]

                        $sql_emanetSayisi = "SELECT COUNT(uye_id) FROM tbl_emanet WHERE uye_id = '" . $uyeID[0] . "' AND emanetmi = 1";
                        $sorgu_emanetSayisi = mysqli_query($bagno, $sql_emanetSayisi);
                        $emanetSayisi = mysqli_fetch_array($sorgu_emanetSayisi); // $emanetSayisi[0]

                        if (EmanetKontrol($kullaniciAdi, $ISBN)) {
                            if ($emanetSayisi[0] == 3) {
                ?>
                                <script>
                                    // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                                    document.addEventListener("DOMContentLoaded", function() {
                                        Swal.fire({
                                            title: 'Uyarı',
                                            text: 'Kullanıcı emanet alma sınırına ulaştı!',
                                            icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                                            confirmButtonText: 'Tamam'
                                        });
                                    });
                                </script>
                            <?php
                                header("Refresh:2; url=emanetver.php");
                            } else {
                                // kitap id
                                $sql_kitapID = "SELECT kitap_id FROM tbl_kitaplar WHERE ISBN = '" . $ISBN . "'";
                                $sorgu_kitapID = mysqli_query($bagno, $sql_kitapID);
                                $kitapID = mysqli_fetch_array($sorgu_kitapID); // $kitapID[0]

                                $sql_emanetVer = "INSERT INTO tbl_emanet VALUES(NULL,'" . $uyeID[0] . "','" . $kitapID[0] . "','" . $kutuphaneID . "','" . $emanetTarihi . "','" . $teslimTarihi . "','0','1')";
                                $sorgu_emanetVer = mysqli_query($bagno, $sql_emanetVer);

                                $kitapSayisi = 0;
                                $kitapSayisi = $kitapAdet - 1;

                                $sql_adetGuncelle = "UPDATE kitaplar_kutuphane SET kitap_id='" . $kitapID[0] . "', kutuphane_id='" . $kutuphaneID . "', adet='" . $kitapSayisi . "' WHERE kitap_id='" . $kitapID[0] . "'";
                                $sorgu_adetGuncelle = mysqli_query($bagno, $sql_adetGuncelle);

                            ?>
                                <script>
                                    // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                                    document.addEventListener("DOMContentLoaded", function() {
                                        Swal.fire({
                                            title: 'Emanet Ver',
                                            text: 'Kitap emanet verildi!',
                                            icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                                            confirmButtonText: 'Tamam'
                                        });
                                    });
                                </script>
                    <?php
                                header("Refresh:2; url=emanetver.php");
                            }
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
                                title: 'Uyarı',
                                text: 'Kullanıcı daha önce bu kitabı emanet aldı!',
                                icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                                confirmButtonText: 'Tamam'
                            });
                        });
                    </script>
<?php
                    header("Refresh:2; url=emanetver.php");
                }
            }
        }
    }
} catch (Exception $e) {
    //hata var ise burada yakalanır
    echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
}
