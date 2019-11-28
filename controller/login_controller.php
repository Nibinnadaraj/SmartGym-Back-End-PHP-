<?php 

class db_controller{

    function __construct(){


    }

    function loginController($username,$password){
    include_once('model/login_model.php');
    $model_obj = new db_model();
    $model_obj-> loginModel($username, $password);

   }
}

?>