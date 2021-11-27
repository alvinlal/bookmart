<?php

include '../db/connection.php';
include '../middlewares/isAuthenticated.php';

$id = isset($_GET['id']) ? $_GET['id'] : -1;

query("DELETE FROM tbl_Review WHERE Review_id=? AND Username=?", [$id, $_SESSION['username']]);

header("Location:/bookmart/item.php?id={$_GET['redirectid']}");