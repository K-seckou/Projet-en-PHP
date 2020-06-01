<?php 

session_start();
session_unset();
session_destroy();

setcookie('login', '', time() - 367*24*3600, '/', null, false, true);
setcookie('Pseudo', '', time() - 367*24*3600, '/', null, false, true);

header('location: connection.php?deco=1');

?> 