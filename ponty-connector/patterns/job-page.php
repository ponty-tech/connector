<?php
/**
 * Title: Ponty — Job Page
 * Slug: pnty/job-page
 * Description: A complete single job page with sidebar contact details
 * Categories: ponty
 * Post Types: pnty_job, pnty_job_showcase
 * Template Types: single-pnty_job, single-pnty_job_showcase
 */
?>
<!-- wp:group {"align":"wide","className":"pnty-job-page","style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem"}}},"layout":{"type":"constrained","contentSize":"1400px"}} -->
<div class="wp-block-group alignwide pnty-job-page" style="padding-top:2rem;padding-bottom:2rem">

<!-- wp:post-title {"level":1,"className":"pnty-job-title"} /-->

<!-- wp:columns {"className":"pnty-job-columns","style":{"spacing":{"blockGap":{"left":"3rem"}}}} -->
<div class="wp-block-columns pnty-job-columns">

<!-- wp:column {"width":"70%","className":"pnty-job-content"} -->
<div class="wp-block-column pnty-job-content" style="flex-basis:70%">
<!-- wp:post-content /-->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%","className":"pnty-job-sidebar"} -->
<div class="wp-block-column pnty-job-sidebar" style="flex-basis:30%">

<!-- wp:group {"className":"pnty-job-info-card","style":{"border":{"width":"1px","color":"#e0e0e0","radius":"8px"},"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"},"blockGap":"0.5rem"},"position":{"type":"sticky","top":"2rem"}}} -->
<div class="wp-block-group pnty-job-info-card has-border-color" style="border-color:#e0e0e0;border-width:1px;border-radius:8px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">

<!-- wp:paragraph {"className":"pnty-job-organization","style":{"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"1.1rem"}},"metadata":{"bindings":{"content":{"source":"pnty/fields","args":{"key":"_pnty_organization_name"}}}}} -->
<p class="pnty-job-organization" style="font-style:normal;font-weight:600;font-size:1.1rem"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pnty-job-location","style":{"typography":{"fontSize":"0.9rem"},"color":{"text":"#666666"}},"metadata":{"bindings":{"content":{"source":"pnty/fields","args":{"key":"_pnty_location"}}}}} -->
<p class="pnty-job-location has-text-color" style="color:#666666;font-size:0.9rem"></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"pnty-job-separator","style":{"spacing":{"margin":{"top":"1rem","bottom":"1rem"}}}} -->
<hr class="wp-block-separator has-alpha-channel-opacity pnty-job-separator" style="margin-top:1rem;margin-bottom:1rem"/>
<!-- /wp:separator -->

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

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->
