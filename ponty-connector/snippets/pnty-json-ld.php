<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "JobPosting",
  "title": "<?php echo $post->post_title;?>",
  "url": "<?php echo get_the_permalink($post->ID);?>",
  "datePosted": "<?php echo get_the_time('c', $post->ID);?>",
  "description": "<?php echo wp_strip_all_tags($post->post_content, true);?>"
}
</script>
