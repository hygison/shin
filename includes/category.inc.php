<?php 
    include 'autoload.inc.php';
    include 'functions.inc.php';

    if(session_id() == ''){
        session_start();
    }
  
    if(isset($_POST['action'])){

        $action = $_POST['action'];

        if($action === 'create-category'){
            
            $categoryArr = $_POST['category'];
            foreach($categoryArr as $value){
                echo $value;
                echo '<br>';
                $category = new Category;
                $category->setCategory($value);
                $category->insertDbh();
                unset($category);
            }
        }


        if($action ==='delete-category'){
            $id = $_POST['id'];
            $category = new Category;
            $category->setID($id);
            $category->deleteDbh();
            unset($category);
        }
        if($action === 'load-category-selector'){
            $category = new Category;
            $rows = $category->getDbhRows();
            $select = '<select>';

            foreach($rows as $row){
                $value = $row['category'];
                $select .= '<option value="'.$value.'">'.$value.'</option>';
            
            }
            $select .= '</select>';
            echo $select;
        }

        if($action === 'load-category'){
            $category = new Category;
            $rows = $category->getDbhRows();
            $returnContent = '';
            
            $rand = rand();
            
            foreach($rows as $row){
                
                $value = $row['category'];
                $id = trim($row['id']);
                $noSpaceValue = trim($value);
                $noSpaceValue = str_replace(' ','',$noSpaceValue);// Normal space
                $noSpaceValue = str_replace('   ','',$noSpaceValue);// tab space
                $noSpaceValue = str_replace('　','',$noSpaceValue);// japanese space

                if($_POST['subAction'] === 'load-checkbox'){
                    $returnContent .= '<input class="checkbox-category-opposit-category" data-dbh_id="'.$id.'" checkbox-'.$id.'-'.$rand.'" type="checkbox"  name="checkbox-'.$id.'-'.$rand.'" value="'.$value.'" ';
                    $returnContent .= '<label for="checkbox-'.$id.'-'.$rand.'"> '.$value.'</label>';
                    $returnContent .='<br>';
                }
           
                
            }
            
            echo $returnContent;
        }



    }

?>