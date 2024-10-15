<?php
include "db/koneksi.php";

// Login
function login($data)
{
    global $koneksi;
    // var_dump($_POST);
    // die;
    $email = $data["email"];
    $password = md5($data["password"]);

    // $user = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
    // if (mysqli_num_rows($user) === 1) {
    //     $data = mysqli_fetch_assoc($user);
    //     if (password_verify($password, $data["password"])) {
    //         $_SESSION['id_user'] = $data['id_user'];
    //         $_SESSION['username'] = $data['username'];
    //         $_SESSION['email'] = $data['email'];
    //         $_SESSION['password'] = $data['password'];
    //     } else {
    //         echo "error";
    //     }
    // }
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email' AND password = '$password'");
    $data = mysqli_fetch_array($query);

    if (empty($data["email"])) {
        echo "
            <script>
                alert('Login Gagal!');
            </script>
            ";
    } else {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['role'] = $data['role'];
    }
    return mysqli_affected_rows($koneksi);
}
// Logout
function logout()
{
    session_destroy();
    echo "
    <script>
        alert('Berhasil Logout!'); 
        window.location ='login.php';
    </script>";
}
// Buat Akun User
function adduser($data)
{
    global $koneksi;

    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $role = htmlspecialchars($data["role"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $konfir_password = mysqli_real_escape_string($koneksi, $data["konfir_password"]);

    if ($password !== $konfir_password) {
        echo "<script>
                alert('Password tidak sesuai');
            </script>";
        return false;
    }

    // $password = password_hash($password, PASSWORD_DEFAULT);
    $password = md5($password);
    $tambahUser = mysqli_query($koneksi, "INSERT INTO user (id_user, username, email, password, role) VALUES ('', '$username', '$email', '$password', '$role')");
    if ($tambahUser) {
        return mysqli_affected_rows($koneksi);
    }
}
// Buat Akun Admin
function addAdmin($data)
{
    global $koneksi;

    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $konfir_password = mysqli_real_escape_string($koneksi, $data["konfir_password"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $nomorhp = htmlspecialchars($data["nomorhp"]);

    if ($password !== $konfir_password) {
        echo "<script>
                alert('Password tidak sesuai');
            </script>";
        return false;
    }

    // $password = password_hash($password, PASSWORD_DEFAULT);
    $password = md5($password);
    $tambahUser = mysqli_query($koneksi, "INSERT INTO user (id_user, username, email, password, tanggal_lahir, jenis_kelamin, nomorhp, role) VALUES ('', '$username', '$email', '$password', '$tanggal_lahir', '$jenis_kelamin', '$nomorhp', 'admin')");
    if ($tambahUser) {
        return mysqli_affected_rows($koneksi);
    }
}
// Update User
function updateUser($data)
{
    global $koneksi;

    $id_user = htmlspecialchars($data["id_user"]);
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $nomorhp = htmlspecialchars($data["nomorhp"]);

    // $password = mysqli_real_escape_string($koneksi, $data["password"]);
    // $password = password_hash($password, PASSWORD_DEFAULT);

    $target_dir = "../userPicture/";
    $target_file = $target_dir . basename($_FILES["gambar_baru"]["name"]);
    $ukuran_file = $_FILES["gambar_baru"]["size"];
    $tipe_file = $_FILES["gambar_baru"]["type"];
    $upload_berhasil = 1;
    $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $gambar_baru = basename($_FILES["gambar_baru"]["name"]);
    $gambar_sekarang = $data["gambar_sekarang"];

    if ($gambar_baru != '') {
        $user_picture = $gambar_baru;
    } else {
        $user_picture = $gambar_sekarang;
    }

    if ($_FILES["gambar_baru"]["name"] != '') {
        if (file_exists($target_file)) {
            echo "
                <script>
                    alert('File sudah ada, ganti nama gambar!')
                    window.location='setting.php'
                </script>
            ";
            $upload_berhasil = 0;
        }
    }
    // Cek Ukuran File, ukuran dalam byte
    if ($ukuran_file > 5000000) {
        echo "
            <script>
                alert('Ukuran file terlalu besar!')
                window.location='setting.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Mengizinkan file dengan format tertentu
    if ($tipe_file != "png" && $tipe_file != "jpeg" && $tipe_file != "jpg" && $tipe_file != "") {
        echo "
            <script>
                alert('File tidak di izinkan!')
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Cek apakah $upload_berhasil nilainya 0 dan menampilkan pesan kesalahan
    if ($upload_berhasil == 0) {
        echo "
            <script>
                alert('File tidak bisa diupload!')
                window.location='setting.php'
            </script>
        ";
        // Jika $upload_berhasil = 1 maka coba upload file
    } else {
        // if (move_uploaded_file($_FILES["gambar_baru"]["tmp_name"], $target_file)) {
        $updateUser = mysqli_query($koneksi, "UPDATE user SET username = '$username', email = '$email', tanggal_lahir = '$tanggal_lahir', jenis_kelamin = '$jenis_kelamin', nomorhp = '$nomorhp', picture = '$user_picture' WHERE id_user = '$id_user'");
        if ($updateUser) {
            if ($_FILES["gambar_baru"]["name"] != '') {
                move_uploaded_file($_FILES["gambar_baru"]["tmp_name"], $target_file);
                unlink($target_dir . $gambar_sekarang);
            }
            return mysqli_affected_rows($koneksi);
        } else {
            echo "Gagal Simpan";
        }
        // } else {
        //     echo "Upload file gagal";
        // }
    }
}
// Update Admin
function updateAdmin($data)
{
    global $koneksi;

    $id_user = htmlspecialchars($data["id_user"]);
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $nomorhp = htmlspecialchars($data["nomorhp"]);
    $password = htmlspecialchars($data["password"]);
    $password_baru = htmlspecialchars($data["password_baru"]);

    if ($password_baru != "") {
        $new_pass = md5($data["password_baru"]);;
    } else {
        $new_pass = htmlspecialchars($data["password"]);
    }

    $update_pass =  mysqli_query($koneksi, "UPDATE user SET username = '$username', email = '$email', password = '$new_pass', tanggal_lahir = '$tanggal_lahir', jenis_kelamin = '$jenis_kelamin', nomorhp = '$nomorhp' WHERE id_user = '$id_user'");
    if ($update_pass) {
        return mysqli_affected_rows($koneksi);
    }
}
// Upload Foto User
function addUserPicture($data)
{
    global $koneksi;
    $id_user = $data["id_user"];
}
// Ambil data 
function show($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Tambah Produk
function addProduk($data)
{
    global $koneksi;

    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $slug = htmlspecialchars($data["slug"]);
    $id_kategori = htmlspecialchars($data["id_kategori"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);
    $kondisi = htmlspecialchars($data["kondisi"]);
    $deskripsi = $data["deskripsi"];

    if ($nama_produk == "" || $slug == "" || $id_kategori == "" || $harga == "" || $kondisi == "" ||  $deskripsi == "") {
        echo "
            <script>
                alert('Lengkapi semua data!')
            </>
        ";
        return;
    }

    $target_dir = "../../fileUpload/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $gambar = basename($_FILES["gambar"]["name"]);
    $ukuran_file = $_FILES["gambar"]["size"];
    $tipe_file = $_FILES["gambar"]["type"];
    $upload_berhasil = 1;
    $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        echo "
            <script>
                alert('File sudah ada, ganti nama gambar!')
                window.location='tambahProduk.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Cek Ukuran File, ukuran dalam byte
    if ($ukuran_file > 5000000) {
        echo "
            <script>
                alert('Ukuran file terlalu besar!')
                window.location='tambahProduk.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Mengizinkan file dengan format tertentu
    if ($tipe_file != "png" && $tipe_file != "jpeg" && $tipe_file != "jpg") {
        echo "
            <script>
                alert('File tidak di izinkan!')
                window.location='tambahProduk.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Cek apakah $upload_berhasil nilainya 0 dan menampilkan pesan kesalahan
    if ($upload_berhasil == 0) {
        echo "
            <script>
                alert('File tidak bisa diupload!')
                window.location='tambahProduk.php'
            </script>
        ";
        // Jika $upload_berhasil = 1 maka coba upload file
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $query = mysqli_query($koneksi, "INSERT INTO produk (id_produk, nama_produk, slug, id_kategori, harga, stok, kondisi, deskripsi, gambar) 
            VALUES ('','$nama_produk','$slug' ,'$id_kategori','$harga', '$stok','$kondisi','$deskripsi','$gambar')");
            if ($query) {
                return mysqli_affected_rows($koneksi);
            } else {
                echo "Gagal Simpan";
            }
        } else {
            echo "Upload file gagal";
        }
    }
}

// Edit Produk
function editProduk($data)
{
    global $koneksi;

    $id_produk = htmlspecialchars($data["id_produk"]);
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $slug = htmlspecialchars($data["slug"]);
    $id_kategori = htmlspecialchars($data["id_kategori"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);
    $kondisi = htmlspecialchars($data["kondisi"]);
    $deskripsi = $data["deskripsi"];

    if ($nama_produk == "" || $slug == "" || $id_kategori == "" || $harga == "" || $kondisi == "" || $deskripsi == "") {
        echo "
            <script>
                alert('Lengkapi semua data!')
            </script>
        ";
        return;
    }

    $target_dir = "../../fileUpload/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $ukuran_file = $_FILES["gambar"]["size"];
    $tipe_file = $_FILES["gambar"]["type"];
    $upload_berhasil = 1;
    $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $gambarBaru = basename($_FILES["gambar"]["name"]);
    $gambarLama = $data["gambar_lama"];

    if ($gambarBaru != '') {
        $updateGambar = basename($_FILES["gambar"]["name"]);
    } else {
        $updateGambar = $gambarLama;
    }

    if ($_FILES["gambar"]["name"] != '') {
        if (file_exists($target_file)) {
            echo "
                <script>
                    alert('File sudah ada, ganti nama gambar!')
                    window.location='Produk.php'
                </script>
            ";
            $upload_berhasil = 0;
        }
    }
    if ($tipe_file != "png" && $tipe_file != "jpeg" && $tipe_file != "jpg" && $tipe_file != "") {
        echo "
            <script>
                alert('File tidak di izinkan!')
                window.location='tambahProduk.php'
            </script>
        ";
        $upload_berhasil = 0;
    }

    if ($ukuran_file > 5000000) {
        echo "
            <script>
                alert('Ukuran file terlalu besar!')
                window.location='Produk.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    if ($upload_berhasil == 0) {
        echo "
            <script>
                alert('File tidak bisa diupload!')
                window.location='index.php'
            </script>
        ";
        // Jika $upload_berhasil = 1 maka coba upload file
    } else {
        $simpan = mysqli_query($koneksi, "UPDATE produk SET slug='$slug', nama_produk='$nama_produk', id_kategori='$id_kategori', harga='$harga', stok='$stok', kondisi='$kondisi', deskripsi='$deskripsi', gambar='$updateGambar' WHERE id_produk = '$id_produk'");
        if ($simpan) {
            if ($_FILES["gambar"]["name"] != '') {
                move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
                unlink($target_dir . $gambarLama);
            }
            return mysqli_affected_rows($koneksi);
        } else {
            echo "Gagal update!";
        }
    }
}
// Hapus Produk
function deleteProduk($slug)
{
    global $koneksi;
    $produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE slug = '$slug'");
    $data = mysqli_fetch_array($produk);

    $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE slug = '$slug'");
    if ($hapus) {
        unlink("../../fileUpload/$data[gambar]");
        return mysqli_affected_rows($koneksi);
    }
}

// Tambah Kategori
function addKategori($data)
{
    global $koneksi;

    $nama_kategori = htmlspecialchars($data["nama_kategori"]);
    $icon_kategori = htmlspecialchars($data["icon_kategori"]);
    if ($nama_kategori == "" ||  $icon_kategori  ==  "") {
        echo "
            <script>
                alert('semua form harus di isi!')
            </script>
        ";
        return;
    }
    $query = "INSERT INTO kategori (id_kategori, nama_kategori, icon_kategori) VALUES ('','$nama_kategori', '$icon_kategori')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// Edit Kategori
function editKategori($data)
{
    global $koneksi;

    $id_kategori = htmlspecialchars($data["id_kategori"]);
    $nama_kategori = htmlspecialchars($data["nama_kategori"]);
    $icon_kategori = htmlspecialchars($data["icon_kategori"]);

    $query = "UPDATE kategori SET nama_kategori = '$nama_kategori', icon_kategori = '$icon_kategori' WHERE id_kategori = '$id_kategori'";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// Hapus Kategori
function deleteKategori($id_kategori)
{
    global $koneksi;
    $query = "DELETE FROM kategori WHERE id_kategori = '$id_kategori'";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
// Tambah Keranjang
function tambah_keranjang($data)
{
    global $koneksi;

    $id_produk = htmlspecialchars($data["id_produk"]);
    $id_user = htmlspecialchars($data["id_user"]);
    $jumlah_produk = htmlspecialchars($data["jumlah_produk"]);
    $harga_produk = htmlspecialchars($data["total_harga_produk"]);

    $total_harga_produk = $jumlah_produk * $harga_produk;

    $query = mysqli_query($koneksi, "INSERT INTO keranjang (id_keranjang, id_produk, id_user, jumlah_produk, total_harga_produk) VALUES ('', '$id_produk','$id_user','$jumlah_produk','$total_harga_produk')");

    if ($query) {
        return mysqli_affected_rows($koneksi);
    }
}

// Hapus Keranjang
function deleteKeranjang($data)
{
    global $koneksi;

    $id_keranjang = $data["id_keranjang"];
    $id_user = $data["id_user"];

    $query =  mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang' AND id_user = '$id_user'");
    if ($query) {
        return mysqli_affected_rows($koneksi);
    }
}
// Tambah Komentar
function addKomentar($data)
{
    global $koneksi;

    $id_produk = htmlspecialchars($data["id_produk"]);
    $id_user = htmlspecialchars($data["id_user"]);
    $rating = htmlspecialchars($data["rating"]);
    $pesan = htmlspecialchars($data["pesan"]);
    $tgl_pesan = htmlspecialchars($data["tgl_pesan"]);

    $query = mysqli_query($koneksi, "INSERT INTO komentar (id_komentar, id_user, id_produk, rating, pesan, tgl_pesan) VALUES ('', '$id_user','$id_produk', '$rating', '$pesan','$tgl_pesan')");

    if ($query) {
        return mysqli_affected_rows($koneksi);
    }
}
// Tambah Alamat
function addAlamat($data)
{
    global $koneksi;

    $id_user = htmlspecialchars($data["id_user"]);
    $label_alamat = htmlspecialchars($data["label_alamat"]);
    $alamat_lengkap = htmlspecialchars($data["alamat_lengkap"]);
    $catatan = htmlspecialchars($data["catatan"]);
    $penerima = htmlspecialchars($data["penerima"]);
    $nohp_penerima = htmlspecialchars($data["nohp_penerima"]);

    $query = mysqli_query($koneksi, "INSERT INTO alamat (id_alamat, id_user, label_alamat, alamat_lengkap, catatan, penerima, nohp_penerima) VALUES
    ('','$id_user','$label_alamat','$alamat_lengkap','$catatan','$penerima','$nohp_penerima')
    ");

    if ($query) {
        return mysqli_affected_rows($koneksi);
    }
}
// Edit Alamat
function editAlamat($data)
{
    global $koneksi;

    $id_alamat = htmlspecialchars($data["id_alamat"]);
    $id_user = htmlspecialchars($data["id_user"]);
    $label_alamat = htmlspecialchars($data["label_alamat"]);
    $alamat_lengkap = htmlspecialchars($data["alamat_lengkap"]);
    $catatan = htmlspecialchars($data["catatan"]);
    $penerima = htmlspecialchars($data["penerima"]);
    $nohp_penerima = htmlspecialchars($data["nohp_penerima"]);

    $query = mysqli_query($koneksi, "UPDATE alamat SET id_user = '$id_user', label_alamat = '$label_alamat', alamat_lengkap = '$alamat_lengkap', catatan = '$catatan', penerima = '$penerima', nohp_penerima = '$nohp_penerima' WHERE id_alamat = '$id_alamat'");

    if ($query) {
        return mysqli_affected_rows($koneksi);
    }
}

// Hapus Alamat
function deleteAlamat($data)
{
    global $koneksi;

    $id_alamat = $data["id_alamat"];
    $id_user = $data["id_user"];

    $query =  mysqli_query($koneksi, "DELETE FROM alamat WHERE id_alamat = '$id_alamat' AND id_user = '$id_user'");
    if ($query) {
        return mysqli_affected_rows($koneksi);
    }
}

function prosesPembayaran($data)
{
    global $koneksi;

    $kode_pesanan = $data["kode_pesanan"];
    $id_user = $data["id_user"];
    $id_produk = $data["id_produk"];
    $id_alamat = $data["id_alamat_penerima"];
    $jumlah_item = $data["jumlah_item"];
    $jumlah_produk = $data["jumlah_produk"];
    $ongkir = $data["ongkir"];
    $jasa_pengiriman = $data["jasa_pengiriman"];
    $metode_pembayaran = $data["metode_pembayaran"];
    $total_harga_belanja = $data["total_harga_belanja"];
    $tgl_pesanan = $data["tgl_pesanan"];
    foreach ($id_produk as $id_prod) {
        echo $id_prod;
    }
    foreach ($jumlah_produk as $jml_item) {
        echo $jml_item;
    }
    $query =  mysqli_query($koneksi, "INSERT INTO pesanan (id_pesanan, kode_pesanan, id_user, id_produk, id_alamat, jumlah_item, ongkir, jasa_pengiriman, metode_pembayaran, total_harga_belanja, tgl_pesanan) VALUES ('', '$kode_pesanan', '$id_user', '$id_prod', '$id_alamat', '$jml_item', '$ongkir','$jasa_pengiriman','$metode_pembayaran', '$total_harga_belanja', '$tgl_pesanan')");
    if ($query) {
        // jika di checkout maka hapus barang yg ada dikeranjang
        $hapus_kerajang = mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_user = '$id_user' AND id_produk IN ($id_prod)");
        return mysqli_affected_rows($koneksi);
    }
}

function konfirmasiPembayaran($data)
{
    global $koneksi;

    $kode_pesanan = $data["kode_pesanan"];
    $id_user = $data["id_user"];
    $nama_bank = $data["nama_bank"];
    $tgl_transfer = $data["tgl_transfer"];
    $jml_transfer = $data["jml_transfer"];
    $rekening_tujuan = $data["rekening_tujuan"];
    $atas_nama = $data["atas_nama"];

    $target_dir = "../filePembayaran/";
    $target_file = $target_dir . basename($_FILES["bukti_pembayaran"]["name"]);
    $bukti_pembayaran = basename($_FILES["bukti_pembayaran"]["name"]);
    $ukuran_file = $_FILES["bukti_pembayaran"]["size"];
    $tipe_file = $_FILES["bukti_pembayaran"]["type"];
    $upload_berhasil = 1;
    $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        echo "
            <script>
                alert('File sudah ada, ganti nama gambar!')
                window.location='pembayaran.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Cek Ukuran File, ukuran dalam byte
    if ($ukuran_file > 5000000) {
        echo "
            <script>
                alert('Ukuran file terlalu besar!')
                window.location='pembayaran.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Mengizinkan file dengan format tertentu
    if ($tipe_file != "png" && $tipe_file != "jpeg" && $tipe_file != "jpg") {
        echo "
            <script>
                alert('File tidak di izinkan!')
                window.location='pembayaran.php'
            </script>
        ";
        $upload_berhasil = 0;
    }
    // Cek apakah $upload_berhasil nilainya 0 dan menampilkan pesan kesalahan
    if ($upload_berhasil == 0) {
        echo "
            <script>
                alert('File tidak bisa diupload!')
                window.location='pembayaran.php'
            </script>
        ";
        // Jika $upload_berhasil = 1 maka coba upload file
    } else {
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            $query =  mysqli_query($koneksi, "INSERT INTO pembayaran (id_pembayaran, kode_pesanan, id_user, nama_bank, tgl_transfer, jml_transfer, rekening_tujuan, atas_nama, bukti_pembayaran) VALUES ('', '$kode_pesanan', '$id_user', '$tgl_transfer', '$nama_bank', '$jml_transfer', '$rekening_tujuan', '$atas_nama', '$bukti_pembayaran')");
            // update status pesanan user
            $query2 = mysqli_query($koneksi, "UPDATE pesanan SET status = 'Menunggu Konfirmasi' WHERE id_user = '$id_user' AND kode_pesanan = '$kode_pesanan'");
            if ($query) {
                return mysqli_affected_rows($koneksi);
            } else {
                echo "Gagal Simpan";
            }
        } else {
            echo "Upload file gagal";
        }
    }
}

function generateRandomString()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $length = 3; // Ubah panjang string sesuai kebutuhan

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}
function formatKeRupiah($angka)
{
    $hasi_rupiah = number_format($angka, 2, ',', '.');
    return  $hasi_rupiah;
}
function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// Fungsi untuk menambahkan nilai 'urut' ke URL tanpa menambahkan kembali nilai yang sudah ada
function tambahUrutKeURL($url, $urut)
{
    if (strpos($url, "urut=") === false) {
        // Jika parameter 'urut' belum ada, tambahkan ke URL
        $url .= (strpos($url, "?") !== false) ? "&" : "?";
        $url .= "urut=";
        $url .= $urut;
    } else {
        // Jika parameter 'urut' sudah ada, ubah nilainya atau tambahkan jika belum ada
        $url = preg_replace("/urut=[^&]+/", "urut=$urut", $url);
        if (strpos($url, "urut=$urut") === false) {
            $url .= "&urut=$urut";
        }
    }
    return $url;
}
