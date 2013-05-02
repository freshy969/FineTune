<?php
$id = $_GET['id'];
$stream = file_get_contents('https://api.soundcloud.com/i1/tracks/'.$id.'/streams?client_id=b45b1aa10f1ac2941910a7f0d10f8e28');
$json = json_decode($stream,true);
header('Content-Type: application/json; charset=UTF-8', true);
echo json_encode($json['http_mp3_128_url']);
?>