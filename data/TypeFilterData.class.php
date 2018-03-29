<?php

class TypeFilterData {

    public function createTypeFilter($typeFilter, $description, $pinDesign, $buttonColor){
        try{
            $stmt = ConnectDb::getInstance()->getConnection()->prepare("INSERT INTO Type
                                                                                  (typeFilter, description, pinDesign, buttonColor)
                                                                                  VALUES
                                                                                  (:typeFilter, :description, :pinDesign, :buttonColor)");

            $stmt->bindParam(':typeFilter', $typeFilter, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':pinDesign', $pinDesign, PDO::PARAM_STR);
            $stmt->bindParam(':buttonColor', $buttonColor, PDO::PARAM_STR);
            $stmt->execute();

        }
        catch(PDOException $e){
            echo 'Failed to create Type Filter';
            echo $e->getMessage();
            die();
        }

    }

    public function readAllTypeFilters(){
        return ConnectDb::getInstance()->returnObject("TypeFilter.class", "SELECT * FROM Type;
        ) as typeFilters");
    }

    public function updateTypeFilter($idType, $typeFilter, $description, $buttonColor){
        try{
            $stmt = ConnectDb::getInstance()->getConnection()->prepare("UPDATE Type
                                                                                  SET typeFilter = :typeFilter,
                                                                                      description = :description,
                                                                                      buttonColor = :buttonColor
                                                                                      WHERE idType = :idType");

            $stmt->bindParam(':typeFilter', $typeFilter, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':buttonColor', $buttonColor, PDO::PARAM_STR);
            $stmt->bindParam(':idType', $idType, PDO::PARAM_INT);

            $stmt->execute();
        }
        catch(PDOException $e){
            echo "failed to update Type Filter";
        }
    }

    public function deleteTypeFilter($idType){

    }
}

?>