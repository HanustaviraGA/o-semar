<?php 
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "osemar";

	
    //percobaan
	try{
		$koneksi = mysqli_connect($host, $user, $pass, $db);
 	} catch(PDOException $e){
		die("Koneksi gagal : ".$e->getMessage());
	}

	//kode awal
/*	if(!$koneksi) {
		die("Koneksi gagal : ".mysql_connect_error());
	}
*/
?>