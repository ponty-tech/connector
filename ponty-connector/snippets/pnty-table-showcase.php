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
?>
<?php if (count($jobs) > 0):?>
    <table class="pnty-table<?php echo ($class)?' '.$class:'';?>">
        <thead>
            <tr>
                <th><?php _e('Title', 'pnty');?></th>
                <?php if ($publish_date): ?>
                    <th><?php _e('Publish date', 'pnty');?></th>
                <?php endif; ?>
                <?php if ($organization_name): ?>
                    <th><?php _e('Organization', 'pnty');?></th>
                <?php endif; ?>
                <?php if ($location): ?>
                    <th><?php _e('Location', 'pnty');?></th>
                <?php endif; ?>
                <?php if ($region): ?>
                    <th><?php _e('Region', 'pnty');?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <?php global $post;?>
        <?php foreach($jobs as $post): setup_postdata($post); ?>
            <?php if($excerpt_title):?>
                <tr title="<?php echo $post->post_excerpt;?>">
                    <td><a href="<?php the_permalink();?>"><?php the_title();?></a></td>
            <?php else:?>
                <tr>
                    <td><a title="<?php _e('Permalink for', 'pnty');?> <?php the_title();?>" href="<?php the_permalink();?>"><?php the_title();?></a></td>
            <?php endif;?>
                <?php if($link_all) :?>
                    <?php if ($publish_date): ?>
                        <td><a href="<?php the_permalink();?>"><?php echo get_the_date('Y-m-d', $post->ID);?></a></td>
                    <?php endif; ?>
                    <?php if ($organization_name): ?>
                        <td><a href="<?php the_permalink();?>"><?php echo get_post_meta($post->ID, '_pnty_organization_name', true);?></a></td>
                    <?php endif; ?>
                    <?php if ($location): ?>
                        <td><a href="<?php the_permalink();?>"><?php echo get_post_meta($post->ID, '_pnty_location', true);?></a></td>
                    <?php endif; ?>
                    <?php if ($region): ?>
                        <td><a href="<?php the_permalink();?>"><?php echo get_post_meta($post->ID, '_pnty_region', true);?></a></td>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($publish_date): ?>
                        <td><?php echo get_the_date('Y-m-d', $post->ID);?></td>
                    <?php endif; ?>
                    <?php if ($organization_name): ?>
                        <td><?php echo get_post_meta($post->ID, '_pnty_organization_name', true);?></td>
                    <?php endif; ?>
                    <?php if ($location): ?>
                        <td><?php echo get_post_meta($post->ID, '_pnty_location', true);?></td>
                    <?php endif; ?>
                    <?php if ($region): ?>
                        <td><?php echo get_post_meta($post->ID, '_pnty_region', true);?></td>
                    <?php endif; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach;?>
    </table>
<?php else: ?>
    <p><?php _e('No published jobs.', 'pnty');?> </p>
<?php endif; ?>
