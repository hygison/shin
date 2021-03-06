$(document).ready(function(){


    function modalLoadingStart(){
        $("#modal .modal-title").html('Sending...');
        $("#modal .modal-body").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
        $("#modal").modal('show');
    }

    function modalLoadingEnd(){
        $('#modal').modal('hide');
    }
    function removeItemArr(arr, value) {
        var b = '';
        for (b in arr) {
            if (arr[b] === value) {
            arr.splice(b, 1);
            break;
            }
        }
        return arr;
    };
    $(document).on('click','.delete-category-open-modal',function(){
        let id = $(this).attr("data-id");
        let category = $(this).attr("data-category");
        let content = '<div class="delete-modal-body"><p class="text-center">Are you sure you want to delete the <span class="span-color">'+category+'</span>?</p>';
       
        content += '<button type="button" class="btn btn-danger delete-category-action" data-id="'+id+'">Delete '+category+'</button></div>'

        $("#modal .modal-title").html('Delete Category');
        $("#modal .modal-body").html(content);
        
        $("#modal").modal('show');
    });


    $(document).on('click','.delete-category-action',function(){
        let action = 'delete-category';
        let id = $(this).attr("data-id");
        $.ajax({
            url: 'includes/category.inc.php',
            method: 'POST',
            data:{
                action:action,
                id:id
            },
            success:function(data){
                $(".show-content").html(data);
                location.reload();
            }
        });
    });
    $(document).on('click','.edit-category',function(){
        let id = $(this).attr("data-id");
        let category = $(this).attr("data-category");
        let htmlID = 'category-show-'+id;
        //Bring from BEO - edit stuff


    });


    $(document).on('change','.checkbox-category-opposit-category',function(){
        let myCategory = $(this).prop("name");
        let myDataID = parseInt($(this).attr("data-dbh_id"))
        let myValue = $(this).val();
        let myParentID = $(this).parent().attr('id');
        //create-company-select-category
        //create-company-select-opposite-category
        
        if($(this).is(":checked",true)){
            $(".show-content").html(myValue);
            /**
             * There is category and Opposite category. They cannot have the same category and opposite category
             * So we remove such options with the code below.
             */
            $('[data-dbh_id="'+myDataID+'"]').each(function(){
                if($(this).prop("name") != myCategory){
                    if($(this).is(":checked", true)){
                        $(this).prop('checked', false);
                    }
                }
            });
            
            
        }else{
            $(".show-content").html("");
           
        }
    });


    $(document).on('click','#submit-company',function(){
        
        let action = 'createCompany';
        let companyName = $("#company-name").val();
        let categoryArr = [];
        let oppositeCategoryArr = [];
        
        let category = $("#create-company-select-category");
        let oppositeCategory = $("#create-company-select-opposite-category");

        category.find("input").each(function(){
            //var id = parseInt($(this).attr("data-dbh_id"));
            var id = ($(this).val());
            if($(this).is(":checked",true)){
                categoryArr.push(id);
            }else{
                categoryArr = removeItemArr(categoryArr, id);
            }
        });
        oppositeCategory.find("input").each(function(){
            //var id = parseInt($(this).attr("data-dbh_id"));
            var id = ($(this).val());

            if($(this).is(":checked",true)){
                oppositeCategoryArr.push(id);
            }else{
                oppositeCategoryArr = removeItemArr(oppositeCategoryArr, id);
            }
        });
        console.log(categoryArr);
        console.log(oppositeCategoryArr);
        if(categoryArr.length < 1){
            categoryArr = ["none"];
        }
        if(oppositeCategoryArr.length < 1){
            oppositeCategoryArr = ["none"];
        }
        
        
        $.ajax({
            url: 'includes/company.inc.php',
            method: 'POST',
            data:{
                action:action,
                companyName:companyName,
                categoryArr:categoryArr,
                oppositeCategoryArr:oppositeCategoryArr
            },
            success:function(data){
                $(".show-content").html(data);
  
            }
        });
    });

    $(document).on('click','#submit-category',function(){
        let action = 'create-category';
        let category = $("#create-category-input").val().split('\n');
        $.ajax({
            url: 'includes/category.inc.php',
            method: 'POST',
            data:{
                action:action,
                category:category,
            },
            success:function(data){
                $(".show-content").html(data);
            }
        });
    });

    $(document).on('change','#company-select',function(){
        printCompanyCategory();
    });
    
    $(document).on('click','.toggle-sheet-table',function(){
        let target = $(this).attr("data-target");
        $("#"+target).toggle(500);
    });

    $(document).on('click','.select-sheet-line',function(){
        
        let tableRow = $(this).parent().parent();
        let thisOrder = tableRow.attr("data-order");

        var counter = $(".selected-row").length;
        counter = counter + 1;

        if($(this).is(":checked",true)){
            tableRow.addClass("selected-row");
            tableRow.attr("data-order",counter);
        }else{
            /**
             * Keep the data order as 1,2,3,4 ... 
             * Keep the data in order as well. Convert : 1,2,4 to 1,2,3
             * Or converts 4,2,3 to 3,1,2
             */
            $('[data-order]').each(function(){
                let confirmOrder = $(this).attr("data-order");
                if( confirmOrder > thisOrder){
                    confirmOrder = confirmOrder - 1;
                    $(this).attr("data-order", confirmOrder);
                }
            });
            tableRow.removeClass("selected-row");
            tableRow.removeAttr("data-order");
        }
    });


    function fetchCategorySelector(selector){
        /**
         * Create a select input in the desired area
         */
        let action = 'load-category';
        let subAction = 'load-select';
        $.ajax({
            url:'includes/category.inc.php',
            method:'POST',
            data:{
                action:action,
                subAction:subAction
            },
            success:function(data){
                $(selector).html(data);
            }
        }); 
    }
    fetchCategoryCheckBox("#create-company-select-category");
    fetchCategoryCheckBox("#create-company-select-opposite-category");
    function fetchCategoryCheckBox(selector){
        /**
         * Create Buttons/Inputs  in the desired area
         */
        let action = 'load-category';
        let subAction = 'load-checkbox';
  
        $.ajax({
            url:'includes/category.inc.php',
            method:'POST',
            data:{
                action:action,
                subAction:subAction
            },
            success:function(data){
                $(selector).html(data);
            }
        });
    }

    function printSheetTable(){
        let tableArea = $("#print-sheet-table");
        $.ajax({
            url:'includes/sheet.inc.php',
            method:'POST',
            data:{

            },
            success : function(data){
                tableArea.html(data);
                let tdTag = tableArea.find('td');
                tdTag.each(function(){
    
                });
            }

        });
    }
    

    function printCompanySelector(){
        let action = 'getCompany';
        $.ajax({
            url: 'includes/company.inc.php',
            method:'POST',
            data:{
                action:action
            },
            success : function(data){
                $("#company-select").html(data);
                printCompanyCategory();
            }

        });
    }

    function printCompanyCategory(){
        let select = $("#company-select :selected");
        let categoryJSON = select.attr("data-category");
        let oppositeCategoryJSON = select.attr("data-oppositeCategory");
        $("#company-category").text(categoryJSON);
        $("#opposite-company-category").text(oppositeCategoryJSON);
        
    }
    printSheetTable();
    printCompanySelector();
});