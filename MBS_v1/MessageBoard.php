<?php
    $is_login = false;
    $user_id = '';

    if(isset($_COOKIE["certificate_id"]) && !empty($_COOKIE["certificate_id"])) {
        $is_login = true;
	};
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
        <title>  留言板 </title>

        <style> 

        	*{
			    box-sizing: border-box;
			} 

            .connection{
            	width: 20%;
            	position: absolute;
            	left: 25%;
            	top: 5px;
            }

            .mainpage{
                width: 50%;
                margin: 0 auto; 
                position: absolute;
			    top: 50px;
			    left: 25%;
            }

            .page_header{
           	    display: flex;
           	    justify-content: center;
            }

            .formblock{
			    border-radius: 5px;
			    background-color: LightGray;
			    padding: 20px;
			}

            #textarea{
            	width: 100%;
            	height: 200px;
				padding: 12px 20px;
				margin: 8px 0;
				border: 1px solid #ccc;
				border-radius: 4px;
		    }

			#textarea:focus{
			    border: 2px solid black;
			}

            input[type=submit], .formtext{
                border-radius: 5px;
			    background-color: DodgerBlue;
			    color: white;
			    width: 120px;
			    padding: 10px;
				text-align: center;
				font-size: 16px;
			}

            .boardcomments{
            	border: 1px solid #ccc;
            	border-radius: 4px;
            	position: relative;
            	top: 20px;
            	margin-bottom: 20px; 
            	padding: 10px;
			}

			.comment_header{
				border-bottom: 1px solid rgba(0, 0, 0, 0.5);
				padding: 10px;
				display: flex;
				justify-content: space-between;
			}

			.comment_content{
				padding: 10px;
			}

            .subcomment{
				background-color: LightGray;
				width: 95%;
				position: relative;
				left: 5%;
				margin-top: 10px;
				padding: 10px 0px 10px 10px;
			}

			.subcomment .comment_content{
				background-color: white;
				padding: 10px 10px;
				border: 1px solid #ccc;
				border-radius: 4px;
				width: 99%;
			}

			.comment .formblock{
				width: 95%;
				position: relative;
				left: 5%;
				margin-top: 20px;
				padding: 0px;
			}
            
            .login_conn, .logout_conn, .register_conn{
            	color: white;
            	display: inline-block;
            	width: 25%;
				padding: 8px;
            	border-radius: 4px;
                margin: 4px;
				text-align: center;
				font-family: "Serif";
				font-size: 16px;
            }

            .login_conn:hover, .logout_conn:hover {
                background-color: hsl(39, 80%, 50%);
            }

            .login_conn, .logout_conn{
                background-color: orange;
            }

            .login_conn a, .logout_conn a {
                text-decoration: none;
            }

            .register_conn:hover{
            	background-color: #f44336;
            }

            .register_conn {
            	background-color: tomato;
            }

            .register_conn a {
            	text-decoration: none;
            }

            a:link, a:visited {
			    color: white;
			}

			.pagesnum {
			    display: flex;
			    justify-content: center;
			    position: relative;
			    top: 20px;
			    padding: 25px 0px 50px 0px;
			}

			.pagesnum a {
			    color: black;
			    float: left;
			    padding: 8px 16px;
			    text-decoration: none;
			    border-radius: 5px;
			    transition: background-color .3s;
			    border: 1px solid #ddd; /* Gray */
			    margin: 0 4px;

			}
			.pagesnum a.active{
			    background-color: MediumSeaGreen;
                color: white;
                border-radius: 5px;
            }

            .pagesnum a:hover:not(.active){background-color: #ddd;}

            .pagesnum a.firstpage:hover, .pagesnum a.endpage:hover{
            	background-color: white;
            }
            
            .reply{
                background-color: darkgray;
                width: 100%;
                padding: 10px 10px 10px 0px;  
            }

            .btn{
                background-color: gray;
                color: white;
                width: 10%;
                padding: 10px 15px;
                text-align: center;
                font-size: 16px;
                text-decoration: none;
            }

            .hiddenform{
                display: none;
            }

            .showform{
                border-bottom-left-radius: 5px;
                border-bottom-right-radius: 5px;
                background-color: Lightgray;
                padding: 15px;
                display: block;
            }

        </style>

        <script type="text/javascript">
        	document.addEventListener("DOMContentLoaded", function(){
        		for(let i = 0; i < document.querySelectorAll(".btn").length; i++) {
				    document.querySelectorAll(".btn")[i].addEventListener("click", (e)=>{
	                    const nreply = document.querySelectorAll(".hiddenform")[i];
                        //console.log(nform);
	                    nreply.classList.toggle('showform');
	                });
				};
            });
        </script>
	</head>
	
	<body>
		<div class="connection">

			<?php 
			    if(!$is_login){
			?>
			    	<div class="login_conn">
	                    <a href="login.php"> 登入 </a> 
	                </div>
            <?php
			    } else {
            ?>
		            <div class="logout_conn">
			            <a href="logout.php"> 登出 </a> 
			        </div>
            <?php 
                };
			?>

	        <div class="register_conn">
	            <a href="register.php"> 註冊 </a>
            </div>
	    </div>

		<div class="mainpage">
		    <h1 class="page_header"> 留言板 </h1>

	        <div class="formblock">
		        <form method="POST" action="add_comment.php">
		        	<textarea id="textarea" name="content" placeholder="請輸入文字..."></textarea>
		        	<input type="hidden" name="parent_id" value="0"/>
                    <?php
                        if($is_login){
                    ?>
	                    <input type="submit" value="留言"/>
	                <?php
                        } else {
                    ?> 
                        <div class="formtext"> 登入後留言 </div>
                    <?php	
                        };
                    ?>
	            </form>
	        </div>

			<?php
			    require_once "conn.php";
                
                //設定分頁的區塊//
			    $sql_pages = "SELECT count(parent_id) AS toldata FROM comments WHERE parent_id = 0";

			    $result_pages = $conn->query($sql_pages);

			    $row_pages = $result_pages->fetch_assoc();

			    $page_num = ceil($row_pages['toldata'] / 5);
			    //----------------------------------------------------------------------//

			    //設定目前所在頁數//
				if(!isset($_GET['page'])){
				    $page = 1;
				} else { 
					$page = intval( $_GET['page'] );
			    };
			    //----------------------------------------------------------------------//
			     
			    $sql = "SELECT comments.id, comments.content, comments.created_time, user_registration.nickname From comments left join user_registration on comments.user_id = user_registration.id WHERE parent_id = 0 ORDER BY created_time DESC LIMIT " . ($page-1)*5 . ", 5";

			    $result = $conn->query($sql);
			    
			    if ($result->num_rows > 0) {
			    	while($row = $result->fetch_assoc()) {
			            include("boardcomments.php");         
			        }
			    };

			    $conn->close(); 
			?>
            
            <!-- 顯示分頁 -->
			<div class="pagesnum">
                <?php
                    if($page == 1){
                    	echo "<a class='firstpage'>&laquo;</a>";
                    } else {
                    	$frontpage = $page-1;
                    	echo "<a href='MessageBoard.php?page=" . $frontpage . "'>&laquo;</a>";
                    }
				
					for($i = 1; $i <= $page_num; $i++){
						if( $i === $page ){				
                            echo "<a class='active'>" . $i . "</a>";                
						} else {				
						    echo "<a href='MessageBoard.php?page=" . $i . "'>" . $i . "</a>";
						}
					}

					if($page == $page_num){
                    	echo "<a class='endpage'>&raquo;</a>";
                    } else {
                    	$afterpage = $page+1;
                    	echo "<a href='MessageBoard.php?page=" . $afterpage . "'>&raquo;</a>";
                    }
				?>
			</div>
        </div>
	</body>
</html>