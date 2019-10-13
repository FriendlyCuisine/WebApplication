<?php
include 'configuration.php';

$sql = $conn->prepare('SELECT COUNT(*) FROM user');
$sql->execute();
$count = $sql->fetchColumn();

echo $count+1;
?>
