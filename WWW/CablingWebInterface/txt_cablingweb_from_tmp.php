<?php
$file = $_GET['file'];

$pname = $file;
$f=fopen($file,"r");
$size = filesize($file);
$data = fread($f,$size);
header("Content-type: text/plain");
header("Content-length: $size");
header("Content-Disposition: inline; filename=$pname");
header("Content-Description: PHP Generated Data");
echo $data;
?>