<?php

define('MSG_LOGOUT_SUCCESS', 'Has cerrado sesión exitosamente.');

// logout.php
require_once 'config/constants.php';

session_destroy();
$_SESSION['success'] = MSG_LOGOUT_SUCCESS;
header('Location: login.php');
exit();
?>