<?php
    $q = array('post_type'=>PNTY_PTNAME, 'numberposts'=>$numberposts);
    if ($tag) {
        $q['tax_query'] = array(array(
            'taxonomy' => PNTY_PTNAME.'_tag',
            'field' => 'slug',
            'terms' => explode('|', $tag)
        ));
    }
    $jobs = get_posts($q);
    $pnty_extcss = get_option('pnty_extcss');
?>
<?php if (count($jobs) > 0):?>
    <?php if ( ! is_null($pnty_extcss) && ! empty($pnty_extcss)):?>
        <link rel="stylesheet" href="<?php echo $pnty_extcss;?>" />
    <?php endif; ?>
    <ul class="pnty-list<?php echo ($class)?' '.$class:'';?>">
        <?php global $post; foreach($jobs as $post): setup_postdata($post);?>
            <li>
                <a class="pnty-list-title" title="<?php _e('Permalink for', 'pnty');?> <?php echo $post->post_title;?>" href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
                <?php if ($logo && get_post_meta($post->ID, '_pnty_logo', true)): ?>
                <img class="pnty-list-logo" src="<?php echo get_post_meta($post->ID, '_pnty_logo', true);?>" width="<?php echo $logo_width;?>" alt="<?php _e('Client logo');?>" />
                <?php endif; ?>
                <?php if ($organization_name): ?>
                    <span class="pnty-list-organization-name"><?php echo get_post_meta($post->ID, '_pnty_organization_name', true);?></span>
                <?php endif; ?>
                <?php if ($excerpt): ?>
                    <p class="pnty-list-excerpt"><?php echo get_the_excerpt();?></p>
                <?php endif; ?>
                <?php if ($readmore): ?>
                    <p class="pnty-list-readmore"><a href="<?php echo get_permalink($post->ID);?>"><?php echo $readmore;?></a></p>
                <?php endif; ?>
            </li>
        <?php endforeach; wp_reset_postdata();?>
    </ul>
<?php else: ?>
    <p><?php echo $empty_msg;?></p>
<?php endif; ?>
