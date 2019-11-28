<?php 
    
    if($_GET['purpose'] == 'login'){
        $json = file_get_contents('php://input');

    $jsonArray = json_decode($json, true);
    
    $username = $jsonArray['username'];
    $password = $jsonArray['password'];

    if($username && $password != ''){
        include_once('controller/login_controller.php');
        $controller_obj = new db_controller();
        $controller_obj->loginController($username, $password);
       
    } else{

        echo json_encode('Enter Valid Username And Password!');
    }
    }
    
    else if($_GET['purpose'] == 'adduser'){

        include_once('controller/user_controller.php');
        $controller_obj = new user_controller();
        $controller_obj -> add_user_controller();

    }
    
    else if($_GET['purpose'] == 'userlist'){

        $sort = $_GET['sort'];
        include_once('controller/user_controller.php');
            $controller_obj = new user_controller();
            $controller_obj-> db_controller($sort);
        
    }else if($_GET['purpose'] == 'profile'){
        $id = $_GET['id'];
        include_once('controller/user_controller.php');
            $controller_obj = new user_controller();
            $controller_obj-> profile_controller($id);
        
    }else if($_GET['purpose'] == 'delete'){
        $id = $_GET['id'];
        include_once('controller/user_controller.php');
        $controller_obj = new user_controller();
        $controller_obj -> delete_controller($id);

    }else if($_GET['purpose'] == 'addpackage'){
        $gymid = $_GET['gymid'];
        include_once('controller/package_controller.php');
        $controller_obj = new package_controller();
        $controller_obj -> add_controller($gymid);

    }
    else if($_GET['purpose'] == 'viewpackage'){
        $gymid = $_GET['gymid'];
        include_once('controller/package_controller.php');
        $controller_obj = new package_controller();
        $controller_obj -> view_controller($gymid);

    }
    else if($_GET['purpose'] == 'deletepackage'){
        $id = $_GET['id'];
        include_once('controller/package_controller.php');
        $controller_obj = new package_controller();
        $controller_obj -> delete_controller($id);

    }
    else if($_GET['purpose'] == 'payment'){

        include_once('controller/user_controller.php');
        $controller_obj = new user_controller();
        $controller_obj -> payment_controller();

       
    

    }
    
    



?>