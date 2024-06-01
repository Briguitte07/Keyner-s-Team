<?php

    class DatabasesConexion {

        private  $host ="srv863.hstgr.io";
        private   $password = "zD~>EilCGd1";
        private   $username = "u484426513_multimedios022";
        private   $db_name = "u484426513_multimedios022";

        public $conectors;

        public function obtenerConn(){

            $this->conectors = null;

            try {

                $this->conectors = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->usua, $this->pass);
                $this->conectors->exec("set names utf8");
                //es para indicarle al sistema que los caracteres son de 8 bits

            }catch(PDOException $e){
                    echo "Error: " . $e->getMessage();

            }

            return $this->conectors;
        }    
    }

?>