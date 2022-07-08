<?php
class Conexion extends PDO
{
	private $hostBd = 'localhost';
	private $nombreBd = 'bd_tienda_sublimado_v3';
	private $usuarioBd = 'root';
	private $passwordBase = '';
	
	
	public function __construct(){
			try{
				parent::__construct('mysql:host=' . $this->hostBd . ';dbname='. $this->nombreBd . ';charset=utf8', $this->usuarioBd, $this->passwordBase, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) );
				// echo 'Éxito en CONEXIÓN PDO';
			}catch(PDOException $e){
				echo 'Error: '.$e->getMessage();
				exit;
			}
	}
	
}
?>