<?php
session_start();
session_destroy();

$link = 'location: index.php';

header($link);
exit;
?>