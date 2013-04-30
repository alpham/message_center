<div class="span9">
	<div class="inbox">
		<div class="scroll-area">
			<?php $this -> getMessagesOf("inbox"); ?>
		</div>
		<?php $this -> loadPagination(isset($_GET['page'])? $_GET['page'] : 0); ?>
	</div>
</div>