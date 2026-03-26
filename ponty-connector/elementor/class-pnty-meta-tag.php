<?php
if ( ! defined('ABSPATH')) {
    exit;
}

class Pnty_Meta_Tag extends \Elementor\Core\DynamicTags\Tag {

    private $tag_name;
    private $tag_title;
    private $meta_key;

    public function __construct(array $data = [], $args = null, $tag_name = '', $tag_title = '', $meta_key = '') {
        $this->tag_name = $tag_name;
        $this->tag_title = $tag_title;
        $this->meta_key = $meta_key;
        parent::__construct($data, $args);
    }

    public function get_name() {
        return $this->tag_name;
    }

    public function get_title() {
        return $this->tag_title;
    }

    public function get_group() {
        return 'post';
    }

    public function get_categories() {
        return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
    }

    public function render() {
        $post_id = get_the_ID();
        if ( ! $post_id) {
            return;
        }

        $value = get_post_meta($post_id, $this->meta_key, true);
        if ($value) {
            echo wp_kses_post($value);
        }
    }
}
