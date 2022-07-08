<?php 
include 'conexion.php';
$pdo = new Conexion();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	
	if( isset($_GET['id']) ){
		$sql = $pdo->prepare( "SELECT * FROM agenda WHERE id=:id" );
		$sql->bindValue(':id', $_GET['id']);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 OK");
		echo json_encode( $sql->fetchAll() );
		exit;
	}else{
		$sql = $pdo->prepare("SELECT * FROM agenda");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 OK");
		echo json_encode($sql->fetchAll());
		exit;
	}
	
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$stmt= $pdo->prepare("INSERT INTO agenda (id, nombre, telefono, correo_electronico) VALUES (:id, :nombre, :telefono, :correo)");
	
	$stmt->bindValue(':id', $_POST['id']);
	$stmt->bindValue(':nombre', $_POST['nombre']);
	$stmt->bindValue(':telefono', $_POST['telefono']);
	$stmt->bindValue(':correo', $_POST['correo']);

	$stmt->execute();
	$idPost = $pdo->lastInsertId();
	
	if($idPost){
		header("HTTP/1.1 200 OK");
		// retornar 1 :: como OK de Inserción
		echo json_encode($idPost);
		exit;
	}
	
}

if($_SERVER['REQUEST_METHOD'] == 'PUT'){
	$sql = "UPDATE agenda SET nombre=:nombre, correo_electronico=:correo, telefono=:telefono WHERE id=:id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', $_GET['id']);
	$stmt->bindValue(':nombre', $_GET['nombre']);
	$stmt->bindValue(':telefono', $_GET['telefono']);
	$stmt->bindValue(':correo', $_GET['correo']);
	$stmt->execute();
	header("HTTP/1.1 200 OK");
	exit;
}


if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
	$sql = "DELETE FROM agenda WHERE id=:id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":id", $_GET['id']);
	$stmt->execute();
	header("HTTP/1.1 200 OK");
	exit;
}
?>