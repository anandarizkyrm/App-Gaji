<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");


$id = $_GET["id"];
$query = "SELECT * FROM lokasi WHERE id = :id ";
$oldstmt = $conn->prepare($query);

$oldstmt->execute(['id' => $id]);


$oldRes = $oldstmt->fetch();
if($saved){
  echo "<script type='text/javascript'>
          alert('Data berhasil diUpdate')
          document.location.href='lokasi.php'
        </script>";
}else{
  echo "<script type='text/javascript'>
         alert('Data Gagal diupdate')
         document.location.href='lokasi.php?id=$id'
         </script>";
}
if(isset($_POST["nama_lokasi"])){

  $lokasi = filter_input(INPUT_POST, 'nama_lokasi', FILTER_SANITIZE_STRING );
  $query = "UPDATE lokasi SET nama_lokasi = :nama_lokasi WHERE id = :id";

  $stmt = $conn->prepare($query);

  //execute the PDOStatement
  $saved = $stmt->execute([
    ":nama_lokasi" => $lokasi,
    ":id" => $id
  ]);



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
                            <h1>Data Lokasi</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="lokasi.php">Lokasi</a></li>
                                <li class="breadcrumb-item active">Tambah Lokasi</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Data</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="" method="post">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama Lokasi:</label>
                                            <input value="<?= $oldRes[1]; ?>" type="text" class="form-control" id="nama" name="nama_lokasi" placeholder="Nama Lokasi" required>
                                        </div>
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
                                        <a href="lokasi.php" class="btn btn-secondary">Cancel</a>
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
