<?php
require_once("../auth/auth.php");
require_once("../config/koneksi.php");


$id = $_GET["id"];
$query = "DELETE FROM bagian WHERE id = :id ";
$oldstmt = $conn->prepare($query);

$deleted = $oldstmt->execute(['id' => $id]);
if($deleted){
  echo "<script type='text/javascript'>
          alert('Data berhasil dihapus')
          document.location.href='bagian.php'
        </script>";
}else{
  echo "<script type='text/javascript'>
         alert('Data Gagal dihapus')
         document.location.href='bagian.php'
         </script>";
}

?>
