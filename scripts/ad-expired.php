<?php
/*
* PHP Scripts Check Ads Expired and disabled them today
* @return array ad list expired
*/

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'admin_postemm');
// define('DB_USERNAME', 'admin_postemm');
define('DB_USERNAME', 'root');
// define('DB_PASSWORD', 'UfcMNr3Z');
define('DB_PASSWORD', '');

// Connect database
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
echo "Connect successfully\n";

// AD
$sql = "select * from ads where '". date('Y-m-d', strtotime('-1 days')) . "' = ads.end_date AND ads.inform_sale = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$business_sql = "select * from businesses where businesses.end_date = '".date('Y-m-d', strtotime('-1 days'))."' AND businesses.fee = 1";
$business_stmt = $pdo->prepare($business_sql);
$business_stmt->execute();

$town_sql = "select * from poste_towns where poste_towns.end_date = '".date('Y-m-d', strtotime('-1 days'))."' AND poste_towns.fee = 1";
$town_stmt = $pdo->prepare($town_sql);
$town_stmt->execute();

$export_file_result = true;

$file_content = "This is the list of Expired Ads Today\n";
$file_content .= "ID,Name,Type\n";

$ad_list = $stmt->fetchAll();
$business_list = $business_stmt->fetchAll();
$town_list = $town_stmt->fetchAll();

if(count($ad_list) > 0 || count($business_list) > 0 || count($town_list) > 0) {
    foreach($ad_list as $item) {
        $id = $item['id'];

        echo 'Update ID: '.$id."\n";

        $sql_update = 'UPDATE ads SET ads.inform_sale = 0 WHERE ads.id = '.$id;
        // echo $sql_update;
        $stmt_update = $pdo->prepare($sql_update);
        $result = $stmt_update->execute();

        if($result) {
            echo 'Updated Successfully ID: '. $id."\n";
            $file_content .= $item['id'].",".$item['name'].",AD"."\n";
        }
    }

    // Business
    foreach($business_list as $item) {
        $file_content .= $item['id'].",".$item['name'].",Business"."\n";
    }

    // Town
    foreach($town_list as $item) {
        $file_content .= $item['id'].",".$item['name'].",Town"."\n";
    }

    $export_file_result = file_put_contents(__DIR__ .'/list-expired.csv', $file_content);
}

if($export_file_result) {
    echo "Export File successfully\n";
} else {
    echo "Export File Error\n";
}
