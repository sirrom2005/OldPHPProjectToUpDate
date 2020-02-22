<?php
$time = time();
$amount = $_POST['amount'];
$account = $_POST['account'];
$front = $_POST['encodedFrontOfCheck'];
$back = $_POST['encodedBackOfCheck'];

if(empty($front) || empty($back) || empty($amount) || empty($account)){
    $json = array('code'=>'00005','message'=>'One ore more input is required.');
}else{
    if($front){
       createImage($time."_frontOfCheck.jpg", $front); 
    }

    if($back){
       createImage($time."_backOfCheck.jpg", $back); 
    }

    $fileName = $amount.".html";
    $data     = "<b>Amount: </b>{$amount}<br>"
                . "<b>Account Number: </b>{$account}<br><br>"
                . "<b>Front of check</b><br><img src='{$time}_frontOfCheck.jpg'/><br><br>"
                . "<b>back of check</b><br><img src='{$time}_backOfCheck.jpg'/>";

    $handle = fopen($fileName, "w");
    fwrite($handle, $data);
    fclose($handle);
    
    if(file_exists($fileName) && file_exists($time."_frontOfCheck.jpg") && file_exists($time."_backOfCheck.jpg")){
        $json = array('code'=>'00001','message'=>'Task completed successfully.');
    }else{
        $json = array('code'=>'00021','message'=>'Cound not create files.');
    }
}

function createImage($fileName, $data ){
    $file = base64_decode($data);
    $handle = fopen($fileName, "w");
    fwrite($handle, $file);
    fclose($handle);
}

echo json_encode($json);
?>