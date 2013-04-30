<div class="span9">
	<div class="scroll-area">
		<div class="compose">
			<form action="<?php echo ABSOLUTE_PATH; ?>mail" method="post">
				<label>To: </label>
				<input type = "text" name="to" placeholder="to..." class="input-xxlarge" />
				<br />
				<label>Subject: </label>
				<input type = "text" name="subject" placeholder="message title..." class="input-xxlarge" />
				<br />
				<textarea name="body"></textarea>
				<br />
				<input type="hidden" value="<?php echo USER_ID; ?>" name = "from"/>
				<button class="btn btn-large btn-success" type="submit" name="send" >
					Send
				</button>
				or <a href="<?php echo ABSOLUTE_PATH; ?>/mail/inbox">Cancle</a>
				<br />

			</form>
		</div>

	</div>
</div>