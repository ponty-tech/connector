<div class="pnty-share-btn">
    <div class="pnty-share-btn__item pnty-share-btn__item--facebook">
        <a target="_blank" title="Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($post->ID);?>?pnty_src=facebook"><i class="icon-facebook"></i></a>
    </div>
    <div class="pnty-share-btn__item pnty-share-btn__item--linkedin">
        <a target="_blank" title="LinkedIn" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink($post->ID);?>?pnty_src=linkedin"><i class="icon-linkedin"></i></a>
    </div>
    <div class="pnty-share-btn__item pnty-share-btn__item--twitter">
        <a target="_blank" title="Twitter" href="https://twitter.com/intent/tweet?text=<?php echo $post->post_title;?>&tw_p=tweetbutton&url=<?php echo get_permalink($post->ID);?>?pnty_src=twitter"><i class="icon-twitter"></i></a>
    </div>
    <div class="pnty-share-btn__item pnty-share-btn__item--gplus">
        <a target="_blank" title="G+" href="https://plus.google.com/share?url=<?php echo get_permalink($post->ID);?>?pnty_src=gplus"><i class="icon-gplus"></i></a>
    </div>
    <div style="clear:both;"></div>
</div>
