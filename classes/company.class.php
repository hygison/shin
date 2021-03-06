<?php
    /**
     * @author Hygison Brandao hygisonbrandao@gmail.com
     * Company class
     * The company will be stored on the dbh
     * Each company will have some category and some opposite category
     * The opposite category is the content where they would not match with comercial type
     * 
     * Table :  companies
     * companyName
     * categoryJSON
     * oppositeCategoryJSON
     * modificationJSON
     * date
     * =======================
     * 
     * modificationArr = array(
     *      'created' => array(
     *          'user'=> adminName
     *          'date'=> DATE CREATED
     *      ),
     *      'modification'=>array(
     *          'add'=>array(
     *              0 => array(
     *                  'user' =>adminName,
     *                  'column'=>'categoryJSON',
     *                  'add' => array(),
     *                  'date'=> DATE
     *              ),
     *          ),
     *          'remove'=>array(
     *              0 => array(
     *                  'user' =>adminName,
     *                  'column'=>'categoryJSON',
     *                  'remove' => array(),
     *                  'date'=> DATE
     *              ),
     *          ),
     *          'status'=>array(
     *              '0'=> array(
     *                  'user'=>adminName,
     *                  'action'=>'activate or deactivate',
     *                  'date'=>DATE,
     *              ),
     *          )
     *      ),
     * );
     */
    class Company extends Dbh{

        public $companyName;
        public $categoryArr;
        public $oppositeCategoryArr;
        public $adminName ; //Admin name

        private $dbhTable = 'companies';

        public function setAdminName(string $adminName){
            $this->adminName = $adminName;
        }
        public function setCompanyName(string $companyName){
            $this->companyName = $companyName;
        }
        public function setCategoryArr(array $categoryArr){
            $this->categoryArr = $categoryArr;
        }
        public function setOppositeCategoryArr(array $oppositeCategoryArr){
            $this->oppositeCategoryArr = $oppositeCategoryArr;
        }

        public function getCompanyName(){
            return $this->companyName;
        }
        public function getCategoryArr(){
            return $this->categoryArr;
        }
        public function getOppositeCategoryArr(){
            return $this->oppositeCategoryArr;
        }


        private function getDate(){
            date_default_timezone_set("Asia/Tokyo");
            $now = date("Y-m-d H:i:s");
            return $now;
        }

        private function doesCompanyExist(){
            /**
             * Check if company exist or not
             */
            $i = 0;
            if(!empty($this->companyName)){
                $notEmpty = true;
            }else{
                $notEmpty = false;
            }
            try{
                $query ="SELECT COUNT(*) FROM ".$this->dbhTable." WHERE companyName=?";
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([$this->companyName]);
                $numberOfRows = $stmt->fetchColumn();
            }catch(PDOException $e){
                //'Error'.$e->getMessage();
                $numberOfRows = 1;
            }
            if($notEmpty == true && $numberOfRows <1){
                return false;
            }else{
                return true;
            } 
        }

        





        /**
         * Create the company record in our database
         */
        public function insertDbh(){

            if(!$this->doesCompanyExist()){

                $modificationArr = array(
                    'created'=> array(
                        'user'=>$this->adminName,
                        'date'=>$this->getDate(),
                    ), 
                    'modification'=>array(
                        'add'=>array(),
                        'remove'=>array(),
                        'status'=>array(),
                    ),
                );
                $modificationJSON = json_encode($modificationArr ,JSON_UNESCAPED_UNICODE);
                $categoryJSON = json_encode($this->categoryArr , JSON_UNESCAPED_UNICODE);
                $oppositeCategoryJSON = json_encode($this->oppositeCategoryArr ,JSON_UNESCAPED_UNICODE);
                try{
                    $query = "INSERT INTO ".$this->dbhTable." SET 
                        companyName=?, 
                        categoryJSON=?, 
                        oppositeCategoryJSON=?,
                        modificationJSON=?,
                        date=?,
                        isActive=?
                    ";
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$this->companyName, $categoryJSON, $oppositeCategoryJSON, $modificationJSON, $this->getDate(), true]);
                    return true;
                }catch(PDOException $e){
                    return 'There was a error, please contact the Developer';
                    //$query.'Error'.$e->getMessage();
                } 
            }else{
                return 'The company already Exist';
            }
        }



        public function activateDeactivate(string $action){
            if($action === 'activate' || $action ==='deactivate'){

            }
            /*
            try{
                $query = "UPDATE ".$this->dbhTable." SET modificationJSON=?, isActive=? WHERE companyName=?";
                
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([]);
                
                echo '<p style="background:green; color:white; padding: 5px 5px;">DATABASE UPDATED'.$getTrackCode.'</p>';
                echo $query;
            }catch(PDOException $e){
                echo $query.'Error '.$e->getMessage();
            }*/
        }





        public function getDbhModificationJSON(){
            $modificationJSON = null;
            try{
                $query ="SELECT * FROM ".$this->dbhTable." WHERE companyName=?";
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([$this->companyName]);
                $row = $stmt->fetchAll();
                foreach($row as $key => $value){
                    $modificationJSON = $value['modificationJSON'];
                }
            }catch(PDOException $e){
                //'Error'.$e->getMessage();
                $numberOfRows = 1;
            }
            return $modificationJSON;
        }

        public function appendStatusModification(string $action){
            $modificationJSON = $this->getDbhModificationJSON();
            $modificationArr = json_decode($modificationJSON, true);
            $inactiveArr = array(
                'user'=>$this->adminName,
                'action'=>$action,
                'date'=>$this->getDate()
            );
            $modificationArr['modification']['status'][] = $inactiveArr;
            $updateModificationJSON = json_encode($modificationArr);
            return $updateModificationJSON;
        }







        public function selectDbhWhere(string $columnName, string $colunmValue){
            /**
             * columnName must be:
             * categoryJSON
             * or
             * oppositeCategoryJSON
             */
            $rowArr = array();
            try{
                $query ="SELECT * FROM ".$this->dbhTable." WHERE ?=?";
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([$columnName,$colunmValue]);
                $row = $stmt->fetchAll();
                
                foreach($row as $key => $value){
                    if($value['isActive']){
                        $rowArr[] = $value;
                    }
                }
                return $rowArr;

            }catch(PDOException $e){
                return $rowArr;
                //return $query.'Error'.$e->getMessage();
            } 
        }   
        
        public function selectDbh(){

            $rowArr = array();
            try{
                $query ="SELECT * FROM ".$this->dbhTable;
                $stmt = $this->connect()->prepare($query);
                $stmt->execute([]);
                $row = $stmt->fetchAll();
                
                foreach($row as $key => $value){
                    if($value['isActive']){
                        $rowArr[] = $value;
                    }
                }
                return $rowArr;

            }catch(PDOException $e){
                return $rowArr;
                //return $query.'Error'.$e->getMessage();
            } 
        }   



        

  


    }

?>