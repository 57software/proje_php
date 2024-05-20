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
    <title>Kayıt</title>
</head>

<body>
    <?php
    include('baglanti.php');

    function Sifreleme($kullanici_sifre)
    {
        $rastgeleSayi = "411349"; // 6
        $guvenlikBas = "Library"; // 7
        $guvenlikSon = "123987";  // 6
        // Min: 7+8+6+6=27
        // Max: 7+16+6+6=35

        $yapilanSifre = $guvenlikBas . $kullanici_sifre . $rastgeleSayi . $guvenlikSon; // 27 ya da 35

        $uretilenSifre = "1234567890"; // 10

        $sifre = $yapilanSifre . $uretilenSifre; // 27+10 = 37 ya da 35+10=45

        return $sifre;
    }

    function SifremiUnuttum($kullaniciAdi, $eposta)
    {
        include('baglanti.php');
        $sql = "SELECT COUNT(uye_id) FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "' AND eposta = '" . $eposta . "'";
        $sorgu = mysqli_query($bagno, $sql);
        $count = mysqli_fetch_array($sorgu);
        return $count[0];
    }

    // Verileri çekiyoruz
    $ePosta = trim($_POST['eposta']);
    $kullaniciAdi = trim($_POST['kullaniciAdi']);
    $sifre = trim($_POST['sifre']);

    if ($kullaniciAdi == "Admin" || $kullaniciAdi == "admin") {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Uyarı',
                    text: 'Admin kullanıcısının şifresi değiştirilemez!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:3; url=sifremiunuttum.php");
    } else if (strlen($sifre) < 8) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Uyarı',
                    text: '"Şifre 8 karakterden az olamaz!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
    <?php
        header("Refresh:3; url=sifremiunuttum.php");
    } else if (strlen($sifre) > 16) {
    ?>
        <script>
            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: 'Kayıt',
                    text: '"Şifre 16 karakterden fazla olamaz!',
                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                    confirmButtonText: 'Tamam'
                });
            });
        </script>
        <?php
        header("Refresh:3; url=sifremiunuttum.php");
    } else {
        try {
            $hesap = SifremiUnuttum($kullaniciAdi, $ePosta); // 1 hesap var - 0 hesap yok
            if ($hesap == 1) {
                try {
                    $vt_sifre = Sifreleme($sifre);

                    $sql = "UPDATE tbl_uyeler SET sifre = '" . $vt_sifre . "' WHERE kullaniciAdi='" . $kullaniciAdi . "'";
                    $sorgu = mysqli_query($bagno, $sql);
                    if ($sorgu) {
        ?>
                        <script>
                            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    title: 'Şifremi Unuttum',
                                    text: 'Şifre başarıyla değiştirildi!',
                                    icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                                    confirmButtonText: 'Tamam'
                                });
                            });
                        </script>
    <?php
                        header("Refresh:3; url=index.php");
                    }
                } catch (Exception $e) {
                    //hata var ise burada yakalanır
                    echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
                }
            }else{
                ?>
                        <script>
                            // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    title: 'Şifremi Unuttum',
                                    text: 'Kullanıcı adı veya eposta yanlış!',
                                    icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                                    confirmButtonText: 'Tamam'
                                });
                            });
                        </script>
    <?php
                        header("Refresh:3; url=index.php");
            }
        } catch (Exception $e) {
            //hata var ise burada yakalanır
            echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
        }
    }
    ?>
</body>