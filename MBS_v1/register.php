<?php      
    require_once "conn.php";

    $empty_message="";
    
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname'])) { 
        
        if (!empty($_POST['username'] && $_POST['password'] && $_POST['nickname'])) { 
        
            $username=$_POST['username'];
            $password=password_hash($_POST['password'], PASSWORD_BCRYPT);
	        $nickname=$_POST['nickname'];

            // 預防 SQL injection //
            $stmt = $conn->prepare("INSERT INTO user_registration (username, password, nickname) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $nickname);
            $stmt->execute();
            $result = $stmt->get_result();
            //--------------------------------------------------------------------------//

            //$sql = "INSERT INTO user_registration (username, password, nickname) VALUES ('$username', '$password', '$nickname')";
            //$result = $conn->query($sql);
            
            //設置 cookie
            if($result){

                //通行證機制//
                $certificate_id = bin2hex(random_bytes(16));
                
                $sql_certificate = "INSERT INTO users_certificate (certificate_id, username) VALUES ('$certificate_id', '$username')";

                if ($conn->query($sql_certificate)) {
                    setcookie("certificate_id", $certificate_id, time()+3600*24);
                };
                //----------------------------------------------------------------------//

                //$last_id = $conn->insert_id;
                //setcookie("user_id", $last_id, time()+3600*24);
            };
                        
            header('location: MessageBoard.php');

        } else {    
            $empty_message = "請輸入帳號、密碼和暱稱!";
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
        <title>  註冊 </title>

        <style> 

        	*{
			    box-sizing: border-box;
			} 

			.register_page{
	            width: 50%;
	            margin: 0 auto; 
	            position: absolute;
	            top: 50px;
	            left: 25%;
            }

            .register{
           	    display: flex;
           	    justify-content: center;
            }

            .register_form{
                border-radius: 5px;
                background-color: LightGray;
                padding: 20px;
                display: flex;
                justify-content: center;
            }

            .username, .password, .nickname, .submit_btn{
                padding: 10px;
            }
            
        </style>
	</head>
	
	<body>
	    <div class="register_page">
		    <h1 class="register"> 註冊 (Registration) </h1>

		    <div style="color: Red; text-align: center;"> 
                <?php
                    if($empty_message!==""){
                        echo $empty_message;
                    };
                ?> 
            </div>

            <div class="register_form">
			    <form action='register.php' method='POST'>
				    <div class="username"> 
                        使用者名稱 (username) = <input name='username' type="text" /> 
                    </div> 

                    <div class="password">
        			    密碼 (password) = <input name='password' type='password'/>
                    </div> 
                     
                    <div class="username"> 
                        暱稱 (nickname) = <input name='nickname' type="text" /> 
                    </div> 

                    <div class="submit_btn">
        		        <input type="submit" />
                    </div>            
		        </form>
		    </div> 
        </div> 
	</body>
</html>