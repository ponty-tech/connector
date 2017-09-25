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
                $logo_attachment_id = $metadata['_pnty_logo_attachment_id'][0];
                $logo = $metadata['_pnty_logo'][0];
                $logo_url = false;

                if ( ! is_null($logo_attachment_id)) {
                    list($logo_url, $logo_width, $logo_height) =
                        wp_get_attachment_image_src($logo_attachment_id, 'pnty_logo');
                } else if ( ! is_null($logo)) {
                    $logo_url = $logo;
                }
            ?>
            <li><?php echo $post->post_title;?>
                <?php if ($logo_url): ?>
                <img class="pnty-list-logo" src="<?php echo $logo_url;?>" width="<?php echo $logo_width;?>" alt="<?php _e('Client logotype', 'pnty');?>" />
                <?php endif; ?>
                <?php if ($organization_name): ?>
                    <span class="pnty-list-organization-name"><?php echo get_post_meta($post->ID, '_pnty_organization_name', true);?></span>
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
