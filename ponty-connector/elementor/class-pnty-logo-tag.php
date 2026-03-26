<?php
if ( ! defined('ABSPATH')) {
    exit;
}

class Pnty_Logo_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

    public function get_name() {
        return 'pnty-logo';
    }

    public function get_title() {
        return __('Ponty Logo', 'pnty');
    }

    public function get_group() {
        return 'post';
    }

    public function get_categories() {
        return [\Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY];
    }

    public function get_value(array $options = []) {
        $post_id = get_the_ID();
        if ( ! $post_id) {
            return ['url' => '', 'id' => 0];
        }

        $attachment_id = get_post_meta($post_id, '_pnty_logo_attachment_id', true);
        if ($attachment_id) {
            $url = wp_get_attachment_url($attachment_id);
            if ($url) {
                return ['url' => $url, 'id' => (int) $attachment_id];
            }
        }

        $logo_url = get_post_meta($post_id, '_pnty_logo', true);
        if ($logo_url) {
            return ['url' => $logo_url, 'id' => 0];
        }

        return ['url' => '', 'id' => 0];
    }
}
