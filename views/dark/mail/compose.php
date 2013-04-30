<div class="span9">
	<div class="scroll-area">
		<div class="compose">
			<form action="<?php echo ABSOLUTE_PATH; ?>mail" method="post">
				<label>To: </label>
				<input name="to" placeholder="to..." class="input-xxlarge" />
				<br />
				<label>Subject: </label>
				<input name="subject" placeholder="message title..." class="input-xxlarge" />
				<br />
				<textarea name="body"></textarea>
<br />				<input type="hidden" value="<?php echo USER_ID; ?>" name = "from"/>
				<input type="submit" value="Send" name="send" />
				<br />

			</form>
		</div>

	</div>
</div>