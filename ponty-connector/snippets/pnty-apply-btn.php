<div 
    class="pnty-widget" 
    data-pnty-org="<?php echo $org;?>" 
    data-pnty-id="<?php echo $assignment_id;?>" 
    data-pnty-title="<?php echo $title;?>" 
    data-pnty-lang="<?php echo $lang;?>"
    <?php echo ($color)?'data-pnty-color="'.$color.'"':'';?>
    <?php echo ($require_role)?'data-pnty-require-role="1"':'';?>
    <?php echo ($require_files)?'data-pnty-require-files="'.$require_files.'"':'';?>
    <?php echo ($require_gender)?'data-pnty-require-gender="1"':'';?>
    <?php echo ($require_birthyear)?'data-pnty-require-birthyear="1"':'';?>
></div>
<script src="https://pnty-apply.ponty-system.se/static/ext.js"></script>
