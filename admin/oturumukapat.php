<?php
session_start();
session_destroy();
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
        // Sayfa yüklendiğinde bir SweetAlert uyarısı gösterme
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Oturum Kapat',
                text: 'Oturum başarıyla sonlandırıldı!',
                icon: 'success', // 'success', 'error', 'info', 'warning', 'question'
                confirmButtonText: 'Tamam'
            });
        });
    </script>
</body>

<?php
header("Refresh:2; url=../index.php");
?>