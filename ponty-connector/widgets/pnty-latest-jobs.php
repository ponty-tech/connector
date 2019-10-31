<?php

class pnty_latest_jobs_widget extends WP_Widget {
    // Ordnar oss en fin lista med de senaste jobben.
    function __construct() {
        $widget_ops = array(
            'classname' => 'latest-assignments',
            'description' => __('Latest Ponty jobs', 'pnty')
        );
        parent::__construct('pnty_latest_jobs', __('Ponty jobs'), $widget_ops);
    }

    function widget($args, $instance) {
        global $wpdb;
        extract($args, EXTR_SKIP);
        $title = apply_filters('widget_title', $instance['title']);
        $href = empty($instance['href']) ? '' : $instance['href'];
        $job_count = empty($instance['job_count']) ? '10' : $instance['job_count'];
        $job_tag = get_option($widget_id);
        $show_count = $instance['show_count'];
        $show_organization = $instance['show_organization'];

        $query = array(
            'post_type' => 'pnty_job',
            'has_password' => false,
            'numberposts' => $job_count
        );
        if ( ! empty($job_tag)) {
            $tax_query = array(
                'relation' => 'OR',
            );
            $sub_query = array(
                'taxonomy' => 'pnty_job_tag',
                'field' => 'slug',
                'terms' => array()
            );
            foreach($job_tag as $tag) {
                $sub_query['terms'][] = $tag;
            }
            $tax_query[] = $sub_query;
            $query['tax_query'] = $tax_query;
        }
        $jobs = get_posts($query);

        if ($show_count) {
            $count = $wpdb->get_var("SELECT COUNT(*) AS `Antal` FROM $wpdb->posts WHERE post_type = 'pnty_job'");
        } else {
            $count = 0;
        }
?>
    <?php echo $before_widget.$before_title;?><?php echo $title;?><?php echo $after_title;?>
    <?php $x=0;?>
        <ul class="pnty-latest-jobs-widget">
        <?php foreach($jobs as $job) :?>
            <?php $organization_name = get_post_meta($job->ID, '_pnty_organization_name', true);?>
            <?php $zebra = ($x % 2 == 0) ? 'even' : 'odd';?>
            <li class="<?php echo $zebra;?>">
                <a title="<?php echo $job->post_title;?>" href="<?php echo get_permalink($job->ID);?>"><?php echo $job->post_title;?></a>
                <?php if ($show_organization):?>
                    <br /><span class="pnty-organization-name"><?php echo $organization_name;?></span>
                <?php endif;?>
            </li>
            <?php $x++;?>
        <?php endforeach;?>
        <?php if ($show_count && $count > $job_count) : ?>
            <li class="pnty-latest-jobs-widget-last-li">
                <a href="<?php echo get_bloginfo('url').'/'.$href;?>"><?php echo sprintf(__('Show all (%d)'), $count);?> &raquo;</a>
            </li>
        <?php endif;?>
        </ul>
        <?php echo $after_widget;?>
<?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['job_count'] = strip_tags($new_instance['job_count']);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['href'] = strip_tags($new_instance['href']);
        update_option($_POST['id_base'].'-'.$_POST['widget_number'], $new_instance['job_tag']);
        $instance['show_count'] = ($new_instance['show_count']) ? true: false;
        $instance['show_organization'] = ($new_instance['show_organization']) ? true: false;
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array('job_count'=>'10') );
        $job_count = $instance['job_count'];
        $title = $instance['title'];
        $href = $instance['href'];
        $show_count = $instance['show_count'];
        $show_organization = $instance['show_organization'];
        $terms = get_terms('pnty_job_tag');
        $job_tag = get_option($this->id);
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'pnty');?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('href'); ?>"><?php _e('Url to all jobs', 'pnty');?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('href'); ?>" name="<?php echo $this->get_field_name('href'); ?>" type="text" value="<?php echo attribute_escape($href); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('job_count'); ?>"><?php _e('Number to show', 'pnty');?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('job_count'); ?>" name="<?php echo $this->get_field_name('job_count'); ?>" type="text" value="<?php echo attribute_escape($job_count); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('job_tag'); ?>"><?php _e('Has tag', 'pnty');?></label>
        <select class="widefat" style="height:100px;" size="5" id="<?php echo $this->get_field_id('job_tag'); ?>" name="<?php echo $this->get_field_name('job_tag'); ?>[]" multiple="multiple">
            <?php foreach($terms as $term) : ?>
                <?php if (in_array($term->slug, $job_tag)) : ?>
                    <option value="<?php echo $term->slug; ?>" selected="selected"><?php echo $term->name; ?></option>
                <?php else : ?>
                    <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('show_count'); ?>">
                <input class="widefat" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="checkbox" <?php echo ($show_count) ? 'checked="checked"': ''; ?>" />
                <?php _e('Show total jobs count', 'pnty');?>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('show_organization'); ?>">
                <input class="widefat" id="<?php echo $this->get_field_id('show_organization'); ?>" name="<?php echo $this->get_field_name('show_organization'); ?>" type="checkbox" <?php echo ($show_organization) ? 'checked="checked"': ''; ?>" />
                <?php _e('Show organization name', 'pnty');?>
            </label>
        </p>
<?php
    }
}
