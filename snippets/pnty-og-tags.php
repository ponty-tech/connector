<meta property="og:title" content="<?php echo $post->post_title;?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo the_permalink();?>" />
<meta property="og:description" content="<?php echo $post->post_excerpt;?>" />
<?php $logo = get_post_meta($post->ID, '_pnty_logo', true);?>
<?php if ($logo !== '') :?>
<meta property="og:image" content="<?php echo $logo;?>" />
<?php endif; ?>
