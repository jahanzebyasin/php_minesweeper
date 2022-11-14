<?php
//this request file is to intercept any incomming requests
$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_REQUEST["method"]) ? $_REQUEST["method"] : 'default';
switch ($method) {
  case 'POST':
    routeHandler($request, $_POST);  
    break;
  case 'GET':
    routeHandler($request, $_GET);  
    break;
  default:
    //handle invalid route
    routeHandler($path, $_REQUEST); 
    break;
}

function routeHandler($path, $requestParams) {
    switch ($path) {
        case 'record':
            $controller = new MinesweeperController();
            echo $controller->record($requestParams);
            break;
            break;
        case 'rest':
            $controller = new MinesweeperController();
            echo $controller->reset($requestParams);
            break;
        case 'create':
            $controller = new MinesweeperController();
            echo $controller->create($requestParams);
            break;
        default:
           //handle invalid route
           $controller = new MinesweeperController();
           echo $controller->home($requestParams);
           break;
        }
}

//Routes
