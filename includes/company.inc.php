<?php

    
    $adminName = 'Hygison';

    include 'autoload.inc.php';

    if(isset($_POST['action'])){

        $action = $_POST['action'];

        $company = new Company;
        $company->setAdminName($adminName);


        if($action === 'createCompany'){
            /**
             * Return True or the error
             */
            
            print_r($_POST);
            $companyName = $_POST['companyName'];
            $categoryArr = $_POST['categoryArr'];
            $oppositeCategoryArr = $_POST['oppositeCategoryArr'];
            

            $company->setCompanyName($companyName);
            $company->setCategoryArr($categoryArr);
            $company->setOppositeCategoryArr($oppositeCategoryArr);
            $response = $company->insertDbh();
            //echo $company->appendStatusModification('activate');
        }




        if($action ==='activateCompany'){

        }

        if($action ==='deactivateCompany'){

        }

        if($action ==='getCompany'){
            
            $row = $company->selectDbh();
            $select = '<select id="company-select">';

            foreach($row as $value){
                

                $category = '';
                foreach(json_decode($value["categoryJSON"],true) as $items){
                    $category .=$items.' | ';
                }
                $oppositecategory = '';
                foreach(json_decode($value["oppositeCategoryJSON"],true) as $items){
                    $oppositecategory .=$items.' | ';
                }
                
                $select .= '<option data-category="'.$category.'" data-oppositeCategory="'.$oppositecategory.'" >';
                $select .= $value['companyName'];
                $select .= '</option>';
            }
            $select .= '</select>';
            echo $select;
        }
   


        
    }



?>