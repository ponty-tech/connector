<?php
    $q = array('post_type'=>PNTY_PTNAME_SHOWCASE, 'numberposts'=>$a['numberposts']);
    if ($a['tag']) {
        $q['tax_query'] = array(array(
            'taxonomy' => PNTY_PTNAME.'_tag',
            'field' => 'slug',
            'terms' => explode('|', $a['tag'])
        ));
    }
    $jobs = get_posts($q);
?>
<?php if (count($jobs) > 0):?>
    <table class="pnty-table<?php echo ($a['class'])?' '.$a['class']:'';?>">
        <thead>
            <tr>
                <th><?php echo $a['title_column_name'];?></th>
                <?php if ($a['publish_date']): ?>
                    <th><?php _e('Publish date', 'pnty');?></th>
                <?php endif; ?>
                <?php if ($a['organization_name']): ?>
                    <th><?php _e('Organization', 'pnty');?></th>
                <?php endif; ?>
                <?php if ($a['location']): ?>
                    <th><?php _e('Location', 'pnty');?></th>
                <?php endif; ?>
                <?php if ($a['region']): ?>
                    <th><?php _e('Region', 'pnty');?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <?php global $post;?>
        <?php foreach($jobs as $post): setup_postdata($post); ?>
            <?php if($a['excerpt_title']):?>
                <tr title="<?php echo $post->post_excerpt;?>">
                    <td><?php the_title();?></td>
            <?php else:?>
                <tr>
                    <td><?php the_title();?></td>
            <?php endif;?>
                <?php if ($a['publish_date']): ?>
                    <td><?php echo get_the_date('Y-m-d', $post->ID);?></td>
                <?php endif; ?>
                <?php if ($a['organization_name']): ?>
                    <td><?php echo get_post_meta($post->ID, '_pnty_organization_name', true);?></td>
                <?php endif; ?>
                <?php if ($a['location']): ?>
                    <td><?php echo get_post_meta($post->ID, '_pnty_location', true);?></td>
                <?php endif; ?>
                <?php if ($a['region']): ?>
                    <td><?php echo get_post_meta($post->ID, '_pnty_region', true);?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; wp_reset_postdata();?>
    </table>
<?php else: ?>
    <p><?php echo $a['empty_msg'];?></p>
<?php endif; ?>
