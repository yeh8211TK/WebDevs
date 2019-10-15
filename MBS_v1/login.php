<?php      
    require_once "conn.php";

    $error_message="";
    $empty_message="";
    
    if (isset($_POST['username']) && isset($_POST['password'])) { 
        
        if (!empty($_POST['username'] && $_POST['password'])) { 
        
            $username=$_POST['username'];
            $password=$_POST['password'];
            
            // 預防 SQL injection //
            $stmt = $conn->prepare("SELECT * FROM user_registration WHERE username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            //--------------------------------------------------------------------------//

            //$sql = "SELECT * FROM user_registration WHERE username='$username'";
            //$result = $conn->query($sql);
                     
            $row = $result->fetch_assoc();
            
            if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
                
                //通行證機制//
                $certificate_id = bin2hex(random_bytes(16));
                
                $sql_certificate = "INSERT INTO users_certificate (certificate_id, username) VALUES ('$certificate_id', '$username')";
                
                if ($conn->query($sql_certificate)) {
                    setcookie("certificate_id", $certificate_id, time()+3600*24);
                };
                //----------------------------------------------------------------------//

                //setcookie("user_id", $row['id'], time()+3600*24);
                header('location: MessageBoard.php');
            
            } else {
                $error_message = "帳號或密碼錯誤!";
            }

        } else {    
            $empty_message = "請輸入帳號和密碼!";
        }
    }
    $conn->close();
?>



<!--標準模式HTML5-->
<!DOCTYPE html>
<html>
	<head>
		<!--編碼設定-->
		<meta charset = 'UTF-8' />
		<!--頁面大小設定-->
		<meta name = 'viewport' content='width=device-width, initial-scale=1'>
        <!--標題名稱-->
        <title>  登入 </title>

        <style> 

        	*{
			    box-sizing: border-box;
			} 
            
            .login_page{
                width: 50%;
                margin: 0 auto; 
                position: absolute;
                top: 50px;
                left: 25%;
            }

            .login{
                display: flex;
                justify-content: center;
            }
             
            .login_form{
                border-radius: 5px;
                background-color: LightGray;
                padding: 20px;
                display: flex;
                justify-content: center;
            }

            .username, .password, .submit_btn{
                padding: 10px;
            }
            
        </style>
	</head>
	
	<body>
	    <div class="login_page">
            <h1 class="login"> 登入 (Login) </h1>

            <div style="color: Red; text-align: center;"> 
                <?php
                    if($empty_message!==""){
                        echo $empty_message;
                    } else if($error_message!==""){
                        echo $error_message;
                    };
                ?> 
            </div>

    	    <div class="login_form">
                <form action='login.php' method='POST'>
        		    <div class="username"> 
                        使用者名稱 (username) = <input name='username' type='text'/> 
                    </div> 

                    <div class="password">
        			    密碼 (password) = <input name='password' type='password'/>
                    </div> 
                     
                    <div class="submit_btn">
        		        <input type="submit" />
                    </div>                   
                </form>
            </div> 
        </div> 
	</body>
</html>