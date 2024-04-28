<?php

namespace SW\classes;

class Aplicacion{

	private static $instance;
    private $bdDatosConexion;
	private $inicializada = false;
	private $conn;
	
    private function __construct(){}

	public static function getInstance() {

		if (!self::$instance instanceof self) {
			self::$instance = new static();
		}
		return self::$instance;
    }
	
	public function init($bdDatosConexion) {

        if(!$this->inicializada) {
    	    $this->bdDatosConexion = $bdDatosConexion;
    		$this->inicializada = true;
        }
	}

	public function shutdown() {

	    $this->compruebaInstanciaInicializada();

	    if($this->conn !== null && ! $this->conn->connect_errno) {
	        $this->conn->close();
	    }
	}
	
	private function compruebaInstanciaInicializada() {

	    if(!$this->inicializada) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	public function getConexionBd() {

	    $this->compruebaInstanciaInicializada();

		if(!$this->conn){

			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd = $this->bdDatosConexion['database']; 

			$conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
			if($conn->connect_errno) {
				echo "Error de conexión a la BD ({$conn->connect_errno}):  {$conn->connect_error}";
				exit();
			}
			if(!$conn->set_charset("utf8mb4")) {
				echo "Error al configurar la BD ({$conn->errno}):  {$conn->error}";
				exit();
			}
			$this->conn = $conn;
		}

		return $this->conn;
	}
}