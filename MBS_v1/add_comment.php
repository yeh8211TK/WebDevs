<?php
    require_once "conn.php";
     
    $parent_id=$_POST['parent_id'];
    //$user_id=$_COOKIE['user_id'];
    $content=$_POST['content'];
    
    //連結 users_certificate 與 user_registration 資料表//
    $certificate_id = $_COOKIE["certificate_id"];

    $sql_user = "SELECT user_registration.id, users_certificate.certificate_id From users_certificate left join user_registration on users_certificate.username = user_registration.username WHERE users_certificate.certificate_id = '$certificate_id'";

    if ($result_user = $conn->query($sql_user)) {
        $row_user = $result_user->fetch_assoc();
        $id = $row_user['id'];
    };
    //------------------------------------------------//

    $sql = "INSERT INTO comments (parent_id, user_id, content) VALUES ($parent_id, $id, '$content')";

    if($conn->query($sql)){
        header('location: MessageBoard.php');
    } else {
        echo "留言失敗!";
    };

    $conn->close();
 
?>
