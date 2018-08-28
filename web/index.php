<?php









use Motork\CarController;

require_once __DIR__.'/../src/bootstrap.php';



$controller = CarController::create();

// create a db connection ...
$filename = CONFIG_DATA_DIR.'/motork_dev_test';
if(is_file($filename)){
    
    try
    {
        $db = new PDO('sqlite:'.$filename);       
        
// ... and set a PDO obj for future use        
        $controller->setDB($db);
      
    }
    catch(PDOException $e)
    {
        // no DB, no party
        print 'Exception : '.$e->getMessage();
        die();
    }

} else {
    die('impossible open db file');
}


$urlParts = parse_url($_SERVER['REQUEST_URI']);

if (preg_match('#^/test$#', $urlParts['path'], $matches)) {
    
    $controller->getTest();
    
} else if (preg_match('#^/saveform$#', $urlParts['path'], $matches)) {
    
    $controller->saveForm();
    
} else if (preg_match('#^/leads$#', $urlParts['path'], $matches)) {
    
    $controller->getLeads();
    
} else if (preg_match('#^/privacy$#', $urlParts['path'], $matches)) {
    
    $controller->getPrivacy();
    
} else if (preg_match('#^/detail/([^/]+)$#', $urlParts['path'], $matches)) {
    
    if(isset($matches[1])) $id_car = $matches[1];
    else $id_car="";

    $controller->getDetail($id_car);
    

} else {
    
    $controller->getIndex();
}

