<?php

	require 'Plato.php';
	
    $name = $_POST&['name']; //nombre
    $image = $_POST['image']; // string de imagen
 
    //decode 
    $decodedImage = base64_decode($image);
 	
 	$id = Plato::getLast();

 	$nombre = $id[0]["MAX(id)"];

    //guardar imágen
    file_put_contents($nombre.".jpeg", $decodedImage);
?>