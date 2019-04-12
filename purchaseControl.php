<?php

    require_once 'connection.php';
    header('Content-Type: application/json');

    class Purchase {

        private $db;
        private $connection;

        function __construct()
        {
            $this->db = new DB_Connection();
            $this->connection = $this->db->get_connection();
        }

        public function add_purchase($user_id, $trxid, $amount)
        {
            $query = "Insert into purchase(user_id, trxid, amount) values ('$user_id', '$trxid', '$amount')";
            $is_inserted = mysqli_query($this->connection, $query);
            if($is_inserted == 1){
                $json['success'] = 'Purchase completed, taka:'.$amount;
            }else{
                $json['error'] = 'Purchase Failed';
            }

            echo json_encode($json);
            mysqli_close($this->connection); 
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

    $purchase = new Purchase();
    if(isset($_POST['user_id'], $_POST['trxid'], $_POST['amount'])){
        $user_id = $_POST['user_id'];
        $trxid = $_POST['trxid'];
        $amount = $_POST['amount'];

        if(!empty($user_id) && !empty($amount) && !empty($trxid)){

            $purchase-> add_purchase($user_id, $trxid, $amount);
        } else {
            echo json_encode("You must pass both fields"); 
        }
    }

?>