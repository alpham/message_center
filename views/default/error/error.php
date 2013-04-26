<div id="error">
	<div class="alert alert-<?php echo $this -> errorType; ?>" style="position: relative;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<span class="error-header"><?php echo $this -> errorType; ?>:
		</span>
		<p class="error-msg">
			<?php echo $this -> errorString; ?>
		</p>
	</div>
</div>
<script type="text/javascript">
    //place the error in the header     
    setError();
</script>
