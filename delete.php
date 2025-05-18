<?php
require_once 'classes/Shoe.php';

if (isset($_GET['id'])) {
    $shoe = new Shoe();
    $id = (int)$_GET['id'];
    $shoe->delete($id);
}

header("Location: index.php");
exit;
