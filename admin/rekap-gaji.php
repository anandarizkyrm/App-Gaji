<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");

$query = "SELECT tahun, SUM(GAPOK) as gapok,
SUM(tunjangan) as tunjangan,
SUM(uang_makan) as uang_makan
FROM penggajian 
GROUP BY tahun";


//query from db
$stmt = $conn->query($query);
$jumlah_gapok  = 0;
$jumlah_tunjangan = 0;
$jumlah_uang_makan = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Gaji | APPGAJI</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                            <h1>Data Gaji Pertahun Keseluruhan </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Gaji Pertahun</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="karyawan-tambah.php" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Tahun</th>
                                                <th>Gapok</th>
                                                <th>Tunjangan</th>
                                                <th>Uang Makan</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr>
                                                    <td><?= $no; ?></td>

                                                    <td>
                                                        <a href="rekap-gaji-bulan.php?tahun=<?php echo $row["tahun"]; ?>" class="btn btn-info btn-xs text-light"><i class="fa fa-eye"></i> Perbulan</a>
                                                    </td>
                                                    <td><?= $row["tahun"]; ?></td>
                                                    <td><?= 'Rp.',  number_format($row["gapok"], 0, ',', '.'); ?></td>
                                                    <td><?= 'Rp.',  number_format($row["tunjangan"], 0, ',', '.'); ?></td>
                                                    <td><?= 'Rp.',  number_format($row["uang_makan"], 0, ',', '.'); ?></td>

                                                </tr>
                                            <?php $no++;
                                                $jumlah_gapok += $row["gapok"];
                                                $jumlah_tunjangan += $row["tunjangan"];
                                                $jumlah_uang_makan += $row["uang_makan"];
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total : </th>
                                                <th></th>
                                                <th></th>
                                                <th><?= 'Rp.', number_format($jumlah_gapok, 0, ',', '.'); ?></th>
                                                <th><?= 'Rp.', number_format($jumlah_tunjangan, 0, ',', '.'); ?></th>
                                                <th><?= 'Rp.', number_format($jumlah_uang_makan, 0, ',', '.'); ?></th>

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
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
                "order": [
                    [1, "asc"]
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>