<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");

$id = $_GET["id"];

$query1 = "SELECT * FROM karyawan WHERE id = :id ";
$oldstmt = $conn->prepare($query1);

$oldstmt->execute(['id' => $id]);


$oldRes = $oldstmt->fetch();



if (isset($_POST["submit"])) {

    $nik = filter_input(INPUT_POST, 'nik', FILTER_SANITIZE_STRING);
    $nama = filter_input(INPUT_POST, 'nama_lengkap', FILTER_SANITIZE_STRING);
    $handphone = filter_input(INPUT_POST, 'handphone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $pengguna_id = filter_input(INPUT_POST, 'pengguna_id');

    // $tanggal_masuk = filter_input(INPUT_POST, 'tanggal_masuk', FILTER_SANITIZE_STRING);
    // $pengguna_id = filter_input(INPUT_POST, 'pengguna_id', FILTER_SANITIZE_STRING);


    $query = "UPDATE karyawan SET nik = :nik,  nama_lengkap = :nama_lengkap , handphone = :handphone, email = :email, pengguna_id = :pengguna_id
     WHERE id = $id";

    $stmt = $conn->prepare($query);

    //execute the PDOStatement

    $saved = $stmt->execute([
        ":nik" => $nik,
        ":nama_lengkap" => $nama,
        ":handphone" => $handphone,
        ":email" => $email,
        ":pengguna_id" => isset($pengguna_id) ? $pengguna_id : NULL
    ]);

    echo $nik, "+", $nama, "+", $handphone,  "+", $email,  "+", $id;


    if ($saved) {
        echo "<script type='text/javascript'>
            alert('Data berhasil disimpan')
            document.location.href='karyawan.php'
          </script>";
    } else {
        echo "<script type='text/javascript'>
           alert('Data Gagal disimpan')
             document.location.href='karyawan-edit.php?id=$id'
           </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Lokasi | APPGAJI</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include "theme-header.php"; ?>

        <?php include "theme-sidebar.php"; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Tambah Data Karyawan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="lokasi.php">Lokasi</a></li>
                                <li class="breadcrumb-item active">Tambah Karyawan</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Data Karyawan</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="" method="post">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nik">Nomor Induk Karyawan:</label>
                                            <input type="text" value="<?php echo $oldRes[1] ?> " class="form-control" name="nik" placeholder="Nomor Induk Karyawan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Karyawan:</label>
                                            <input value="<?php echo $oldRes["nama_lengkap"] ?> " type="text" class="form-control" id="nama" name="nama_lengkap" placeholder="Nama Karyawan" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="handphone">Handphone:</label>
                                            <input value="<?php echo $oldRes[3] ?>" type="number" class="form-control" id="handphone" name="handphone" placeholder="handphone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input value="<?php echo $oldRes["email"] ?> " type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                        </div>

                                        <input type="hidden" name="pengguna_id" value="<?php echo $_SESSION["id"]; ?>">





                                        <!-- <div class="form-group">
                                        <label for="select">Select</label>
                                        <select class="form-control" id="select" name="select" required>
                                            <option value="">-- Pilih Agama --</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Textarea</label>
                                        <textarea class="form-control" rows="3" id="alamat" name="alamat" placeholder="Enter ..." required></textarea>
                                    </div> -->
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-1" name="submit">Simpan</button>
                                        <a href="karyawan.php" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include "theme-footer.php"; ?>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>