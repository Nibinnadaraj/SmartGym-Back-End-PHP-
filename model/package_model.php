<?php 
class package_model{
    function __construct(){

        $servername = "localhost";
        $username = "admin";
        $password = "12345";
        $dbname ="smartgym";
        global $conn;
        $conn = mysqli_connect($servername, $username, $password, $dbname);


    }


    function add_model($gymid, $package_name, $amount, $validity){

        $sql = "INSERT INTO `package` (`id`, `gymid`, `package_name`, `amount`, `validity`) VALUES (NULL, '".$gymid."', '".$package_name."', '".$amount."', '".$validity."');";
        global $conn;
        if($conn -> query($sql)){
            echo json_encode("Succesfully Updated New Package.!");
        }else{
            echo json_encode("Error While Updating New Package.!");
        }



    }

    function view_model($gymid){
        $sql = "SELECT * from package WHERE gymid=".$gymid."";
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

    function delete_model($id){
        $sql = "DELETE FROM `package` WHERE `package`.`id` = ".$id."";
        global $conn;
        if($conn -> query($sql)){
            echo json_encode("Succesfully Deleted Package.!");
        }else{
            echo json_encode("Error While Deleting Package.!");
        }
    }

  public  function get_validity($id){

        $sql = "SELECT validity FROM package WHERE id='".$id."' ";
    global $conn;
    $result = $conn->query($sql);
    if($result -> num_rows >0){
    
        while($row = $result->fetch_assoc()) {

        $data[]=$row;
            
        }
       return $validity= $data[0]['validity'];
    
    }


    }

    public  function get_amount($id){

        $sql = "SELECT amount FROM package WHERE id='".$id."' ";
    global $conn;
    $result = $conn->query($sql);
    if($result -> num_rows >0){
    
        while($row = $result->fetch_assoc()) {

        $data[]=$row;
            
        }
       return $amount= $data[0]['amount'];
    
    }


    }

    public  function get_name($id){

        $sql = "SELECT package_name FROM package WHERE id='".$id."' ";
    global $conn;
    $result = $conn->query($sql);
    if($result -> num_rows >0){
    
        while($row = $result->fetch_assoc()) {

        $data[]=$row;
            
        }
       return $package_name= $data[0]['package_name'];
    
    }


    }

}



?>