<?php
class usermodel{
 function __construct(){
    $servername = "localhost";
        $username = "admin";
        $password = "12345";
        $dbname ="smartgym";
        global $conn;
        $conn = mysqli_connect($servername, $username, $password, $dbname);
 }

 function payment_model($package, $paiddate, $nextpayment,  $remainder, $totalamount, $paid, $id){
  $sql = " UPDATE `memberdetails` SET `package` = '".$package."', `paiddate` = '".$paiddate."', `nextpayment` = '".$nextpayment."', `remainder` = '".$remainder."', `totalamount` = '".$totalamount."', `paid` = '".$paid."' WHERE `memberdetails`.`id` = ".$id."";

global $conn;


if($conn -> query($sql) === TRUE){
    echo json_encode("Payment Succesfully.!");

}else{
    echo json_encode("Payment Unsuccesfull". $conn->error);

} 

   

 }


 function add_user_model($name , $address, $email, $phone, $admission_date, $package, $picture, $paiddate, $nextpayment,  $gender ){


    $sql = "INSERT INTO `memberdetails` (`id`, `gymid`, `name`, `address`, `email`, `phone`, `admission_date`, `package`, `picture`, `paiddate`, `nextpayment`, `remainder`, `totalamount`, `paid`, `gender`) VALUES (NULL, '1', '".$name."', '".$address."', '".$email."', '".$phone."', '".$admission_date."', '".$package."', '".$picture."', '".$paiddate."', '".$nextpayment."', '0', '0', '0', '".$gender."')";

global $conn;


if($conn -> query($sql) === TRUE){
    echo "Member Added";

}else{
    echo ("Can't Add Member". $conn->error);

} 

   

 }


 public function db_select(){
    $sql = "SELECT MAX(id)
    FROM memberdetails
    WHERE gymid=1";
    global $conn;
    $result = $conn->query($sql);
    if($result -> num_rows >0){
    
        while($row = $result->fetch_assoc()) {

        $data[]=$row;
            
        }
       return $maxId = $data[0]['MAX(id)'];
    
    }
    
 }

 function db_all(){
    $date =Date('Y-m-d');
    $date = strtotime('-3 Months');
    $date = date('Y-m-d',$date);

         $sql = "SELECT * from memberdetails WHERE gymid=1 AND paiddate > '".$date."' ";
        global $conn;
        $result = $conn->query($sql);
        if($result -> num_rows >0){
        
            while($row = $result->fetch_assoc()) {

            $data[]=$row;
                
            }
            $json['userlist']=$data;

            echo json_encode($json);
        
        }
        else {
        
        echo json_encode('No Members');
        }


 }

 function db_fullpaid(){

    $date =Date('Y-m-d');
    $date = strtotime('-3 Months');
    $date = date('Y-m-d',$date);

  $sql = "SELECT * from memberdetails where remainder = 0 AND paiddate > '".$date."'  ";
   
  global $conn;

  $result = $conn->query($sql);
        if($result -> num_rows > 0){

            while($row = $result -> fetch_assoc()){

                $data[] = $row;
            
              }

              $json['userlist'] = $data;

              echo json_encode($json);    

        }else {

            echo json_encode('No Members');
        }


 }

 function db_unpaid(){

    $date =Date('Y-m-d');
    $date = strtotime('-3 Months');
    $date = date('Y-m-d',$date);
    $today = date('Y-m-d');

    $sql = "SELECT * FROM memberdetails WHERE nextpayment < '".$today."' && paiddate > '".$date."'";

    global $conn;

    $result = $conn -> query($sql);

    if($result -> num_rows >0 ){
        while($row= $result ->fetch_assoc()){

            $data[] = $row;

        }

        $json['userlist'] = $data;
        echo json_encode($json);
    }else {

        echo json_encode('No Members');
    }

     
}

function db_remainder(){

    $date =Date('Y-m-d');
    $date = strtotime('-3 Months');
    $date = date('Y-m-d',$date);

    $sql = "SELECT * FROM memberdetails WHERE remainder > 0 && paiddate > '".$date."'";

    global $conn;

    $result = $conn -> query($sql);

    if($result -> num_rows >0 ){
        while($row= $result ->fetch_assoc()){

            $data[] = $row;

        }

        $json['userlist'] = $data;
        echo json_encode($json);
    }else {

        echo json_encode('No Members');
    }
     
}

function db_expired(){

    $date =Date('Y-m-d');
    $date = strtotime('-3 Months');
    $date = date('Y-m-d',$date);


    $sql = "SELECT * from memberdetails WHERE paiddate < '".$date."'";

    global $conn;

    $result = $conn->query($sql);

    if($result -> num_rows > 0 ){
            while($row = $result -> fetch_assoc()){
                $data[] = $row;

            }

            $json['userlist'] = $data;
            echo json_encode($json);
    }else {

        echo json_encode('No Members');
    }

     
}

function db_expiredindays(){
    $today =Date('Y-m-d');
    $date = strtotime('-3 Months');
    $date = date('Y-m-d',$date);
    $aweekago = strtotime('-7 days');
    $aweekago = date('Y-m-d', $aweekago);

    $sql = "SELECT * from memberdetails WHERE paiddate < '".$date."'";

    global $conn;

    $result = $conn->query($sql);

    if($result -> num_rows > 0 ){
            while($row = $result -> fetch_assoc()){
                $data[] = $row;

            }
            for ($row = 0; $row < count($data); $row++) {
                $expiry = strtotime("+3 Months", strtotime($data[$row]['paiddate']));
                $expiry = date('Y-m-d',$expiry);
                if($expiry >= $aweekago){
                    $newdata[]= array("id" => $data[$row]['id'],"gymid"=> $data[$row]['gymid'],"name"   => $data[$row]['name'],"address" => $data[$row]['address'],"email" => $data[$row]['email'],"phone" => $data[$row]['phone'],"admission_date" => $data[$row]['admission_date'],"package" => $data[$row]['package'],"picture" => $data[$row]['picture'],"paiddate" => $data[$row]['paiddate'],"nextpayment" => $data[$row]['nextpayment'],"remainder" => $data[$row]['remainder']);
                }
                
              }

            $json['userlist'] = $newdata;
             echo json_encode($json); 
    }else {

        echo json_encode('No Members');
    }
     
}

function db_lastmonthregister(){
    $today =Date('Y-m-d');
    $lastmonth = strtotime('-1 Months');
    $date = date('Y-m',$lastmonth);
    echo $date;


    $sql = "SELECT * from memberdetails WHERE admission_date LIKE '".$date."%'";

    global $conn;

    $result = $conn->query($sql);

    if($result -> num_rows > 0 ){
            while($row = $result -> fetch_assoc()){
                $data[] = $row;

            }
            $json['userlist'] = $data;
            echo json_encode($json);
    }else {

        echo json_encode('No Members');
    }
    
     
}

function db_profile($id){
    $sql = "SELECT * from memberdetails where id = $id";
    global $conn;

    $result = $conn -> query($sql);

if($result -> num_rows> 0){
    while($row = $result -> fetch_assoc()){
        $data[] = $row;
    }
    $json = $data;
            echo json_encode($json);
}else {

    echo json_encode('No Members');
}

}

function db_delete($id){
$sql = "DELETE FROM memberdetails WHERE id='".$id."'";

global $conn;

if($conn -> query($sql) === TRUE){
    echo json_encode('Deleted Member Succesfully');
    

}else{
    echo json_encode("Can't Delete Member". $conn->error);

}

}

}
?>