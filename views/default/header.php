<html lang="ar">
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link href="<?php echo ABSOLUTE_PATH; ?>public/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo ABSOLUTE_PATH . THEME_FOLDER; ?>css/custom.css" rel="stylesheet" media="screen">
        <script src="<?php echo ABSOLUTE_PATH; ?>public/js/jquery-latest.js"></script>
        <script src="<?php echo ABSOLUTE_PATH; ?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo ABSOLUTE_PATH . THEME_FOLDER; ?>js/custom.js"></script>

        <title><?php echo PRO_TITLE ?></title>
    <div id="errorPlace">
        <!-- here where error will be set (javascript tricks ;) ) -->
    </div>
    <div class="row">
        <div class="span4"><img src="<?php echo ABSOLUTE_PATH; ?>public/img/logo.jpg"/></div>
        <div class="span8 search-box">
            <form class="form-search" action="<?php echo ABSOLUTE_PATH; ?>mail/search" method="get">
                <div class="input-append">
                    <input type="text" name="q" placeholder="Search..." class="span6 search-query" style="height:30px;">
                    <button type="submit" class="btn btn-info">Go!</button>
                </div></div>
    </form>
    <div class="span2">
        <a class="danger" href="<?php echo ABSOLUTE_PATH; ?>/login?logout">logout</a>
    </div>
</div>


</head>
<body>
    <div class="container-fluid">
        <div class="toolbar">


        </div>
        <div class="row-fluid">

