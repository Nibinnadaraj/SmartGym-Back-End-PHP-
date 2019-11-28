<?php 
class user_controller{

    function __construct(){


    }

    function db_controller($sort){
       

        include_once('model/user_model.php');
        $model_obj = new usermodel();

                    if($sort == 'all'){
                        $model_obj -> db_all();
                        

                }elseif($sort == 'fullpaid' ){

                    $model_obj -> db_fullpaid();
                    


                }elseif($sort == 'unpaid' ){

                    $model_obj -> db_unpaid();

                }elseif($sort == 'remainder' ){

                    $model_obj -> db_remainder();


                }elseif($sort == 'expired' ){

                    $model_obj -> db_expired();


                }elseif($sort == 'expiredin7days' ){

                    $model_obj -> db_expiredindays();


                }elseif($sort == 'lastmonthregister' ){

                    $model_obj -> db_lastmonthregister();


                }

     
 }
 function profile_controller($id){
    include_once('model/user_model.php');
    $model_obj = new usermodel();
    $model_obj -> db_profile($id);

 }

 function delete_controller($id){
    include_once('model/user_model.php');
    $model_obj = new usermodel();
    $model_obj -> db_delete($id);
 }

 function add_user_controller(){

    include_once('model/user_model.php');
    $model_obj = new usermodel();
    $maxId = $model_obj -> db_select();
    $imageid = ++$maxId;
    $imagename = $imageid.".jpg";
    


    $targer_dir = 'public/images/members/';
    $target_file = $targer_dir.$imagename;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST['name']) && $_POST['name'] != '')
        {


         if (move_uploaded_file($_FILES["memberImage"]["tmp_name"], $target_file)) {
                $name = $_POST['name'];
                $info = $_POST['info'];
                $data = json_decode($info, true);
                $address = $data['address'];
                $email = $data['email'];
                $phone = $data['phone'];
                $admission_date = $data['admission_date'];
                $package = $data['package'];
                $gender = $data['gender'];
                $picture = "http://192.168.43.104/phpserver/".$target_file;

                include_once('model/package_model.php');
                $package_obj = new package_model();
                $validity = $package_obj -> get_validity($package);
                $package_name = $package_obj -> get_name($package);
                $paiddate = $admission_date;
                $datedate = strtotime($admission_date);
                $nextpayment = date("Y-m-d", strtotime("+".$validity." month", $datedate));

                $model_obj -> add_user_model($name , $address, $email, $phone, $admission_date, $package_name, $picture, $paiddate, $nextpayment,  $gender );
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }



    } 
    else {

        echo "File Unable To upload";
    }

    
 }

 function payment_controller(){

    $json = file_get_contents('php://input');

    $jsonArray = json_decode($json, true);

    $id = $jsonArray['id'];
    $payment_date = $jsonArray['payment_date'];
    $package    = $jsonArray['package'];
    $paid_amount   = $jsonArray['paid_amount'];
    include_once('model/package_model.php');
    $package_obj = new package_model();
    $validity = $package_obj -> get_validity($package);
    $paiddate = $payment_date;
    $datedate = strtotime($payment_date);
    $nextpayment = date("Y-m-d", strtotime("+".$validity." month", $datedate));
    $amount = $package_obj -> get_amount($package);
    $remainder = $amount - $paid_amount;

    $package_name = $package_obj -> get_name($package);
    $totalamount = $paid_amount + $remainder;

    include_once('model/user_model.php');
    $user_model = new usermodel();
    $user_model -> payment_model($package, $paiddate, $nextpayment,  $remainder, $totalamount, $paid_amount, $id);
    






 }



}
?>