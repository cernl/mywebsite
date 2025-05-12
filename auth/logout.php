<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// Use absolute path with correct header location
header("Location: login.php");
exit;
