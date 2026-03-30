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

        return pnty_get_logo($post_id);
    }
}
