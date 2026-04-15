<?php
session_start();
session_unset();
session_destroy();

// Redirige al login
header("Location: login.php");
exit();
?>
