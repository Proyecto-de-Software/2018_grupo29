<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PDORepository
 *
 * @author fede
 */
abstract class PDORepository {
    
    const USERNAME = "grupo29"; //grupo29
    const PASSWORD = "ZWQwYzk5YzFhZTli"; //ZWQwYzk5YzFhZTli
	const HOST ="localhost";
	const DB = "grupo29";
    
    
    private function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }
    
    protected function queryList($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll();
    }

    protected function queryDevuelveId($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        return $connection->lastInsertId();
    }

    protected function queryObject($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
    }
    
}
