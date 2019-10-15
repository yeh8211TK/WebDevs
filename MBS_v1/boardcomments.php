<div class="boardcomments">
    <div class="comment">
    	<div class="comment_header">
    		<div class="comment_author"> <?php echo $row['nickname']; ?> </div>
    		<div class="comment_timestamp"> <?php echo $row['created_time']; ?> </div>
    	</div>

    	<div class="comment_content">
    		<!-- 預防 XSS 攻擊 -->
    		<?php echo htmlspecialchars($row['content'], ENT_QUOTES,'utf-8'); ?>
    	</div>

		<?php
		    $parent_id = $row['id'];

		    $sql_child = "SELECT comments.id, comments.content, comments.created_time, user_registration.nickname From comments left join user_registration on comments.user_id = user_registration.id WHERE parent_id = $parent_id ORDER BY created_time DESC";

		    $sub_result = $conn->query($sql_child);

		    while($sub_row = $sub_result->fetch_assoc()) {
                include("subcomment.php");
		    }
		?>

    	<div class="formblock">
    		<div class="reply">
                <a href="#" class='btn'> 回覆 </a>
            </div>

            <div class="hiddenform">
		        <form method="POST" action="add_comment.php">
		        	<textarea id="textarea" name="content" placeholder="請輸入文字..."></textarea>
	    	        <input type="hidden" name="parent_id" value=<?php echo $row['id']; ?> />
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
        </div>
    </div>
</div>
