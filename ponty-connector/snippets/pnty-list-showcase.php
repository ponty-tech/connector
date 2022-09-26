<?php
    $q = array('post_type'=>PNTY_PTNAME_SHOWCASE, 'numberposts'=>$numberposts);
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
            <?php
                # Get post metadata
                $metadata = get_post_custom($post->ID);
                $logo_attachment_id = $metadata['_pnty_logo_attachment_id'][0] ?? null;
                $logo_old = $metadata['_pnty_logo'][0] ?? null;
                $logo_url = false;

                if ( ! is_null($logo_attachment_id)) {
                    list($logo_url, $logo_attachment_width, $logo_attachment_height) =
                        wp_get_attachment_image_src($logo_attachment_id, 'pnty_logo');
                } else if ( ! is_null($logo_old)) {
                    $logo_url = $logo_old;
                }
            ?>
            <li><?php echo $post->post_title;?>
                <?php if ($logo_url && $logo): ?>
                <img class="pnty-list-logo" src="<?php echo $logo_url;?>" width="<?php echo $logo_width;?>" alt="<?php _e('Client logotype', 'pnty');?>" />
                <?php endif; ?>
                <?php if ($organization_name): ?>
                    <span class="pnty-list-organization-name"><?php echo get_post_meta($post->ID, '_pnty_organization_name', true);?></span>
                <?php endif; ?>
                <?php if ($location && $metadata['_pnty_location'][0]): ?>
                    <span class="pnty-list-location"><?php echo $metadata['_pnty_location'][0];?></span>
                <?php endif; ?>
                <?php if ($excerpt): ?>
                    <p class="pnty-list-excerpt"><?php echo get_the_excerpt();?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; wp_reset_postdata();?>
    </ul>
<?php else: ?>
    <p><?php echo $empty_msg;?></p>
<?php endif; ?>
