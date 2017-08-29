<?php
	require_once 'mysql_login.php';

    // Parametros pasados
    $correo=$_REQUEST['username'];
    $passwd=$_REQUEST['passwd'];
    
    // Parámetros base de datos
    $db = new PDO( MYSQL.':host='.HOSTNAME.';dbname='.DATABASE,
    				USERNAME, 
    				PASSWORD );

    // PreparedStatement realizando select de username
    $stmt=$db->prepare('SELECT password FROM user where username=?');
    $stmt->execute(array($correo));
    $dbHash = $stmt->fetchcolumn();

    // Comprobación y validación de hash.
    if (crypt($passwd, $dbHash) == $dbHash) {
    	
    	$stmt=$db->prepare('SELECT id FROM user where username=?');
    	$stmt->execute(array($correo));
    	$id_user = $stmt->fetchcolumn();
    	echo $id_user;

	} else
    	die('False');    
    
?>
