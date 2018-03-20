<?php

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

require_once '../services/ConnectDb.class.php';

/**
 * Class GraveData
 * Used for Grave CREATE, READ, UPDATE, DELETE QUERIES
 */
class GraveData {

    public function createGrave($firstName, $middleName, $lastName, $birth, $death, $description, $idHistoricFilter){
        try{
            $stmnt = ConnectDb::getInstance()->getConnection()->prepare("INSERT INTO Grave (firstName, middleName, lastName, birth, death, description, idHistoricFilter) VALUES (:firstName, :middleName, :lastName, :birth, :death, :description, :idHistoricFilter)");

            // Bind
            $stmnt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
            $stmnt->bindParam(':middleName', $middleName, PDO::PARAM_STR);
            $stmnt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmnt->bindParam(':birth', $birth, PDO::PARAM_STR);
            $stmnt->bindParam(':death', $death, PDO::PARAM_INT);
            $stmnt->bindParam(':description', $description, PDO::PARAM_INT);
            $stmnt->bindParam(':idHistoricFilter', $idHistoricFilter, PDO::PARAM_STR);
            $stmnt->execute();

            return ConnectDb::getInstance()->getConnection()->lastInsertId();

        }
        catch(PDOException $e){
            echo "Failed in create Grave <br/>";
            echo $e->getMessage();
            die();
        }
    }

    public function readAllGraves(){
        return ConnectDb::getInstance()->returnObject("", "SELECT idTrackableObject, longitude, latitude, T.imagePath, T.imageDescription, firstName, middleName, lastName, birth, death, G.description, HF.idHistoricFilter, HF.historicFilter, T.idType, TF.typeFilter, T.idGrave, T.scavengerHuntHint, T.idLocation
                                                                            FROM Grave G 
                                                                            JOIN TrackableObject T ON G.idGrave = T.idGrave 
                                                                            JOIN Type TF ON T.idType = TF.idType 
                                                                            LEFT OUTER JOIN HistoricFilter HF ON G.idHistoricFilter = HF.idHistoricFilter");
    }

    public function updateGrave(){

    }

    public function deleteGrave(){

    }

}