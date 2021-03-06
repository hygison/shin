<?php
    class Category extends Dbh{

        public $adminName;
        private $dbhTable = 'category';
        public $category;
        public $id ;

        private function getDate(){
            date_default_timezone_set("Asia/Tokyo");
            $now = date("Y-m-d H:i:s");
            return $now;
        }
        public function setID($id){
            $this->id=$id;
        }
        public function setCategory($category){
            $this->category = $category;
        }
        public function setAdminName(string $adminName){
            $this->adminName = $adminName;
        }
        public function getCategory(){
            return $this->category;
        }

        public function doesCategoryExist(){
            try{
                $query ="SELECT COUNT(*) FROM ".$this->dbhTable." WHERE category=?";
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([$this->category]);
                $numberOfRows = $stmt->fetchColumn();
                
            }catch(PDOException $e){
                //'Error'.$e->getMessage();
                $numberOfRows = 0;
            }
            return $numberOfRows;
        }


        public function insertDbh(){
            if(!$this->doesCategoryExist() && !empty(trim($this->category))){
                try{
                    $query = "INSERT INTO ".$this->dbhTable." SET 
                        category=?,
                        date=?
                    ";
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$this->category, $this->getDate()]);
                    return true;
                }catch(PDOException $e){
                    //return 'There was a error, please contact the Developer';
                    return $query.'Error'.$e->getMessage();
                } 
            }
        }

        public function updateDbh(){
            if(!empty(trim($this->id))){
                try{
                    $query = "UPDATE ".$this->dbhTable." SET category=? WHERE id=?";
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$this->category,$this->id]);
                    return true;
                }catch(PDOException $e){
                    //return 'There was a error, please contact the Developer';
                    return $query.'Error'.$e->getMessage();
                } 
            }
            
        }
        public function deleteDbh(){
            if(!empty(trim($this->id))){
                try{
                    $query = "DELETE FROM ".$this->dbhTable." WHERE id=?";
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$this->id]);
                    return true;
                }catch(PDOException $e){
                    //return 'There was a error, please contact the Developer';
                    return $query.'Error'.$e->getMessage();
                } 
            }
        }

        public function getDbhRows(){
            try{
                $query ="SELECT * FROM ".$this->dbhTable;
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([]);
                $row = $stmt->fetchAll();
                return $row;
                /*
                foreach($row as $key => $value){
                    echo $value['id'].'<br>';
                }*/
                
            }catch(PDOException $e){
                return 'Error'.$e->getMessage();
                
            }
        }

    }


?>