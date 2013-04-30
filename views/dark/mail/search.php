<div class="span9">
    <div class="inbox">
        <div class="scroll-area">
            <?php $this -> loadSearch(isset($_GET['q']) ? $_GET['q'] : NULL ); ?>
        </div>
        <?php $this -> loadPaginationSearch(isset($_GET['page'])? $_GET['page'] : 0); ?>
    </div>
</div>