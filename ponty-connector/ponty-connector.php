<?php
/*
    Plugin Name: Ponty Connector
    Description: Plugin used to connect Ponty Recruitment System with your site
    Author: KO. Mattsson
    Version: 0.4.6
    Author URI: https://ponty.se
*/

// The name of the custom post type
define('PNTY_PTNAME', 'pnty_job');
define('PNTY_PTNAME_SHOWCASE', 'pnty_job_showcase');

class Pnty_Connector {

    function activate() {
        flush_rewrite_rules();
    }

    function deactivate() {
        // clean up after our selves
        global $wp_post_types;
        if (isset($wp_post_types[PNTY_PTNAME])) {
            unset($wp_post_types[PNTY_PTNAME]);
        }
        delete_option('pnty_api_key');
        delete_option('pnty_slug');
        delete_option('pnty_slug_showcase');
        delete_option('pnty_lang');
        delete_option('pnty_extcss');
        delete_option('pnty_ogtag');
        delete_option('pnty_show_excerpt');
        delete_option('pnty_share');
        flush_rewrite_rules();
    }

    function init() {
        add_action('parse_request', array($this, 'api'));
        add_action('wp_head', array($this, 'og_tags'));

        add_filter('load_textdomain_mofile', array($this, 'override_lang'), 10, 2);
        add_filter('post_type_link', array($this, 'pnty_post_type_link'), 10, 3);
        // priority 100 on the_content filter to behave well with career site
        add_filter('the_content', array($this, 'apply_btn_and_logo'), 100);
    }

    function localize() {
        load_plugin_textdomain('pnty', false, dirname(plugin_basename(__FILE__)) . '/lang');
    }

    function override_lang($mofile, $domain) {
        $pnty_lang = get_option('pnty_lang');
        if ($domain === 'pnty') {
            return plugin_dir_path(__FILE__).'/lang/pnty-'.$pnty_lang.'.mo';
        }
        return $mofile;
    }

    function og_tags(){
        $pnty_ogtag = get_option('pnty_ogtag');
        if (is_singular(PNTY_PTNAME) and $pnty_ogtag) {
            global $post;
            include(plugin_dir_path(__FILE__).'snippets/pnty-og-tags.php');
        }
    }

    function apply_btn_and_logo($content) {
        if (is_singular(PNTY_PTNAME)) {
            global $post;
            $pnty_applybtn_position = get_option('pnty_applybtn_position');
            $pnty_extcss = get_option('pnty_extcss');
            $pnty_show_excerpt = get_option('pnty_show_excerpt');
            $pnty_share = get_option('pnty_share');
            if ( ! is_null($pnty_extcss) && ! empty($pnty_extcss)){
                $content = $content.'<link rel="stylesheet" href="'.$pnty_extcss.'" />';
            }
            if ($pnty_show_excerpt){
                $content = '<div class="pnty-excerpt">'.$post->post_excerpt.'</div>'
                    .PHP_EOL.$content;
            }
            $logo = get_post_meta($post->ID, '_pnty_logo', true);
            if ($logo !== '') {
                $content = '<img class="pnty-logo" src="'.$logo.'" alt="Logo" />'.$content;
            }
            $apply_btn = get_post_meta($post->ID, '_pnty_apply_btn', true);
            if ($apply_btn !== '') {
                if (in_array($pnty_applybtn_position, array('01', ''))) {
                    $content = $content.$apply_btn;
                } elseif ($pnty_applybtn_position == '10') {
                    $content = $apply_btn.$content;
                } elseif ($pnty_applybtn_position == '11') {
                    $content = $apply_btn.$content.$apply_btn;
                }
            }
            if ($pnty_share){
                ob_start();
                include(plugin_dir_path(__FILE__).'style.css.php');
                $pnty_share_css = ob_get_clean();
                $pnty_share_css = trim(preg_replace('/\s+/', '', $pnty_share_css));
                $content = "<style>".$pnty_share_css."</style>".$content;

                ob_start();
                include(plugin_dir_path(__FILE__).'snippets/pnty-share.php');
                $pnty_share_markup = ob_get_clean();
                $content = $content.PHP_EOL.$pnty_share_markup;
            }
            $content = '<div class="pnty-single-job">'.$content.'</div>';
        }
        return $content;
    }

    function create_post_type() {
        $tag_labels = array(
            'name' => __('Ponty job tags', 'pnty')
        );
        register_taxonomy(
            PNTY_PTNAME.'_tag',
            array(PNTY_PTNAME),
            array('labels' => $tag_labels, 'hierarchical' => false, 'public' => false)
        );

        $labels = array(
            'name' => __('Ponty jobs', 'pnty'),
            'singular_name' => __('Ponty job', 'pnty')
        );

        $job_args = array(
            'description' => __('Ponty jobs', 'pnty'),
            'public' => false,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => false,
            'rewrite' => array(
                'slug' => '',
                'with_front' => false

            ),
            'taxonomies' => array(PNTY_PTNAME.'_tag'),
            'labels' => $labels,
            'supports' => array('thumbnail')
        );

        // is the slug set? in that case, overwrite default
        $pnty_slug = get_option('pnty_slug');
        if ($pnty_slug !== 'jobs' and strlen($pnty_slug) > 0) {
            $job_args['rewrite']['slug'] = $pnty_slug;
        }

        register_post_type(PNTY_PTNAME, $job_args);
    }

    function create_post_type_showcase() {
        $showcase_args = array(
            'description' => __('Terminated Ponty jobs', 'pnty'),
            'public' => false,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => false,
            'rewrite' => array(
                'slug' => '',
                'with_front' => false

            ),
            'taxonomies' => array(PNTY_PTNAME.'_tag'),
            'labels' => array(
                'name' => __('Terminated Ponty jobs', 'pnty'),
                'singular_name' => __('Terminated Ponty job', 'pnty')
            )
        );
        // is the slug set? in that case, overwrite default
        $pnty_slug_showcase = get_option('pnty_slug_showcase');
        if ($pnty_slug_showcase !== 'jobs' and strlen($pnty_slug_showcase) > 0) {
            $showcase_args['rewrite']['slug'] = $pnty_slug_showcase;
        }
        register_post_type(PNTY_PTNAME_SHOWCASE, $showcase_args);
    }

    function api_auth() {
        $pnty_api_key = get_option('pnty_api_key');
        if ($pnty_api_key === '' || $_SERVER['HTTP_X_PNTY_AUTH'] !== $pnty_api_key) {
            $this->api_fail('Not authenticated.');
        }
        return true;
    }

    function api_fail($msg) {
        print json_encode(array('success' => false, 'message' => $msg));
        die();
    }

    function api() {
        global $wpdb;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' and
            strpos($_SERVER['REQUEST_URI'], 'pnty_jobs_api') !== false) {

            header('content-type:application/json');

            $this->api_auth();

            if ( ! $data = json_decode(file_get_contents('php://input'))) {
                $this->api_fail('Could not understand that.');
            }

            if (is_null($data->assignment_id)) {
                $this->api_fail('Wont do that without an assignment id :(.');
            }

            // set up post
            $post = array(
                'post_title'    => $data->title,
                'post_name'     => $data->assignment_id.'-'.$data->slug,
                'post_excerpt'  => $data->excerpt,
                'post_content'  => $data->body,
                'post_date'     => $data->publish_date,
                'post_date_gmt' => $data->publish_date,
                'post_status'   => 'publish',
                'post_type'     => ($data->showcase) ? PNTY_PTNAME_SHOWCASE : PNTY_PTNAME
            );

            // does the job exist?
            $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta
                WHERE meta_key = '_pnty_assignment_id' AND meta_value = %s",
                $data->assignment_id);
            $post_id = $wpdb->get_var($query);
            // create or update
            if (is_null($post_id)) {
                $post_id = wp_insert_post($post);
            } else {
                $post['ID'] = $post_id;
                $post_id = wp_update_post($post);
            }
            // if WP failed...
            if (is_null($post_id) or $post_id === 0) {
                $this->api_fail('WordPress could not create job.');
            }

            $std_keys = array(
                '_pnty_assignment_id',
                '_pnty_organization_name',
                '_pnty_name',
                '_pnty_user_title',
                '_pnty_phone',
                '_pnty_email',
                '_pnty_location',
                '_pnty_region',
                '_pnty_client_contact',
                '_pnty_logo',
                '_pnty_apply_btn',
                '_wp_old_slug'
            );

            // remove lingering custom data
            foreach($std_keys as $c) {
                delete_post_meta($post_id, $c);
            }

            if ( ! empty($data->tags_2)) {
                $clean_tags = array();
                foreach($data->tags_2 as $t) {
                    if (strpos($t, '_wp_') === 0) {
                        $parts = explode('_', $t);
                        if ( ! empty($parts[3])) {
                            update_post_meta($post_id, '_pnty_'.$parts[2], $parts[3]);
                        }
                    } else {
                        $clean_tags[] = $t;
                    }
                }
                wp_set_post_terms($post_id, $clean_tags, PNTY_PTNAME.'_tag');
            } else {
                wp_set_post_terms($post_id, NULL, PNTY_PTNAME.'_tag');
            }

            update_post_meta($post_id, '_pnty_assignment_id', $data->assignment_id);
            if (isset($data->organization_name))
                update_post_meta($post_id, '_pnty_organization_name', $data->organization_name);
            if (isset($data->name))
                update_post_meta($post_id, '_pnty_name', $data->name);
            if (isset($data->user_title))
                update_post_meta($post_id, '_pnty_user_title', $data->user_title);
            if (isset($data->phone))
                update_post_meta($post_id, '_pnty_phone', $data->phone);
            if (isset($data->email))
                update_post_meta($post_id, '_pnty_email', $data->email);
            if (isset($data->location))
                update_post_meta($post_id, '_pnty_location', $data->location);
            if (isset($data->region))
                update_post_meta($post_id, '_pnty_region', $data->region);
            if (isset($data->address))
                update_post_meta($post_id, '_pnty_address', $data->address);
            if (isset($data->client_contact))
                update_post_meta($post_id, '_pnty_client_contact', json_encode($data->client_contact));
            if (isset($data->logo))
                update_post_meta($post_id, '_pnty_logo', $data->logo);
            else
                delete_post_meta($post_id, '_pnty_logo');
            if ( ! is_null($data->apply_btn))
                update_post_meta($post_id, '_pnty_apply_btn', $data->apply_btn);

            print json_encode(array('success'=>true, 'url'=>get_permalink($post_id)));
            die();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' and
            strpos($_SERVER['REQUEST_URI'], 'pnty_jobs_api') !== false) {

            header('content-type:application/json');

            $this->api_auth();

            $assignment_id = preg_replace('#.*pnty_jobs_api/(\d+)$#', '$1', $_SERVER['REQUEST_URI']);
            if ( ! $assignment_id) {
                $this->api_fail('Can not help you without an assignment id.');
            }

            $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta
                WHERE meta_key = '_pnty_assignment_id' AND meta_value = %s",
                $assignment_id);
            $post_id = $wpdb->get_var($query);

            if (wp_delete_post($post_id) === false) {
                $this->api_fail('WP could not delete job.');
            }
            print json_encode(array('success'=>true));
            die();
        }
    }
    function pnty_post_type_link($permalink, $post, $leavename) {
        $pnty_slug = get_option('pnty_slug');
        $pnty_slug_showcase = get_option('pnty_slug_showcase');
        if ( ! gettype($post) == 'post') {
            return $permalink;
        }
        if ($post->post_type === PNTY_PTNAME && $pnty_slug === '') {
            $permalink = get_home_url() . '/' . $post->post_name . '/';
        }
        if ($post->post_type === PNTY_PTNAME_SHOWCASE && $pnty_slug_showcase === '') {
            $permalink = get_home_url() . '/' . $post->post_name . '/';
        }
        return $permalink;
    }
}

add_action('admin_init', 'pnty_admin_init');
function pnty_admin_init(){
    if (delete_transient('pnty_slug_saved')) flush_rewrite_rules();
    add_option('pnty_api_key', '');
    register_setting('pnty_options', 'pnty_api_key');
    add_option('pnty_slug', PNTY_PTNAME);
    register_setting('pnty_options', 'pnty_slug', 'pnty_slug_save');
    add_option('pnty_slug_showcase', PNTY_PTNAME_SHOWCASE);
    register_setting('pnty_options', 'pnty_slug_showcase', 'pnty_slug_save');
    add_option('pnty_lang', 'en_US');
    register_setting('pnty_options', 'pnty_lang');
    add_option('pnty_extcss', null);
    register_setting('pnty_options', 'pnty_extcss');
    add_option('pnty_ogtag', false);
    register_setting('pnty_options', 'pnty_ogtag');
    add_option('pnty_show_excerpt', false);
    register_setting('pnty_options', 'pnty_show_excerpt');
    add_option('pnty_share', false);
    register_setting('pnty_options', 'pnty_share');
    add_option('pnty_applybtn_position', '01');
    register_setting('pnty_options', 'pnty_applybtn_position');
}
function pnty_slug_save($input) {
    set_transient('pnty_slug_saved', 'saved');
    return sanitize_title_with_dashes($input);
}

add_action('admin_menu', 'pnty_menu');
function pnty_menu() {
    add_options_page('Ponty Connector', 'Ponty Connector', 'manage_options', 'pnty-options', 'pnty_connector_opts_page');
}
function pnty_connector_opts_page() {
    include(plugin_dir_path(__FILE__).'/settings-page.php');
}

add_shortcode('pnty_jobs_table', function($atts) {
    extract(shortcode_atts(array(
        'title_column_name' => __('Title', 'pnty'),
        'organization_name' => false,
        'publish_date' => true,
        'location' => false,
        'region' => false,
        'numberposts' => -1,
        'link_all' => false,
        'tag' => false,
        'class' => false,
        'excerpt_title' => false,
        'empty_msg' => __('No published jobs.', 'pnty')
    ), $atts));
    load_plugin_textdomain('pnty', false, plugin_dir_path(__FILE__) . 'lang');
    ob_start();
    include(plugin_dir_path(__FILE__).'snippets/pnty-table.php');
    return ob_get_clean();
});

add_shortcode('pnty_showcase_table', function($atts) {
    extract(shortcode_atts(array(
        'title_column_name' => __('Title', 'pnty'),
        'organization_name' => false,
        'publish_date' => true,
        'location' => false,
        'region' => false,
        'numberposts' => -1,
        'link_all' => false,
        'tag' => false,
        'class' => false,
        'excerpt_title' => false,
        'empty_msg' => __('No published jobs.', 'pnty')
    ), $atts));
    load_plugin_textdomain('pnty', false, plugin_dir_path(__FILE__) . 'lang');
    ob_start();
    include(plugin_dir_path(__FILE__).'snippets/pnty-table-showcase.php');
    return ob_get_clean();
});

add_shortcode('pnty_jobs_list', function($atts) {
    extract(shortcode_atts(array(
        'organization_name' => false,
        'excerpt' => false,
        'logo' => false,
        'logo_width' => 150,
        'readmore' => false,
        'numberposts' => -1,
        'tag' => false,
        'class' => false,
        'empty_msg' => __('No published jobs.', 'pnty')
    ), $atts));
    load_plugin_textdomain('pnty', false, plugin_dir_path(__FILE__) . 'lang');
    ob_start();
    include(plugin_dir_path(__FILE__).'snippets/pnty-list.php');
    return ob_get_clean();
});

add_shortcode('pnty_showcase_list', function($atts) {
    extract(shortcode_atts(array(
        'organization_name' => false,
        'excerpt' => false,
        'logo' => false,
        'logo_width' => 150,
        'readmore' => false,
        'numberposts' => -1,
        'tag' => false,
        'class' => false,
        'empty_msg' => __('No published jobs.', 'pnty')
    ), $atts));
    load_plugin_textdomain('pnty', false, plugin_dir_path(__FILE__) . 'lang');
    ob_start();
    include(plugin_dir_path(__FILE__).'snippets/pnty-list-showcase.php');
    return ob_get_clean();
});

add_shortcode('pnty_apply_btn', function($atts){
    extract(shortcode_atts(array(
        'assignment_id' => false,
        'title' => __('Apply here', 'pnty'),
        'org' => false,
        'lang' => 'en',
        'color' => false,
        'require_files' => false,
        'require_role' => false,
        'require_gender' => false,
        'require_birthyear' => false
    ), $atts, 'pnty_apply_btn'));
    if ( ! $org or ! $assignment_id) {
        return __('Shortcode not setup correctly.', 'pnty');
    }
    load_plugin_textdomain('pnty', false, plugin_dir_path(__FILE__) . 'lang');
    ob_start();
    include(plugin_dir_path(__FILE__).'snippets/pnty-apply-btn.php');
    return ob_get_clean();
});

$pnty_connector = new Pnty_Connector();
register_activation_hook(__FILE__, array($pnty_connector, 'activate'));
register_deactivation_hook(__FILE__, array($pnty_connector, 'deactivate'));

add_action('init', array($pnty_connector, 'init'));
add_action('init', array($pnty_connector, 'localize'));
add_action('init', array($pnty_connector, 'create_post_type'));
add_action('init', array($pnty_connector, 'create_post_type_showcase'));

// widget registration
require_once(plugin_dir_path(__FILE__).'widgets/pnty-latest-jobs.php');
add_action('widgets_init', create_function('', 'return register_widget("pnty_latest_jobs_widget");'));
