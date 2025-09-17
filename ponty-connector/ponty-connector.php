<?php
/*
    Plugin Name: Ponty Connector
    Description: Plugin used to connect Ponty Recruitment System with your site. With contributions from Andreas Lagerkvist and Pål Martin Bakken.
    Author: KO. Mattsson
    Version: 1.0.13
    Author URI: https://ponty.se
*/
# The name of the custom post types
define('PNTY_VERSION', '1.0.13');
define('PNTY_PTNAME', 'pnty_job');
define('PNTY_PTNAME_SHOWCASE', 'pnty_job_showcase');

class Pnty_Connector {

    function activate() {
        flush_rewrite_rules();
    }

    function deactivate() {
        # clean up after our selves
        global $wp_post_types;
        if (isset($wp_post_types[PNTY_PTNAME])) {
            unset($wp_post_types[PNTY_PTNAME]);
        }
        delete_option('pnty_api_key');
        delete_option('pnty_remove_archive');
        delete_option('pnty_slug');
        delete_option('pnty_show_ui');
        delete_option('pnty_remove_showcase_archive');
        delete_option('pnty_slug_showcase');
        delete_option('pnty_show_terminated_ui');
        delete_option('pnty_extcss');
        delete_option('pnty_ogtag');
        delete_option('pnty_jsonld');
        delete_option('pnty_show_excerpt');
        delete_option('pnty_share');
        delete_option('pnty_webhook_urls');
        flush_rewrite_rules();
    }

    function init() {
        add_action('parse_request', array($this, 'api'));
        add_action('wp_head', array($this, 'og_tags'));
        add_action('wp_footer', array($this, 'json_ld'));

        add_filter('post_type_link', array($this, 'pnty_post_type_link'), 10, 3);
        # priority 100 on the_content filter to behave well with career site
        add_filter('the_content', array($this, 'apply_btn_and_logo'), 100);
    }

    function localize() {
        load_plugin_textdomain('pnty', false, dirname(plugin_basename(__FILE__)) . '/lang');
    }

    function og_tags(){
        $pnty_ogtag = get_option('pnty_ogtag');
        if (is_singular(PNTY_PTNAME) and $pnty_ogtag) {
            global $post;
            include(plugin_dir_path(__FILE__).'snippets/pnty-og-tags.php');
        }
    }

    function json_ld(){
        $pnty_jsonld = get_option('pnty_jsonld');
        if (is_singular(PNTY_PTNAME) and $pnty_jsonld) {
            global $post;
            include(plugin_dir_path(__FILE__).'snippets/pnty-json-ld.php');
        }
    }

    function apply_btn_and_logo($content) {
        if (is_singular(PNTY_PTNAME)) {
            # let the user override our single job view
            global $wp_filter;
            if (array_key_exists('pnty_single_job_filter', $wp_filter) &&
                ! is_null($wp_filter['pnty_single_job_filter'])) {
                return apply_filters('pnty_single_job_filter', $content);
            }

            global $post;
            $pnty_applybtn_position = get_option('pnty_applybtn_position');
            $pnty_extcss = get_option('pnty_extcss');
            $pnty_show_excerpt = get_option('pnty_show_excerpt');
            $pnty_share = get_option('pnty_share');
            if ( ! is_null($pnty_extcss) && ! empty($pnty_extcss)){
                $d = new DOMDocument();
                $link = $d->createElement('link');
                $link->setAttribute('rel', 'stylesheet');
                $link->setAttribute('href', $pnty_extcss);
                $d->appendChild($link);
                $content = $content . $d->saveHTML();
            }
            if ($pnty_show_excerpt){
                $d = new DOMDocument();
                $div = $d->createElement('div', $post->post_excerpt);
                $div->setAttribute('class', 'pnty-excerpt');
                $d->appendChild($div);
                $content = $d->saveHTML() . $content;
            }

            # Get post metadata
            $metadata = get_post_custom($post->ID);
            # assign the values we need
            $logo_attachment_id = $metadata['_pnty_logo_attachment_id'][0] ?? null;
            $logo = $metadata['_pnty_logo'][0] ?? null;

            if ( ! is_null($logo_attachment_id)) {
                list($logo_url, $logo_width, $logo_height) =
                    wp_get_attachment_image_src($logo_attachment_id, 'pnty_logo');
                $d = new DOMDocument();
                $img = $d->createElement('img');
                $img->setAttribute('class', 'pnty-logo');
                $img->setAttribute('src', $logo_url);
                $img->setAttribute('width', $logo_width);
                # not working responsive? FIXME?
                #$img->setAttribute('height', $logo_height);
                $img->setAttribute('alt', __('Client logotype', 'pnty'));
                $d->appendChild($img);
                $content = $d->saveHTML() . $content;
            } else if ( ! is_null($logo)) {
                $d = new DOMDocument();
                $img = $d->createElement('img');
                $img->setAttribute('class', 'pnty-logo');
                $img->setAttribute('src', $logo);
                $img->setAttribute('alt', __('Client logotype', 'pnty'));
                $d->appendChild($img);
                $content = $d->saveHTML() . $content;
            }
            $apply_btn = $metadata['_pnty_apply_btn'][0] ?? '';
            if ($apply_btn !== '') {
                if (in_array($pnty_applybtn_position, array('01', ''))) {
                    $content = $content . $apply_btn;
                } elseif ($pnty_applybtn_position == '10') {
                    $content = $apply_btn . $content;
                } elseif ($pnty_applybtn_position == '11') {
                    $content = $apply_btn . $content . $apply_btn;
                }
            }
            if ($pnty_share){
                ob_start();
                include(plugin_dir_path(__FILE__).'style.css.php');
                $pnty_share_css = ob_get_clean();
                $pnty_share_css = trim(preg_replace('/\s+/', '', $pnty_share_css));
                $d = new DOMDocument();
                $style = $d->createElement('style', $pnty_share_css);
                $d->appendChild($style);
                $content = $d->saveHTML() . $content;

                ob_start();
                include(plugin_dir_path(__FILE__).'snippets/pnty-share.php');
                $pnty_share_markup = ob_get_clean();
                $content = $content . PHP_EOL . $pnty_share_markup;
            }
            $content = '<div class="pnty-single-job">' . PHP_EOL . $content . PHP_EOL . '</div>';
        }
        return $content;
    }

    function create_post_type() {
        $show_ui = (bool) (get_option('pnty_show_ui') ?? false);

        $tag_labels = array(
            'name' => __('Ponty job tags', 'pnty')
        );
        register_taxonomy(
            PNTY_PTNAME.'_tag',
            array(PNTY_PTNAME),
            array(
                'labels' => $tag_labels,
                'hierarchical' => false,
                'public' => false
            )
        );

        $labels = array(
            'name' => __('Ponty jobs', 'pnty'),
            'singular_name' => __('Ponty job', 'pnty')
        );

        $remove_archive = (bool) (get_option('pnty_remove_archive') ?? false);

        $job_args = array(
            'description' => __('Ponty jobs', 'pnty'),
            'public' => false,
            'publicly_queryable' => true,
            'show_in_rest' => true,
            'exclude_from_search' => false,
            'has_archive' => !$remove_archive,
            'show_ui' => $show_ui,
            'rewrite' => array(
                'slug' => 'jobs',
                'with_front' => false
            ),
            'taxonomies' => array(PNTY_PTNAME.'_tag'),
            'labels' => $labels,
            'supports' => array('thumbnail')
        );

        # is the slug set? in that case, overwrite default
        $pnty_slug = get_option('pnty_slug');
        if ($pnty_slug !== 'jobs' and strlen($pnty_slug) > 0) {
            $job_args['rewrite']['slug'] = $pnty_slug;
        }

        register_post_type(PNTY_PTNAME, $job_args);
    }

    
    function create_post_type_showcase() {
        $remove_showcase_archive = (bool) (get_option('pnty_remove_showcase_archive') ?? false);
        $show_terminated_ui = (bool) (get_option('pnty_show_terminated_ui') ?? false);

        $showcase_args = array(
            'description' => __('Terminated Ponty jobs', 'pnty'),
            'public' => false,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => !$remove_showcase_archive,
            'show_ui' => $show_terminated_ui,
            'rewrite' => array(
                'slug' => 'showcase-jobs',
                'with_front' => false
            ),
            'taxonomies' => array(PNTY_PTNAME.'_tag'),
            'labels' => array(
                'name' => __('Terminated Ponty jobs', 'pnty'),
                'singular_name' => __('Terminated Ponty job', 'pnty')
            )
        );
        # is the slug set? in that case, overwrite default
        $pnty_slug_showcase = get_option('pnty_slug_showcase');
        if ($pnty_slug_showcase !== 'jobs' and strlen($pnty_slug_showcase) > 0) {
            $showcase_args['rewrite']['slug'] = $pnty_slug_showcase;
        }
        register_post_type(PNTY_PTNAME_SHOWCASE, $showcase_args);
    }

    function api_auth() {
        $pnty_api_key = get_option('pnty_api_key');
        if ($pnty_api_key === '' || ! isset($_SERVER['HTTP_X_PNTY_AUTH_2'])) {
            $this->api_fail('Not authenticated to WordPress instance. Please check API keys.');
        }

        $jwt_str = str_replace('Bearer ', '', $_SERVER['HTTP_X_PNTY_AUTH_2']);

        list($jwt_header, $jwt_payload, $jwt_sig) = explode('.', $jwt_str);

        $header_and_payload = $jwt_header.'.'.$jwt_payload;
        $almost_real_sig = base64_encode(
            hash_hmac('sha256', $header_and_payload, $pnty_api_key, true)
        );
        # make some "urlsafe" replacements
        $real_sig = str_replace(['+','/','='], ['-','_',''], $almost_real_sig);

        $payload = json_decode(base64_decode($jwt_payload));
        $now = new DateTime();
        $ts = $now->getTimestamp();
        if ($ts - $payload->iat > 60) {
            $this->api_fail('Not authenticated to WordPress instance. Please check API keys.');
        }

        if ($ts > $payload->exp) {
            $this->api_fail('Not authenticated to WordPress instance. Please check API keys.');
        }

        if ($jwt_sig !== $real_sig){
            $this->api_fail('Not authenticated to WordPress instance. Please check API keys.');
        }

        return true;
    }

    function api_fail($msg) {
        print json_encode(array('success' => false, 'message' => $msg));
        die();
    }

    function api() {
        global $wpdb;
        # return version number after 1.0.0
        if ($_SERVER['REQUEST_METHOD'] === 'GET' and
            strpos($_SERVER['REQUEST_URI'], 'pnty_version') !== false) {
            header('content-type:application/json');
            print json_encode(['version'=>PNTY_VERSION]);
            die();
        } elseif (strpos($_SERVER['REQUEST_URI'], 'pnty_ads') !== false) {
            header('content-type:application/json');
            $posts = get_posts([
                'post_type' => ['pnty_job', 'pnty_job_showcase']
            ]);
            $res = [];
            if($posts) {
                foreach ($posts as $post) {
                    $assignment_id = get_post_meta($post->ID,'_pnty_assignment_id', true);
                    if($assignment_id){
                        $unique_id = get_post_meta($post->ID,'_pnty_unique_id', true);
                        $res[$post->post_type] = ['assignmentId' => $assignment_id, 'uniqueId' => $unique_id, 'postModified' => $post->post_modified];
                    }
                }                    
            }
            print json_encode($res, JSON_PRETTY_PRINT);
            die();            
        }

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

            $is_new_ad = false;

            # set up post
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

            # is this going to be password protected?
            if (isset($data->ad_password) && $data->ad_password) {
                $post['post_password'] = $data->ad_password;
            } else {
                $post['post_password'] = null;
            }

            # does the job exist?
            if ( ! is_null($data->system_slug)) {
                $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta
                    WHERE meta_key = '_pnty_unique_id' AND meta_value = %s",
                    $data->system_slug . $data->assignment_id);
            } else {
                # for backwards compatibility, only check assignment id
                $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta
                    WHERE meta_key = '_pnty_assignment_id' AND meta_value = %s",
                    $data->assignment_id);
            }
            $post_id = $wpdb->get_var($query);
            # create or update
            if (is_null($post_id)) {
                if ( ! $data->showcase) {
                    # It's a new ad only if it's an ad. Not showcase content.
                    $is_new_ad = true;
                }
                $post_id = wp_insert_post($post);
            } else {
                $post['ID'] = $post_id;
                $post_id = wp_update_post($post);
            }
            # if WP failed...
            if (is_null($post_id) or $post_id === 0) {
                $this->api_fail('WordPress could not create job.');
            }

            // needed for hooks
            $data->ponty_post_id = $post_id;

            $std_keys = array(
                '_pnty_address',
                '_pnty_apply_btn',
                '_pnty_assignment_id',
                '_pnty_client_contact',
                '_pnty_email',
                '_pnty_hero_image',
                '_pnty_region',
                '_pnty_location',
                '_pnty_confidential',
                '_pnty_logo',
                '_pnty_name',
                '_pnty_organization_name',
                '_pnty_phone',
                '_pnty_system_slug',
                '_pnty_unique_id',
                '_pnty_user_title',
                '_pnty_withdrawal_date',
                '_pnty_external_apply_url',
                '_pnty_language',
                '_pnty_video_url',
                '_wp_old_slug',
                '_pnty_user_profile_image',
            );

            # remove lingering custom data
            foreach($std_keys as $c) {
                delete_post_meta($post_id, $c);
            }

            # if job exists, remove tags
            if ($post_id) {
                $connected_tags = wp_get_post_terms($post_id, PNTY_PTNAME.'_tag');
                $connected_tags_list = [];
                foreach($connected_tags as $ct) {
                    $connected_tags_list[] = $ct->slug;
                }
                wp_remove_object_terms($post_id, $connected_tags_list, PNTY_PTNAME.'_tag');
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
            update_post_meta($post_id, '_pnty_system_slug', $data->system_slug);
            update_post_meta(
                $post_id,
                '_pnty_unique_id',
                $data->system_slug . $data->assignment_id
            );
            if (isset($data->withdrawal_date))
                update_post_meta($post_id, '_pnty_withdrawal_date', $data->withdrawal_date);
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
            if (isset($data->confidential))
                update_post_meta($post_id, '_pnty_confidential', $data->confidential);
            if (isset($data->external_apply_url))
                update_post_meta($post_id, '_pnty_external_apply_url', $data->external_apply_url);
            if (isset($data->language))
                update_post_meta($post_id, '_pnty_language', $data->language);
            if (isset($data->video_url))
                update_post_meta($post_id, '_pnty_video_url', $data->video_url);
            if (isset($data->user_profile_image))
                update_post_meta($post_id, '_pnty_user_profile_image', $data->user_profile_image);
            if (isset($data->address))
                update_post_meta(
                    $post_id,
                    '_pnty_address',
                    json_encode($data->address, JSON_UNESCAPED_UNICODE)
                );
            if (isset($data->client_contact))
                update_post_meta(
                    $post_id,
                    '_pnty_client_contact',
                    json_encode($data->client_contact, JSON_UNESCAPED_UNICODE)
                );
            if ( ! is_null($data->apply_btn))
                update_post_meta($post_id, '_pnty_apply_btn', $data->apply_btn);

            # special case for logo
            if (isset($data->logo)) {
                update_post_meta($post_id, '_pnty_logo', $data->logo);
                $this->upload_url_image($post_id, $data->logo);
            } else {
                $this->delete_attachment($post_id, '_pnty_logo_attachment_id');
            }

            # and special case for hero
            if (isset($data->hero_image) and $data->hero_image) {
                $this->upload_base64_image($post_id, $data->hero_image);
            } else {
                $this->delete_attachment($post_id, '_thumbnail_id');
            }

            # Does cURL exist and we're posting an ad??
            if (function_exists('curl_version')) {
                # do we have a webhook?
                $webhook_urls = get_option('pnty_webhook_urls');
                if ( ! empty($webhook_urls) && $is_new_ad) {
                    $webhook_data = json_encode(array(
                        'value1' => $data->title,
                        'value2' => get_permalink($post_id)
                    ));
                    $hook_urls = explode(',', $webhook_urls);
                    foreach($hook_urls as $hu) {
                        $ch = curl_init($hu);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $webhook_data);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: '.strlen($webhook_data),
                            'User-Agent: Ponty Connector'
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $res = curl_exec($ch);
                        # TODO felhantering? Kanske en extra json-nyckel webhook, som returneras
                        # till oss? Fundera även på om filhanteringsfel skall returnera felsträng.
                        curl_close($ch);
                    }
                }
            }

            do_action('pnty_action_post_job', $data);

            print json_encode(array('success'=>true, 'url'=>get_permalink($post_id)));
            die();

        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' and
            strpos($_SERVER['REQUEST_URI'], 'pnty_jobs_api') !== false) {

            header('content-type:application/json');

            $this->api_auth();

            $assignment_id = preg_replace(
                '#.*pnty_jobs_api/(\d+)$#',
                '$1',
                $_SERVER['REQUEST_URI']
            );
            if ( ! $assignment_id) {
                $this->api_fail('Can not help you without an assignment id.');
            }
            # >= v1? Check for slug
            $system_slug = isset($_SERVER['HTTP_X_PNTY_SLUG']) ?
                $_SERVER['HTTP_X_PNTY_SLUG'] : false;
            if (defined(PNTY_VERSION) and ! $system_slug) {
                $this->api_fail('Can not help you without a slug.');
            }

            if ($system_slug) {
                $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta
                    WHERE meta_key = '_pnty_unique_id' AND meta_value = %s",
                    $system_slug . $assignment_id);
            } else {
                # for backwards compatibility, only check assignment id
                $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta
                    WHERE meta_key = '_pnty_assignment_id' AND meta_value = %s",
                    $assignment_id);
            }
            $post_id = $wpdb->get_var($query);

            $this->delete_attachment($post_id, '_pnty_logo_attachment_id');
            $this->delete_attachment($post_id, '_thumbnail_id');

            $deleted_post = wp_delete_post($post_id);
            if ($deleted_post === false) {
                $this->api_fail('WP could not delete job.');
            }

            do_action('pnty_action_delete_job', $assignment_id);

            print json_encode(array('success'=>true, 'post'=>$deleted_post));
            die();
        }
    }

    function delete_attachment($post_id, $meta_key) {
        $attachment_id = get_post_meta($post_id, $meta_key, true);
        if ($attachment_id) {
            wp_delete_attachment($attachment_id);
        }
        delete_post_meta($post_id, $meta_key);
    }

    function upload_url_image($post_id, $url) {
        try {
            # Fetch the file data
            $file_data = @file_get_contents($url);
            if ($file_data === false) {
                throw new Exception('Could not fetch file.');
            }

            $current_hash = sha1($file_data);

            # Do we have it already?
            $attachment_id = get_post_meta($post_id, '_pnty_logo_attachment_id', true);
            if ($attachment_id) {
                $filepath = get_attached_file($attachment_id);
                $previous_hash = sha1_file($filepath);
            }
            # Is it the same file?
            if (isset($previous_hash) && $previous_hash === $current_hash) {
                # No further action needed. Bail.
                return;
            } else if (isset($previous_hash)) {
                # We have an existing file but it's not the same file. Remove it.
                wp_delete_attachment($attachment_id);
            }

            # Where to put the file
            $upload_dir = wp_upload_dir();
            $upload_dir = $upload_dir['path'];

            # Break down url
            $url_parts = parse_url($url);
            # Check path for a filename
            $filename_from_ponty = basename($url_parts['path']);

            # Get ext + mime
            $wp_file_info = wp_check_filetype($filename_from_ponty);
            $file_ext = $wp_file_info['ext'];
            $file_mime = $wp_file_info['type'];

            $filename = microtime(true) . '.' . $file_ext;

            # Store the file
            $stored_bytes = @file_put_contents($upload_dir . '/' . $filename, $file_data);
            if ($stored_bytes === false) {
                throw new Exception('Could not save file.');
            }

            # Insert into DB
            $attachment_id = wp_insert_attachment(array(
                'post_mime_type'    => $file_mime,
                'post_title'        => get_the_title($post_id),
                'post_content'      => '',
                'post_name'         => $filename,
                'post_status'       => 'inherit'
            ), $upload_dir . '/' . $filename);

            # Include WP image.php for next methods.
            include_once(ABSPATH.'wp-admin/includes/image.php');
            # Update meta data.
            wp_update_attachment_metadata(
                $attachment_id,
                wp_generate_attachment_metadata($attachment_id, $upload_dir . '/' . $filename)
            );

            update_post_meta($post_id, '_pnty_logo_attachment_id', $attachment_id);

        } catch (Exception $e) {
            error_log($e);
        }
    }

    function upload_base64_image ($post_id, $base64_image) {
        # Adapted from Andreas Lagerkvist
        try {
            # Convert mime to extension
            $mime2ext = [
                'image/gif' => 'gif',
                'image/png' => 'png',
                'image/jpeg' => 'jpg'
            ];

            # Explode the data we need
            $image_data = explode(',', $base64_image);
            $type = $image_data[0];
            $image = base64_decode($image_data[1]);

            $current_hash = sha1($image);

            # Do we have it already?
            $attachment_id = get_post_meta($post_id, '_thumbnail_id', true);
            if ($attachment_id) {
                $filepath = get_attached_file($attachment_id);
                $previous_hash = sha1_file($filepath);
            }
            # Is it the same file?
            if (isset($previous_hash) && $previous_hash === $current_hash) {
                # No further action needed. Bail.
                return;
            } else if (isset($previous_hash)) {
                # We have an existing file but it's not the same file. Remove it.
                wp_delete_attachment($attachment_id);
            }

            # Determine filetype (http://stackoverflow.com/questions/6061505/detecting-image-type-from-base64-string-in-php)
            $f = finfo_open();
            $mime = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
            finfo_close($f);

            # Where to put the file
            $upload_dir = wp_upload_dir();
            $upload_dir = $upload_dir['path'];

            # Create a filename
            $filename = microtime(true) . '.' . $mime2ext[$mime];

            # Upload the file
            $stored_bytes = @file_put_contents($upload_dir . '/' . $filename, $image);
            if ($stored_bytes === false) {
                throw new Exception('Could not save b64 file.');
            }

            # Insert into DB
            $attachment_id = wp_insert_attachment(array(
                'post_mime_type'    => $mime,
                'post_title'        => get_the_title($post_id),
                'post_content'      => '',
                'post_name'         => $filename,
                'post_status'       => 'inherit'
            ), $upload_dir . '/' . $filename);

            # Include WP image.php for next methods.
            include_once(ABSPATH.'wp-admin/includes/image.php');
            # Update meta data.
            wp_update_attachment_metadata(
                $attachment_id,
                wp_generate_attachment_metadata($attachment_id, $upload_dir . '/' . $filename)
            );

            # Set as featured image
            set_post_thumbnail($post_id, $attachment_id);
        } catch (Exception $e) {
            error_log($e);
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

    function add_pnty_image_size(){
        add_image_size('pnty_logo', 500, 500);
    }

}

# used to get_terms for a specific post_typ (pnty_job|pnty_job_showcase)
function pnty_get_active_terms($post_type){
    global $wpdb;
    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT t2.*
            FROM $wpdb->term_taxonomy AS t1
            JOIN $wpdb->terms AS t2 ON t2.term_id = t1.term_id
            WHERE EXISTS (
                SELECT * FROM $wpdb->posts AS u1
                JOIN $wpdb->term_relationships AS u2 ON u2.object_id = u1.ID
                WHERE u2.term_taxonomy_id = t1.term_taxonomy_id
                AND u1.post_type = %s
            )
            AND t1.taxonomy = 'pnty_job_tag'",
            $post_type
        ),
        OBJECT
    );
}

add_action('admin_init', 'pnty_admin_init');
function pnty_admin_init(){
    if (delete_transient('pnty_slug_saved')) flush_rewrite_rules();
    add_option('pnty_api_key', '');
    register_setting('pnty_options', 'pnty_api_key');
    add_option('pnty_remove_archive', false);
    register_setting('pnty_options', 'pnty_remove_archive', 'pnty_slug_save');
    add_option('pnty_slug', 'jobs');
    register_setting('pnty_options', 'pnty_slug', 'pnty_slug_save');
    add_option('pnty_show_ui', false);
    register_setting('pnty_options', 'pnty_show_ui');
    add_option('pnty_remove_showcase_archive', false);
    register_setting('pnty_options', 'pnty_remove_showcase_archive', 'pnty_slug_save');
    add_option('pnty_slug_showcase', 'showcase-jobs');
    register_setting('pnty_options', 'pnty_slug_showcase', 'pnty_slug_save');
    add_option('pnty_show_terminated_ui', false);
    register_setting('pnty_options', 'pnty_show_terminated_ui');
    add_option('pnty_extcss', null);
    register_setting('pnty_options', 'pnty_extcss');
    add_option('pnty_ogtag', false);
    register_setting('pnty_options', 'pnty_ogtag');
    add_option('pnty_jsonld', false);
    register_setting('pnty_options', 'pnty_jsonld');
    add_option('pnty_show_excerpt', false);
    register_setting('pnty_options', 'pnty_show_excerpt');
    add_option('pnty_share', false);
    register_setting('pnty_options', 'pnty_share');
    add_option('pnty_applybtn_position', '01');
    register_setting('pnty_options', 'pnty_applybtn_position');
    add_option('pnty_webhook_urls', '');
    register_setting('pnty_options', 'pnty_webhook_urls');
}
function pnty_slug_save($input) {
    set_transient('pnty_slug_saved', 'saved');
    return sanitize_title_with_dashes($input);
}

add_action('admin_menu', 'pnty_menu');
function pnty_menu() {
    add_options_page(
        'Ponty Connector',
        'Ponty Connector',
        'manage_options',
        'pnty-options',
        'pnty_connector_opts_page'
    );
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
        'location' => false,
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
        'location' => false,
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
add_action('init', array($pnty_connector, 'add_pnty_image_size'));

