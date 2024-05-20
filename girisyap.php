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
    <title>Giriş Yap</title>
</head>

<body>
    <?php
    session_start();

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

    function Yasaklimi($kullaniciAdi)
    {
        include('baglanti.php');
        $sql = "SELECT yasaklimi FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "'";
        $sorgu = mysqli_query($bagno, $sql);
        if ($sorgu && mysqli_num_rows($sorgu) > 0) {
            $sonuc = mysqli_fetch_assoc($sorgu);
            return $sonuc;
        } else {
            return 2;
        }
    }

    function HesapKontrol($kullaniciAdi, $vt_sifre)
    {
        include('baglanti.php');
        $sql = "SELECT COUNT(uye_id) FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "' AND sifre = '" . $vt_sifre . "'";
        $sorgu = mysqli_query($bagno, $sql);
        $hesap = mysqli_fetch_array($sorgu);
        return $hesap[0];
    }

    function YetkiKontrol($kullaniciAdi)
    {
        include('baglanti.php');
        $sql = "SELECT yetki FROM tbl_uyeler WHERE kullaniciAdi = '" . $kullaniciAdi . "'";
        $sorgu = mysqli_query($bagno, $sql);
        $yetki = mysqli_fetch_array($sorgu);
        return $yetki[0];
    }

    $kullanici = trim($_POST['kullaniciAdi']);
    $sifre = trim($_POST['sifre']);

    $vt_sifre = Sifreleme($sifre);

    try {
        $yasaklimi = Yasaklimi($kullanici);

        if ($yasaklimi == 1) {
    ?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Uyarı!',
                        text: 'Bu kullanıcı yasaklandı!',
                        icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
        <?php
            header("Refresh:2; url=index.php");
        } else if ($yasaklimi == 2) {
        ?>
            <script>
                // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Uyarı!',
                        text: 'Bu kullanıcı kayıtlı değil!',
                        icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                        confirmButtonText: 'Tamam'
                    });
                });
            </script>
            <?php
            header("Refresh:2; url=index.php");
        } else {
            try {
                $hesap = HesapKontrol($kullanici, $vt_sifre);
                if ($hesap == 1) {
            ?>
                    <script>
                        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: 'Giriş!',
                                text: 'Giriş başarılı!',
                                icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                                confirmButtonText: 'Tamam'
                            });
                        });
                    </script>
                    <?php
                    $yetki = YetkiKontrol($kullanici);
                    if ($yetki == "Admin") {
                        $_SESSION['kullanici'] = $kullanici;
                        $_SESSION['yetki'] = "Yönetici";
                        header("Refresh:2; url=admin/admin.php");
                    } else if ($yetki == "Moderator") {
                        $_SESSION['kullanici'] = $kullanici;
                        $_SESSION['yetki'] = "Moderatör";
                        header("Refresh:2; url=moderator/moderator.php");
                    } else {
                        $_SESSION['kullanici'] = $kullanici;
                        $_SESSION['yetki'] = "Üye";
                        header("Refresh:2; url=uye/uye.php");
                    }
                } else {
                    ?>
                    <script>
                        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: 'Giriş!',
                                text: 'Kullanıcı adı veya şifre yanlış!',
                                icon: 'warning', // 'success', 'error', 'info', 'warning', 'question'
                                confirmButtonText: 'Tamam'
                            });
                        });
                    </script>
    <?php
                    header("Refresh:2; url=index.php");
                }
            } catch (Exception $e) {
                //hata var ise burada yakalanır
                echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
            }
        }
    } catch (Exception $e) {
        //hata var ise burada yakalanır
        echo "mesaj -> " . $e->getMessage(); //hata çıktısı üretilir
    }
    ?>
</body>

</html>