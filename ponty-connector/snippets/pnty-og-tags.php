<meta property="og:title" content="<?php echo $post->post_title;?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo the_permalink();?>" />
<meta property="og:description" content="<?php echo $post->post_excerpt;?>" />
<?php
    $logo_attachment_id = get_post_meta($post->ID, '_pnty_logo_attachment_id', true);
    if ($logo_attachment_id) :
        list($logo_url, $logo_width, $logo_height) = wp_get_attachment_image_src($logo_attachment_id, 'full');
?>
<meta property="og:image" content="<?php echo $logo_url;?>" />
<meta property="og:image:width" content="<?php echo $logo_width;?>" />
<meta property="og:image:height" content="<?php echo $logo_height;?>" />
<?php endif; ?>
