<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");




$id = $_GET["id"];
if (!isset($id)) {
    header("location:karyawan.php");
}

$query_jabkar = "SELECT 
jabatan_karyawan.id,
jabatan_karyawan.karyawan_id,
karyawan.nama_lengkap,
jabatan.nama_jabatan,
jabatan_karyawan.tanggal_mulai
FROM jabatan_karyawan, karyawan, jabatan 
WHERE karyawan.id = jabatan_karyawan.karyawan_id 
AND jabatan.id = jabatan_karyawan.jabatan_id 
AND jabatan_karyawan.karyawan_id = $id ";

// $jabkar_stmt = $conn->prepare($query_jabkar);

// $jabkar_stmt->execute(['id' => $id]);
$jabkar_stmt = $conn->query($query_jabkar);

// $res_jabkar = mysqli_query($conn, $query_jabkar);
// $result_jabkar = $jabkar_stmt->fetch(PDO::FETCH_ASSOC);



//fetch data karyawan based on id
$query_karyawan = "SELECT * FROM karyawan WHERE id = :id";

$karyawan_stmt = $conn->prepare($query_karyawan);

$karyawan_stmt->execute(['id' => $id]);

$result_karyawan = $karyawan_stmt->fetch();


if (isset($_POST["submit"])) {

    //   $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING );
    //   $nik = filter_input(INPUT_POST, 'nik', FILTER_SANITIZE_STRING );
    $jabatan = filter_input(INPUT_POST, 'jabatan_id', FILTER_SANITIZE_STRING);
    $tanggal = filter_input(INPUT_POST, 'tanggal_mulai', FILTER_SANITIZE_STRING);

    $query = "INSERT into jabatan_karyawan(karyawan_id, jabatan_id ,tanggal_mulai) VALUES (
    :id, :jabatan, :tanggal)";
    $stmt = $conn->prepare($query);

    //execute the PDOStatement
    $saved = $stmt->execute([
        ":id" => $id,
        ":jabatan" => $jabatan,
        ":tanggal" => $tanggal
    ]);

    if ($saved) {
        echo "<script type='text/javascript'>
            alert('Data berhasil disimpan')
            document.location.href='karyawan.php'
          </script>";
    } else {
        echo "<script type='text/javascript'>
           alert('Data Gagal disimpan')
           document.location.href='karyawan-jabatan.php?id=$id'
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
                            <h1>Jabatan Karyawan</h1>
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
                                            <label for="nik">Nomor Induk Karyawan:</label>
                                            <input value="<?= $result_karyawan[1] ?>" type="text" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Karyawan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Karyawan:</label>
                                            <input value="<?= $result_karyawan[2] ?>" type="text" class="form-control" id="nama" name="nama" placeholder="Nama Karyawan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Pilih Jabatan:</label>
                                            <select name="jabatan_id" class="form-control">
                                                <option>-- Pilih Jabatan --</option>
                                                <?php
                                                $query_jabatan = "SELECT * FROM jabatan";
                                                $jabatan_stmt = $conn->query($query_jabatan);
                                                while ($jabatan = $jabatan_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?= $jabatan['id'] ?>"><?= $jabatan['nama_jabatan'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai:</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="tanggal mulai" required>
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
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Riwayat Jabatan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Nama Lengkap</th>
                                                <th>Tanggal Mulai</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;

                                            while ($row_jabkar = $jabkar_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td>
                                                        <a href="karyawan-jabatan-hapus.php?id=<?php echo $row_jabkar["id"]; ?>" class="btn btn-danger btn-xs text-light" onClick="javascript: return confirm('Apakah yakin ingin menghapus data ini...?');"><i class="fa fa-trash"></i> Hapus</a>
                                                    </td>

                                                    <td><?= $row_jabkar["nama_jabatan"]; ?></td>
                                                    <td><?= $row_jabkar["tanggal_mulai"]; ?></td>

                                                </tr>
                                            <?php $no++;
                                            }  ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Nama Lengkap</th>
                                                <th>Tanggal Mulai</th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
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