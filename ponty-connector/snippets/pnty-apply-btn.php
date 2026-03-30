<div
    class="pnty-widget"
    data-pnty-org="<?php echo $a['org'];?>"
    data-pnty-id="<?php echo $a['assignment_id'];?>"
    data-pnty-title="<?php echo $a['title'];?>"
    data-pnty-lang="<?php echo $a['lang'];?>"
    <?php echo ($a['color'])?'data-pnty-color="'.$a['color'].'"':'';?>
    <?php echo ($a['require_role'])?'data-pnty-require-role="1"':'';?>
    <?php echo ($a['require_files'])?'data-pnty-require-files="'.$a['require_files'].'"':'';?>
    <?php echo ($a['require_gender'])?'data-pnty-require-gender="1"':'';?>
    <?php echo ($a['require_birthyear'])?'data-pnty-require-birthyear="1"':'';?>
></div>
<script src="https://pnty-apply.ponty-system.se/static/ext.js"></script>
