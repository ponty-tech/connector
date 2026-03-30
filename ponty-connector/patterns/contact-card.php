<?php
/**
 * Title: Ponty — Contact Card
 * Slug: pnty/contact-card
 * Description: Recruiter contact information with profile image
 * Categories: ponty
 * Post Types: pnty_job, pnty_job_showcase
 */
?>
<!-- wp:group {"className":"pnty-job-info-card","style":{"border":{"width":"1px","color":"#e0e0e0","radius":"8px"},"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"},"blockGap":"0.5rem"}}} -->
<div class="wp-block-group pnty-job-info-card has-border-color" style="border-color:#e0e0e0;border-width:1px;border-radius:8px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">

<!-- wp:image {"sizeSlug":"thumbnail","className":"pnty-job-profile-image","metadata":{"bindings":{"url":{"source":"pnty/fields","args":{"key":"_pnty_user_profile_image"}},"alt":{"source":"pnty/fields","args":{"key":"_pnty_user_profile_image"}}}}} -->
<figure class="wp-block-image size-thumbnail pnty-job-profile-image"><img src="" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"pnty-job-contact-name","style":{"typography":{"fontStyle":"normal","fontWeight":"600"}},"metadata":{"bindings":{"content":{"source":"pnty/fields","args":{"key":"_pnty_name"}}}}} -->
<p class="pnty-job-contact-name" style="font-style:normal;font-weight:600"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pnty-job-contact-title","style":{"typography":{"fontSize":"0.9rem"},"color":{"text":"#666666"}},"metadata":{"bindings":{"content":{"source":"pnty/fields","args":{"key":"_pnty_user_title"}}}}} -->
<p class="pnty-job-contact-title has-text-color" style="color:#666666;font-size:0.9rem"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pnty-job-contact-email","style":{"typography":{"fontSize":"0.9rem"}},"metadata":{"bindings":{"content":{"source":"pnty/fields","args":{"key":"_pnty_email"}}}}} -->
<p class="pnty-job-contact-email" style="font-size:0.9rem"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pnty-job-contact-phone","style":{"typography":{"fontSize":"0.9rem"}},"metadata":{"bindings":{"content":{"source":"pnty/fields","args":{"key":"_pnty_phone"}}}}} -->
<p class="pnty-job-contact-phone" style="font-size:0.9rem"></p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
