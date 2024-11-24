<?php
session_start();
session_unset();
session_destroy();

// Clear browser cache to prevent form data from being retained
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

header("Location: index.php");
exit();
?>
