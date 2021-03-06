<?php

    include 'autoload.inc.php';
    include 'functions.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
    

    function newGoogleClient(){
        $client = new \Google_Client();
        $client->setApplicationName('Dentsu GoogleSheets');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'] . '/credentials.json');    
        return $client;
    }
    
    function getSheetTable($range ){
        $client = newGoogleClient();
        $service = new Google_Service_Sheets($client);
        $spreadsheetID = '1OULKoKtRvlotJF8YBDyqFqJtK37xPUtTN7-M_cfzHgE';
        

        $response = $service->spreadsheets_values->get($spreadsheetID, $range);
        $values = $response->getValues();
        $rows = array();
        if(empty($values)){
            $rows = false;
        }else{
            foreach($values as $row){
                $rows[] = $row;
            }
        }
        return $rows;
    }

 
    $rangeHeader = 'Sheet1!A13:EA14';

    $rowSheetHeader = getSheetTable($rangeHeader);
    $tableHeader = '';
    foreach($rowSheetHeader as $row){
        $tableHeader .= '<tr class="table-header">';
        $tableHeader .= '<td ><input class="select-sheet-line" type="checkbox"></td>';
        foreach($row as $values){
            $tableHeader .= '<td>';
            $tableHeader .= $values;
            
            //$tableHeader .= '<input class="table-input" value="'.$values.'">';
            $tableHeader .= '</td>';
        }
        $tableHeader .= '</tr>';
    }
    

    $rangeBody = 'Sheet1!A15:EA93';

    $rowSheetBody = getSheetTable($rangeBody);
    $tableBody = '';
    foreach($rowSheetBody as $row){
        $tableBody .= '<tr class="table-body-line">';
        $tableBody .= '<td ><input class="select-sheet-line" type="checkbox"></td>';

        foreach($row as $values){
            $tableBody .= '<td>';
            //$tableBody .= '<input class="table-input" value="'.$values.'">';
            $tableBody .= $values;
            $tableBody .= '</td>';
        }
        $tableBody .= '</tr>';
    }
   






    $client = newGoogleClient();
    $service = new Google_Service_Sheets($client);
    $spreadsheetID = '1OULKoKtRvlotJF8YBDyqFqJtK37xPUtTN7-M_cfzHgE';
    $range = 'Sheet1!A15:EA93';
    $response = $service->spreadsheets_values->get($spreadsheetID, $range);
    $values = $response->getValues();

    $rows = array();
    if(empty($values)){
        $rows = false;
    }else{
        foreach($values as $row){
            $rows[] = $row;
        }
    }
    //print_r($rows[0]);
?>




<table class="table table-bordered text-center sheet-table">

    <tbody>
        <?php echo $tableHeader;?>
        <?php echo $tableBody;?>
    </tbody>
</table>
            