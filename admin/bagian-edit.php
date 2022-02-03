<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");


$id = $_GET["id"];
$query = "SELECT * FROM bagian WHERE id = :id ";
$oldstmt = $conn->prepare($query);

$oldstmt->execute(['id' => $id]);


$oldRes = $oldstmt->fetch();

if(isset($_POST["submit"])){
    
$id = $_GET["id"];
    $nama = filter_input(INPUT_POST, 'nama_bagian', FILTER_SANITIZE_STRING );
    $kepala = filter_input(INPUT_POST, 'karyawan_id', FILTER_SANITIZE_STRING );
    $lokasi = filter_input(INPUT_POST, 'lokasi_id', FILTER_SANITIZE_STRING );

  
    $query = "UPDATE bagian SET nama_bagian = :nama_bagian,  karyawan_id = :karyawan_id ,lokasi_id = :lokasi_id WHERE id = $id";


    $query_lokasi =$conn->query("SELECT * FROM lokasi");

    $stmt = $conn->prepare($query);

    //execute the PDOStatement
    $saved = $stmt->execute([
        ":nama_bagian" => $nama,
        ":karyawan_id" => $kepala,
        ":lokasi_id" => $lokasi,
    ]);



    if($saved){
        echo "<script type='text/javascript'>
                alert('Data berhasil disimpan')
                document.location.href='bagian.php'
            </script>";
    }else{
        echo "<script type='text/javascript'>
            alert('Data Gagal disimpan')
            document.location.href='bagian-edit.php?id=$id'
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
                                  <li class="breadcrumb-item active">Tambah bagian</li>
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
                                              <label for="nama">Nama Bagian:</label>
                                              <input value="<?= $oldRes[1]?>" type="text" class="form-control" id="nama" name="nama_bagian" placeholder="Nama bagian" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="nama">Kepala bagian:</label>
                                              <select class="form-control" id="karyawan_id" name="karyawan_id" required>
                                                <option >-- Pilih Kepala Bagian --</option>
                                                <?php                  
                                                    $query_karyawan =$conn->query("SELECT * FROM karyawan");
                                                    while($row = $query_karyawan->fetch(PDO::FETCH_ASSOC)) { 
                                                        ?>
                                                        <?php 
                                                            if($row['id'] == $oldRes[2]){
                                                                ?>
                                                                <option value="<?= $row['id']?>" selected><?= $row['nama_lengkap']?></option>
                                                                <?php
                                                            }else{
                                                            ?>
                                                        <option value="<?= $row['id']?>"><?= $row['nama_lengkap']?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <label for="nama">Lokasi:</label>
                                              <select class="form-control" id="lokasi_id" name="lokasi_id" required>
                                                <option >-- Pilih Lokasi --</option>
                                                <?php                  
                                                    $query_lokasi =$conn->query("SELECT * FROM lokasi");
                                                    while($row = $query_lokasi->fetch(PDO::FETCH_ASSOC)) { 
                                                        ?>
                                                        <?php 
                                                            if($row['id'] == $oldRes[3]){
                                                                ?>
                                                                <option value="<?= $row['id']?>" selected><?= $row['nama_lokasi']?></option>
                                                                <?php
                                                            }else{
                                                            ?>
                                                        <option value="<?= $row['id']?>"><?= $row['nama_lokasi']?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                              </select>
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
  