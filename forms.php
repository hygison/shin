<?php include 'includes/header.php';?>

    <div class="container">
        <div class="show-content"></div>
        <hr>
    </div>



    <div class="container">
        <h1>Create Sheet</h1>
        <div class="row">

        <div class="col-md-6">
            <h3>Option 1: By inputs</h3>
            
            <label>Select The company</label>
            <span id="company-select"></span>
            <label>Categories : <span id="company-category"></span><button class="btn btn-danger">Change</button></label>
            <label>Opposite Categories : <span id="opposite-company-category"></span><button class="btn btn-danger">Change</button></label>
            <br>
            <label>Dates:</label>
            <p class="text-danger">If ending or starting dates are not selected it will consider the max</p>
            <div class="row">
                <div class="col-md-6">
                    <label>From:</label>
                    <input class="form-control" placeholder="Select the Initial date"> 
                </div>
                <div class="col-md-6">
                    <label>Until:</label>
                    <input class="form-control" placeholder="Select the Deadline date"> 
                </div>
            </div>
            <label>Age/Gender:</label>
            <p class="text-danger">If age or gender not selected it will consider max</p>
            <div class="row">
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">世帯</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">個人全体</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男女 4～12才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男女 13～19才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 20～34才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 35～49才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 50才以上</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 20～34才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 35～49才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 50才以上</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">世帯主</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">主婦</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 20～29才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 30～39才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 40～49才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">男 50～59才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 20～29才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 30～39才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 40～49才</label>
                </div>
                <div class="col-md-6">
                    <input class="checkbox-category-opposit-category" type="checkbox">
                    <label for="">女 50～59才</label>
                </div>
            </div>
            <br>
            <button class="btn btn-primary">View Sheet Before Create</button>
            <button class="btn btn-primary">Create New sheet</button>
        </div>

        <div class="col-md-6">
            <h3>Option 2: By textinput(This is email reading)</h3>
            <textarea class="form-control" placeholder="Type the text for selecting the dates for the sheet"> 
                
            </textarea>
        </div>
        </div>

        <hr>

        <h1>Company Profile</h1>
        <?php
            $company = new Company;
            $company->setAdminName($_SESSION['adminName']);
            $rows = $company->selectDbh();

        ?>
        <table class="table-bordered text-center">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Category <i class="fa fa-check text-success"></i></th>
                    <th>Category <i class="fa fa-times text-danger"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            
        <?php
            foreach($rows as $row){
                $id = $row['id'];
                $companyName = $row['companyName'];
                $categoryJSON = $row['categoryJSON'];
                $oppositeCategoryJSON = $row['oppositeCategoryJSON'];
                $modification = $row['modificationJSON'];
                $isActive = $row['isActive'];

                $categoryPrint = '';
                $categoryArr = json_decode($categoryJSON,true);
                foreach($categoryArr as $value){
                    $categoryPrint .= $value.'<br>';
                }
                $oppositeCategoryPrint = '';
                $oppositeCategoryArr = json_decode($oppositeCategoryJSON,true);
                foreach($oppositeCategoryArr as $value){
                    $oppositeCategoryPrint .= $value.'<br>';
                }
                ?>
                    
                
                    <tr>
                        <td><?php echo $companyName;?></td>
                        <td><?php echo $categoryPrint;?></td>
                        <td><?php echo $oppositeCategoryPrint;?></td>
                  
                        <td>
                        <i class="fa fa-eye" aria-hidden="true"></i><br>
                        <i class="fa fa-cog" aria-hidden="true"></i><br>
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </td>

                    </tr>
                    
                <?php
            }
        
        ?>
        </table>














        <hr>
        <h1>Create company</h1>
        <h6>Company Name</h6>
        <input class="form-control" id="company-name">
        <br>
        <div class="row">
            <div class="col-lg-6" style="background: #e4f5d4;">
                <h6>Company Category</h6>
                <div id="create-company-select-category"></div>
            </div>
            <div class="col-lg-6" style="background: #f1d4d4;">
                <h6>Remove Category</h6>
                <div id="create-company-select-opposite-category"></div>
            </div>
        </div>
        <br>
        
        <button class="btn btn-primary" id="submit-company">Create Company</button>
        

        <hr>













        <h1>Create Categories</h1>
        <h6>Category</h6>

        <textarea class="form-control" id="create-category-input" placeholder="Jump Line for new category"></textarea>
        
        <br>
        <button class="btn btn-primary" id="submit-category">Submit</button>


        <hr>

        <h1>Category Control</h1>
        <div id="edit-category-area">
            

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Created Date</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                $category = new Category;
                $rows = $category->getDbhRows();
                foreach($rows as $row){
                    $value = $row['category'];
                    $date = $row['date'];
                    $id = trim($row['id']);
                    ?> 
                        <tr>
                            <td><i class="fa fa-pencil edit-category cursor-pointer" data-id="<?php echo $id;?>" data-category="<?php echo $value;?>"></i> <span id="category-show-<?php echo $id;?>"><?php echo $value;?> </span></td>
                            <td class="text-center"><?php echo $date;?></td>
                            <td class="cursor-pointer text-center delete-category-open-modal" data-id="<?php echo $id;?>" data-category="<?php echo $value;?>"><i class="fa fa-trash-o"></i></td>
                        </tr>

                    <?php
                }
                unset($category);

            ?>
                </tbody>
            </table>
        </div>


    </div>
<?php include 'includes/sidebar.php';?>
<?php include 'includes/footer.php';?>

