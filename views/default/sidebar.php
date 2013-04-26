<div class="span2 sidebar">
	<ul class="nav nav-pills nav-stacked">
		<li class="<?php $this -> setActive("inbox"); ?>">
			<a href="<?php echo ABSOLUTE_PATH; ?>mail/inbox">Inbox</a>
		</li>
		<li class="<?php $this -> setActive("sentbox"); ?>">
			<a href="<?php echo ABSOLUTE_PATH; ?>mail/sentbox">Sentbox</a>
		</li>
		<li class="<?php $this -> setActive("trash"); ?>">
			<a href="<?php echo ABSOLUTE_PATH; ?>mail/trash">Trash</a>
		</li>
	</ul>
</div>