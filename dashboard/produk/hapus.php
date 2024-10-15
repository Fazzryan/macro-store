<?php
include "../../db/koneksi.php";
include "../../fungsi.php";

$slug = $_GET["slug"];

if (deleteProduk($slug) > 0) {
    echo "
            <script>
                alert('Data berhasil dihapus');
                window.location.href='index.php';
            </script>
        ";
} else {
    echo "
            <script>
                alert('Data gagal dihapus');
            </script>
        ";
}
