	<div class="panel panel-default">
    <div class="panel-heading clearfix">  
        <h2>Code Igniter / Bootstrap Table with Pagintation</h2>
    </div>        
    <div class="panel-body">
    <?php echo $pagination;?>    
    <?php
    if(isset($table)){
    ?>
        <div class="data">
            <?php echo $table; ?>
        </div>
    <?php
    }
    ?>
    <?php echo $pagination;?>
    </div>
</div>
