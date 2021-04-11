<?php
  $err_msg = '';
  $username = '';
  $phone = '';
  $list = '';
  $total = '';
  $today = date("Y-m-d H:i:s");

  //use $_POST to get the FormData
  // $username = $_POST['username'];
  // echo 'username: ', $username;

  try{   
    require_once('connect.php');
    if(isset($_POST['username'], $_POST['phone'], $_POST['list'])){
      $username = $_POST['username'];
      $phone = $_POST['phone'];
      $list = $_POST['list'];
      $total = $_POST['total'];
      
      $newCart = $pdo -> prepare("INSERT INTO biken_ministore.shopping_cart (`username`, `phone`, `list`, `total_price`, `date`) VALUES (:username, :phone, :list, :total, :today)");
      $newCart->bindValue(':username', $username);
      $newCart->bindValue(':phone', $phone);
      $newCart->bindValue(':list', $list);
      $newCart->bindValue(':total', $total);
      $newCart->bindValue(':today', $today);

      if($newCart -> execute()){
        echo '成功送出';
      }else{
        echo '送出失敗';
      }       
    }else{
      echo 'get nothing';
    }   
  }catch(PDOException $e){
      $err_msg .= "something went wrong" . $e->getMessage() . "<br>";
      $err_msg .= "on line" . $e->getMessage();
      echo $err_msg;
  }
?>