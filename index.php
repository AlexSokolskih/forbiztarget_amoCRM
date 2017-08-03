<?php
/**
 * Created by PhpStorm.
 * User: sokolskih
 * Date: 02.08.2017
 * Time: 18:53
 */


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('COUNT_DEALS', 400); //Количество сделок в амоCRM (не более 500)


include_once 'conf/confAmo.php';
include_once 'classes/amoDeals.php';
include_once 'classes/deal.php';
include_once 'classes/amoTasks.php';
include_once 'authorization.php';


$amoDeals = new AmoDeals();

$dealsArray = $amoDeals->getDeals(COUNT_DEALS);
sleep(1);

var_dump($dealsArray);
$amoTasks = new AmoTasks();
foreach ($dealsArray as $index => $item) {
    $existTask = $amoTasks->getTaskForIdDeal($dealsArray[$index]->id);
    sleep(1);
    if (!$existTask) {
        $amoTasks->taskPinedDeal($dealsArray[$index]->id);
    }
}



