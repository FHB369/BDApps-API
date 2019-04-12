<?php

    require_once 'connection.php';
    header('Content-Type: application/json');

    class PurchaseCheck{

        private $db;
        private $connection;

        function __construct()
        {
            $this->db = new DB_Connection();
            $this->connection = $this->db->get_connection();
        }

        public function check_purchase($user_id, $trxid, $amount)
        {
            $query = "Select * from purchase where user_id = '$user_id' and trxid = '$trxid' and amount = '$amount'";
            $if_exist = mysqli_query($this->connection, $query);
            if(mysqli_num_rows($if_exist) > 0){
                $json['success'] = 'Purchase was successful';
            }else{
                $json['error'] = 'Purchase not found';
            }

            echo json_encode($json);
            mysqli_close($this->connection); 
        }

    }

    $purchase = new PurchaseCheck();

    if(isset($_POST['user_id'], $_POST['trxid'], $_POST['amount'])){
        $user_id = $_POST['user_id'];
        $trxid = $_POST['trxid'];
        $amount = $_POST['amount'];

        if(!empty($user_id) && !empty($amount) && !empty($trxid)){

            $purchase-> check_purchase($user_id, $trxid, $amount);
        } else {
            echo json_encode("You must pass both fields"); 
        }
    }

?>