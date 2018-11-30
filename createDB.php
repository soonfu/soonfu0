<?php
class database{
	function __construct(){
		$this->pdo=new PDO("mysql:host=localhost","root","");
		$this->pdo->exec("create database if not exists airPort");
		$this->pdo->exec("use airPort");
		$this->pdo->exec("create table if not exists users(email varchar(50) not null primary key ,firstname varchar(50),lastname varchar(50),pass varchar(10));");
		$this->pdo->exec("create table if not exists palnes(id int not null primary key ,name varchar(50),company varchar(50),start varchar(50),end varchar(50),start_date date);");
		$this->pdo->exec("create table if not exists reserved(id_plane int,email varchar(50))");
	
	}
	function getRows($q,$p=array()){
		$res=$this->pdo->prepare($q);
		$res->execute($p);
		return $res->fetchAll();
	}
	function Execute($q){
		$this->pdo->exec($q);
	}
	
}
$db=new database();
//$db->Execute(file_get_contents('world.sql'));
?>