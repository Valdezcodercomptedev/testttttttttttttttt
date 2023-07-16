<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use Core\Database\ConnectionManager;    

$connectionManager = new ConnectionManager();

$id = (int)$_GET['id'];

$sql = "UPDATE articles SET deleted = ? WHERE id = ?";

$query = $connectionManager->getConnection()->prepare($sql);

$query->execute([1 , $id]);

header('Location: ' . VIEWS . 'Services/view.php?id=' . $_GET["id"] );
