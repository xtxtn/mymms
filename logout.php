<?php
require_once('auth.php');
session_start();
session_destroy();
header("Location: login.php");
exit;
?>