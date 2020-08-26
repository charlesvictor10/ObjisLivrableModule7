<?php
     //les parametres utlises
     $host = 'localhost';
     $dbname = 'plateformeMusicale';
     $utilisateur = 'root';
     $password = '<>@lfred26';
     $port =  '3306';

     //connexion a la base de donnees mysql avec pdo
     try {
     	$pdo = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname,$utilisateur,$password);
     	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $pdo;
     	
     } catch (Exception $e) {
     	die($e->getMessage());
     	
     }
?>