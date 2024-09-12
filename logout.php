<?php
session_start();
unset($_SESSION['jk_conuser']);
unset($_SESSION['jk_con']);

session_unset();
session_destroy();

header("Location: login.php");
// echo "<script>window.location='login.php';</script>"; 
exit;
?>
 