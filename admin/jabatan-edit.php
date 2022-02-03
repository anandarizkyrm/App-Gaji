<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");


$id = $_GET["id"];
$query = "SELECT * FROM jabatan WHERE id = :id ";
$oldstmt = $conn->prepare($query);

$oldstmt->execute(['id' => $id]);


$oldRes = $oldstmt->fetch();

if(isset($_POST["submit"])){
    
$id = $_GET["id"];
    $nama = filter_input(INPUT_POST, 'nama_jabatan', FILTER_SANITIZE_STRING );
    $gapok = filter_input(INPUT_POST, 'gapok', FILTER_SANITIZE_STRING );
    $tunjangan = filter_input(INPUT_POST, 'tunjangan', FILTER_SANITIZE_STRING );
    $uang_makan = filter_input(INPUT_POST, 'uang_makan', FILTER_SANITIZE_STRING );
  
    $query = "UPDATE jabatan SET nama_jabatan = :nama_jabatan,  gapok_jabatan = :gapok ,tunjangan_jabatan = :tunjangan, uang_makan_perhari = :uang_makan WHERE id = $id";

    $stmt = $conn->prepare($query);

    //execute the PDOStatement
    $saved = $stmt->execute([
        ":nama_jabatan" => $nama,
        ":gapok" => $gapok,
        ":tunjangan" => $tunjangan,
        ":uang_makan" => $uang_makan,
    ]);

    if($saved){
        echo "<script type='text/javascript'>
                alert('Data berhasil disimpan')
                document.location.href='jabatan.php'
            </script>";
    }else{
        echo "<script type='text/javascript'>
            alert('Data Gagal disimpan')
            document.location.href='jabatan-edit.php?id=$id'
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
                              <h1>Data Lokasi</h1>
                          </div>
                          <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                  <li class="breadcrumb-item"><a href="lokasi.php">Lokasi</a></li>
                                  <li class="breadcrumb-item active">Tambah Jabatan</li>
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
                                      <h3 class="card-title">Tambah Data</h3>
                                  </div>
                                  <!-- /.card-header -->
                                  <!-- form start -->
                                  <form action="" method="post">
                                      <div class="card-body">
                                          <div class="form-group">
                                              <label for="nama">Nama Lokasi:</label>
                                              <input value="<?= $oldRes[1]?>" type="text" class="form-control" id="nama" name="nama_jabatan" placeholder="Nama Jabatan" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="nama">Gapok Jabatan:</label>
                                              <input value="<?= $oldRes[2]?>" type="text" class="form-control" id="nama" name="gapok" placeholder="Gaji Pokok Jabatan" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="nama">Tunjangan Jabatan:</label>
                                              <input value="<?= $oldRes[3]?>" type="text" class="form-control" id="nama" name="tunjangan" placeholder="Tunjangan Jabatan" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="nama">Uang Makan Perhari:</label>
                                              <input value="<?= $oldRes[4]?>" type="text" class="form-control" id="nama" name="uang_makan" placeholder="Uang Makan Perhari" required>
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
  