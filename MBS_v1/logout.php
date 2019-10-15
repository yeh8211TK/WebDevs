<?php     
    //刪除 users_certificate 資料表資料和 cookie//
    require_once "conn.php";
    
    $certificate_id = $_COOKIE["certificate_id"];
    
    $sql = "DELETE FROM users_certificate WHERE certificate_id = '$certificate_id'";
    
    if ($conn->query($sql)) {
        setcookie("certificate_id", '', time()+3600*24);
    };

    $conn->close();
    //-----------------------------------------------------------------------------------//

    header('location: MessageBoard.php');
?>