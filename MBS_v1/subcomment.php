<div class="subcomment">
	<div class="comment_header">
		<div class="comment_author"> <?php echo $sub_row['nickname']; ?> </div>
		<div class="comment_timestamp"> <?php echo $sub_row['created_time']; ?> </div>
	</div>

	<div class="comment_content">
		<!-- 預防 XSS 攻擊 -->
		<?php echo htmlspecialchars($sub_row['content'], ENT_QUOTES,'utf-8'); ?>
	</div>
</div>