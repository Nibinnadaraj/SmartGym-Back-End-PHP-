<?php 
class db_model{

    function __construct(){
        $servername = "localhost";
        $username = "admin";
        $password = "12345";
        $dbname ="smartgym";
        global $conn;
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
    }
    
    function loginModel($username,$password){
        $sql = "SELECT * from user WHERE username ='$username' && password = '$password'";
        global $conn;
        $result = $conn->query($sql);
        if($result -> num_rows >0){
        
            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $gymname = $row['gymname'];
                $email = $row['email'];
                $phone = $row['phone'];
            }
        
            $send = array("success"=> true,"id" => $id, "user"=>$username,""=>"","gymname" => $gymname, "email" => $email, "phone" => $phone );
        
            echo json_encode($send);
        }
        else {
        
        echo json_encode('Username And Password Incorrect.!');
        }
    }
    
    

}

?>