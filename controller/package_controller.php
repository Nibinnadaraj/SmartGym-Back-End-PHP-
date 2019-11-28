<?php 


class package_controller{
    function __construct(){


    }


    function add_controller($gymid){

       
        $json = file_get_contents('php://input');
        $jsonArray = json_decode($json, true);

        $package_name = $jsonArray['packagename'];
        $amount = $jsonArray['amount'];
        $validity = $jsonArray['validity'];
        if( $package_name != '' && $amount != '' && $validity != ''){
            if(is_numeric($amount)){

               include_once('model/package_model.php');
               $model_obj = new package_model();
               $model_obj -> add_model($gymid, $package_name, $amount, $validity);

            }else{
                echo json_encode("Enter Correct AMount.!");

            }
            
        }else{

            echo json_encode("Enter Valid Values.!");
        }

    }

    function view_controller($gymid){
        include_once('model/package_model.php');
        $model_obj = new package_model();
        $model_obj -> view_model($gymid);
    }
    function delete_controller($id){
        include_once('model/package_model.php');
        $model_obj = new package_model();
        $model_obj -> delete_model($id);
    }


}

?>