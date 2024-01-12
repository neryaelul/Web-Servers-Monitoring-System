<?php

    require __DIR__ . '/src/class/access.php';
    require __DIR__ . '/src/class/webservers.php';
    require __DIR__ . '/src/class/tokens.php';
    require __DIR__ . '/src/class/history.php';
    require __DIR__ . '/src/class/emails.php';


    header('Content-Type: application/json');
    $headers = getallheaders();

    $access_user = new access();
    $validation = $access_user->validation($headers['Bylith-Name'], $headers["Bylith-Token"]);
    if($validation['status']){
       
        $className = $patchs[3];
        if (class_exists($className)) {
            $class_use  = new $className($validation,$app_settings);
            $method_use = $patchs[4];
            if (method_exists($class_use, $method_use)) {
                $request_method = $_SERVER['REQUEST_METHOD'];
                if($app_settings['endpoints'][$className]['operations'][$method_use]['type'] == $request_method){
                    if($app_settings['endpoints'][$className]['operations'][$method_use]['type'] == "GET"){
                        $q = $_GET['q'];
                        $data = $q;
                    }else{
                        $json = file_get_contents('php://input');
                        $data = json_decode($json, true);
                    }
                    $response['info'] = $class_use->$method_use($data);
                    $response['message'] = $app_settings['status'][$response['info']['type']]['message'];
                    $response['code'] = $app_settings['status'][$response['info']['type']]['code'];
                }else{
                    $response['code'] = $app_settings['status']['request_method_not_allowed']['code'];
                    $response['message'] = $app_settings['status']['request_method_not_allowed']['message'];
                }
            }else{
                $response['code'] = $app_settings['status']['function_method_not_allowed']['code'];
                $response['message'] = $app_settings['status']['function_method_not_allowed']['message'];
            }
        }else{
            $response['code'] = $app_settings['status']['source_type_not_allowed']['code'];
            $response['message'] = $app_settings['status']['source_type_not_allowed']['message'];
        }
        

    }else{
        $response['code'] = $app_settings['status']['validate_error']['code'];
        $response['message'] = $app_settings['status']['validate_error']['message'];
        
    }
    echo json_encode($response);
?>
