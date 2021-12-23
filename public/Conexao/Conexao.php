<?php

require_once  __DIR__  . "/../../Credencias.php";



class Conexao extends Credencias
{

  public function conectar()
  {
    try {
      $conn = new PDO("mysql:host=localhost;dbname=banco", $this->getUsername(), $this->getPassword());
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
      echo "Connected successfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}
