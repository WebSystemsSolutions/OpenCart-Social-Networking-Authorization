<?php echo $header; ?>
<div class="container">    
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>'Что-то пошло не так'</div>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <br>
            <span class="h1_title"><?php echo $heading_title; ?></span>

            <p>Пожалуста попребуйте еще раз, если не получиться зарегемтрируйтеся обычним способом</p>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>