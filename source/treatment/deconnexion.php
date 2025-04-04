<?php
session_start();
session_destroy();
header('Location: ../../views/acceuil.php');
exit();