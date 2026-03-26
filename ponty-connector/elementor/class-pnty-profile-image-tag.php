<?php
if ( ! defined('ABSPATH')) {
    exit;
}

class Pnty_Profile_Image_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

    public function get_name() {
        return 'pnty-profile-image';
    }

    public function get_title() {
        return __('Ponty Profile Image', 'pnty');
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

        $url = get_post_meta($post_id, '_pnty_user_profile_image', true);
        if ($url) {
            return ['url' => $url, 'id' => 0];
        }

        return ['url' => '', 'id' => 0];
    }
}
