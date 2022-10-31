<?php
session_start(); //starta a session
session_destroy();
header('Location: index.php');
?>