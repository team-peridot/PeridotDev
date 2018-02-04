<?php

require_once '../services/ConnectDb.class.php';
include '../models/MapPin.class.php';
include 'queries.php';

Class Map
{
    private static $instance = null;
    private $conn;

    /**
     * Map constructor.
     */
    public function __construct()
    {
        echo "Map Constructor <br/>";

        try{
            $this->conn = ConnectDb::getInstance()->getConnection();
            echo "Map Conn: ";
            var_dump($this->conn);
        }
        catch(PDOException $e){
            echo $e->getMesage();
            die();
        }
    }

    public static function getInstance()
    {
        echo "Map Instance <br/>";

        if(!self::$instance)
        {
            self::$instance = new Map();
        }
        return self::$instance;
    }

    public function getAllTrackableObjectPins(){
        echo "Map getAllObjectPins <br/>";

        try{
            $trackableObjectPins = array();
            $qry = "SELECT * FROM(
                SELECT idTrackableObject, type, longitude, latitude, concat(firstName, ' ', middleName, ' ', lastName) as name, pinColor
                FROM Grave G 
                JOIN TrackableObject T on G.idGrave = T.idGrave
                JOIN Type TF on T.idType = TF.idType
                UNION 
                SELECT idTrackableObject, type, longitude, latitude, commonName as name, pinColor
                FROM Vegetation V
                JOIN TrackableObject T on V.idVegetation = T.idVegetation
                JOIN Type TF on T.idType = TF.idType
                Union
                SELECT idTrackableObject, type, longitude, latitude, name, pinColor
                FROM OtherObject O
                JOIN TrackableObject T on O.idOtherObject = T.idOtherObject
                JOIN Type TF on T.idType = TF.idType
                ) as MapPin";

            echo "Query: " . $qry;
            $stmt = $this->conn->prepare($qry);

            $stmt->execute();
            //$stmt->setFetchMode(PDO::FEtch_ob, "MapPin");

            while($result = $stmt->fetch()){
                $trackableObjectPins[] = $result;
            }
            return $trackableObjectPins;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            die();
        }
    } // end of get all TrackableObjectPins

}
?>