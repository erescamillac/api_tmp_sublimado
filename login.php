<?php 
include 'conexion.php';
$pdo = new Conexion();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	
	if( isset($_GET['email']) && isset($_GET['contrasenia']) ){
        /* --INI: LÓGICA de php de Login :: */
        $email = $_GET["email"];
        $contrasenia = $_GET["contrasenia"];

        // REF :: https://www.youtube.com/watch?v=wODW8RLBPt0
        
        // $sqlQuery = "SELECT * FROM clientes WHERE correo_electronico='".$email_cliente."' ";
        // utilizar PDO ::
        $stmt = $pdo->prepare( "SELECT * FROM usuarios WHERE correo=:correo AND contrasena=:contrasena" );
		$stmt->bindValue(':correo', $email);
        $stmt->bindValue(':contrasena', $contrasenia);

        /*
        $pdoQuery = "SELECT";

        # ->query() :: ->execute()
        $pdoQuery_run = $pdocon->query($pdoQuery);

        $numFilas = $pdoQuery_run->rowCount();
        */

		$stmt->execute();
        $numFilas = $stmt->rowCount();

        // echo "numFilas";
        // echo "<br>";
        // var_dump( $numFilas );
        // echo "<br>";
		
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
		// header("HTTP/1.1 200 OK");
		// echo json_encode( $sql->fetchAll() );

        // $sqlQuery = "SELECT * FROM clientes WHERE correo_electronico='".$email_cliente."' and contrasenia='".$loginPassword."' ";

        // 1. Validar si el correo se encuentra DADO DE ALTA en el sistema (Clientes)
        // $resultSet = $stmt->fetchAll();
        // var_dump( $resultSet );
        // echo "<br>";
        // echo json_encode( $resultSet );

        // $numFilas = $resultSet->rowCount();
        // $numFilas = $pdoQueryRun->rowCount(); 

        // echo "<br>";
        // echo $numFilas;

        /*
        $result = array();

        $entityarray['nodes'][] = array( 'id'    => 'example@email.com'
                                    , 'group' => 1
                                    );

        $temp["source"]    = "example@email.com";
        $temp["target"]    = "Exact ID 9057673495b451897d14f4b55836d35e";
        $temp["value"]     =1;

        echo json_encode($result);
        */
        $resultado = array();

        
        if( $numFilas >= 1 ){
            // el correo está registrado en el Sistema, se procede a validar MATCH user && password...
            // LOGIN : Correcto - Dejar pasar...
            $resultado["codigoAcceso"] = 100; // OK : dejar pasar
           
            // -- Agregar propiedades ::
            // echo json_encode( $stmt->fetchAll() );

            $row = $stmt->fetch();

            $resultado["correo"] = $row["correo"];
            $resultado["contrasena"] = $row["contrasena"];
            $resultado["rol"] = $row["rol"];
            $resultado["nombre"] = $row["nombre"];
            $resultado["apellido_pat"] = $row["apellido_pat"];
            $resultado["apellido_mat"] = $row["apellido_mat"]; 

            // $row = mysqli_fetch_array( $resultSet );
            // $row = $stmt->fetch( PDO::FETCH_ASSOC );
            /*
            echo "<br>--Fila";
            var_dump( $row );
            echo "<br>++Fila";
            */
            
            // $row = $stmt->fetch(PDO::FETCH_ASSOC)

            // $_SESSION['nombreCompletoUsuario'] = $row['nombre']." ".$row['apellido_pat']." ".$row['apellido_mat'];
            // echo "NOMBRE : ".$row['nombre'];
            // echo " APELLIDO PAT : ".$row['apellido_pat'];
            // $_SESSION['lugar_procedencia_CLIENTE'] = $row['lugar_procedencia'];
            // $_SESSION['id_INE_CLIENTE'] = $row['id_INE'];
            // $_SESSION['correo_Usuario'] = $row['correo'];
            // $_SESSION['rol_Usuario'] = $row['rol'];
            
            // header("location:menuPrincipalAdmin.php");
            // header("location:menuPrincipalAdmin.php");
           
        }else{
            // el correo NO ESTÁ REGISTRADO en el Sistema...
            // err: msg
            // login incorrecto : NO DEJAR PASAR...
            $resultado["codigoAcceso"] = 300; // NOT OK : NO dejar pasar

            // header("location:../../index.php");
        }
        /* ++FIN:  */
        /*
        $sql = $pdo->prepare( "SELECT * FROM agenda WHERE id=:id" );
		$sql->bindValue(':id', $_GET['id']);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
        */
		
		header("HTTP/1.1 200 OK");
		// echo json_encode( $stmt->fetchAll() );
        echo json_encode( $resultado );
		exit;
	}
    /*
    else{
		$sql = $pdo->prepare("SELECT * FROM agenda");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 OK");
		echo json_encode($sql->fetchAll());
		exit;
	}
    */
    	
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