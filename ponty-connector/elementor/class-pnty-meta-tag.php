<?php
if ( ! defined('ABSPATH')) {
    exit;
}

abstract class Pnty_Meta_Tag extends \Elementor\Core\DynamicTags\Tag {

    abstract protected function meta_key(): string;

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

        $value = get_post_meta($post_id, $this->meta_key(), true);
        if ($value) {
            echo wp_kses_post($value);
        }
    }
}

class Pnty_Location_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-location'; }
    public function get_title() { return __('Ponty Location', 'pnty'); }
    protected function meta_key(): string { return '_pnty_location'; }
}

class Pnty_Region_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-region'; }
    public function get_title() { return __('Ponty Region', 'pnty'); }
    protected function meta_key(): string { return '_pnty_region'; }
}

class Pnty_Organization_Name_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-organization-name'; }
    public function get_title() { return __('Ponty Organization Name', 'pnty'); }
    protected function meta_key(): string { return '_pnty_organization_name'; }
}

class Pnty_Contact_Name_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-contact-name'; }
    public function get_title() { return __('Ponty Contact Name', 'pnty'); }
    protected function meta_key(): string { return '_pnty_name'; }
}

class Pnty_Contact_Title_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-contact-title'; }
    public function get_title() { return __('Ponty Contact Title', 'pnty'); }
    protected function meta_key(): string { return '_pnty_user_title'; }
}

class Pnty_Phone_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-phone'; }
    public function get_title() { return __('Ponty Phone', 'pnty'); }
    protected function meta_key(): string { return '_pnty_phone'; }
}

class Pnty_Email_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-email'; }
    public function get_title() { return __('Ponty Email', 'pnty'); }
    protected function meta_key(): string { return '_pnty_email'; }
}

class Pnty_Address_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-address'; }
    public function get_title() { return __('Ponty Address', 'pnty'); }
    protected function meta_key(): string { return '_pnty_address'; }
}

class Pnty_Withdrawal_Date_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-withdrawal-date'; }
    public function get_title() { return __('Ponty Withdrawal Date', 'pnty'); }
    protected function meta_key(): string { return '_pnty_withdrawal_date'; }
}

class Pnty_External_Apply_Url_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-external-apply-url'; }
    public function get_title() { return __('Ponty External Apply URL', 'pnty'); }
    protected function meta_key(): string { return '_pnty_external_apply_url'; }
}

class Pnty_Language_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-language'; }
    public function get_title() { return __('Ponty Language', 'pnty'); }
    protected function meta_key(): string { return '_pnty_language'; }
}

class Pnty_Video_Url_Tag extends Pnty_Meta_Tag {
    public function get_name() { return 'pnty-video-url'; }
    public function get_title() { return __('Ponty Video URL', 'pnty'); }
    protected function meta_key(): string { return '_pnty_video_url'; }
}
