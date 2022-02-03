<?php

session_start();
date_default_timezone_set('Asia/Singapore');

if (isset($_SESSION["login"])) header("location:admin/index.php");


require_once('koneksi.php');



if(isset($_POST["login"])){

  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $login_terakhir = date("Y-m-d H:i:s");
//query ke db
   $result = "SELECT * FROM pengguna WHERE username=:username";
   $stmt = $conn->prepare($result);

   // bind parameter ke query
   $params = array(":username" => $username);
//
   $stmt->execute($params);
//

   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // jika user terdaftar
   if($user){
       // verifikasi password
       if(password_verify($password, $user["password"])){
           // buat Session
           session_start();
           $_SESSION["user"] = $user;

           if($user["peran"] == "ADMIN"){
             //update data login terakhir pada database
             $update = $conn->prepare("UPDATE pengguna SET login_terakhir $login_terakhir WHERE username = '$username'");
             header('Location: admin/index.php');
           }else if($user["peran"] == "USER"){
              $update = $conn->prepare("UPDATE pengguna SET login_terakhir $login_terakhir WHERE username = '$username'");
              header('Location: user/index.php');
           }
           exit;
       }
   }
   $error = true;


}

?>
