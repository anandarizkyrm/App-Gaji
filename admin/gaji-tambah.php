<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");





if (isset($_POST["submit"])) {

    $tahun = filter_input(INPUT_POST, 'tahun', FILTER_SANITIZE_STRING);
    $bulan = filter_input(INPUT_POST, 'bulan', FILTER_SANITIZE_STRING);
    $karyawan = filter_input(INPUT_POST, 'karyawan_id', FILTER_SANITIZE_STRING);
    $jabatan_id = filter_input(INPUT_POST, 'jabatan_id', FILTER_SANITIZE_STRING);


    $query = "SELECT * FROM jabatan WHERE id = :id ";
    $oldstmt = $conn->prepare($query);

    $oldstmt->execute(['id' => $jabatan_id]);

    $oldRes = $oldstmt->fetch();



    $gapok = $oldRes['gapok_jabatan'];
    $tunjangan = $oldRes['tunjangan_jabatan'];
    $uang_makan = $oldRes['uang_makan_perhari'];



    $query = "INSERT into penggajian( karyawan_id, tahun, bulan , gapok, tunjangan, uang_makan )  VALUES (:karyawan_id, :tahun, :bulan , :gapok, :tunjangan, :uang_makan)";


    $stmt = $conn->prepare($query);

    //execute the PDOStatement
    $saved = $stmt->execute([
        ':karyawan_id' => $karyawan,
        ':tahun' => $tahun,
        ':bulan' => $bulan,
        ':gapok' => $gapok,
        ':tunjangan' => $tunjangan,
        ':uang_makan' => $uang_makan,
    ]);

    if ($saved) {
        echo "<script type='text/javascript'>
                alert('Data berhasil disimpan')
                  document.location.href='gaji.php'
            </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Data Gagal disimpan')
            document.location.href='gaji-edit.php?id=$id'
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Gaji | APPGAJI</title>
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
                            <h1>Data gaji</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="gaji.php">Gaji</a></li>
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
                                            <label for="tahun">Tahun :</label>
                                            <input value="<?= date('Y'); ?>" type="text" class="form-control" id="tahun" name="tahun" placeholder="Masukan Tahun" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="bulan">Bulan</label>
                                            <select class="form-control" id="bulan" name="bulan" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>



                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="bulan">Karyawan</label>
                                            <select class="form-control" id="karyawan" name="karyawan_id" required>
                                                <option value="">-- Pilih Karyawan--</option>
                                                <?php $query = "SELECT * FROM karyawan";
                                                $stmt = $conn->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->fetchAll();
                                                foreach ($result as $row) : ?>
                                                    <option value="<?= $row['id']; ?>"><?= $row['nama_lengkap']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="bulan">Jabatan Terakhir</label>
                                            <select class="form-control" id="jabatan" name="jabatan_id" required>
                                                <option value="">-- Pilih Jabatan --</option>
                                                <?php $query = "SELECT * FROM jabatan";
                                                $stmt = $conn->query($query);
                                                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?= $data['id']; ?>"><?= $data['nama_jabatan']; ?></option>
                                                <?php } ?>


                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-1" name="submit">Simpan</button>
                                        <a href="gaji.php" class="btn btn-secondary">Cancel</a>
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