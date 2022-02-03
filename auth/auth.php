<?php
session_start();
if(!isset($_SESSION["user"])) {header("Location: ../index.php"); exit;}
if($_SESSION["user"]["peran"] == "USER") {
  header("Location: ../user/index.php");
}
