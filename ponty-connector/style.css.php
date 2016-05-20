@charset "UTF-8";

.pnty-share-btn {
    
}
.pnty-share-btn__item > a {
    display: block;
    width: 44px;
    height: 44px;

    text-decoration: none;
    text-align: center;
    color: white;
}
.pnty-share-btn__item > a:hover {
    color: #ccc;
}
.pnty-share-btn__item {
    float: left;
    font-size: 24px;
    width: 44px;
    height: 44px;
}
.pnty-share-btn__item--facebook {
    background-color: #3B5998;
}
.pnty-share-btn__item--linkedin {
    background-color: #0077B5;
}
.pnty-share-btn__item--twitter {
    background-color: #55ACEE;
}
.pnty-share-btn__item--gplus {
    background-color: #DC4E41;
}

@font-face {
  font-family: "wp-share";
  src:url("<?php echo plugin_dir_url(__FILE__);?>fonts/wp-share.eot");
  src:url("<?php echo plugin_dir_url(__FILE__);?>fonts/wp-share.eot?#iefix") format("embedded-opentype"),
    url("<?php echo plugin_dir_url(__FILE__);?>fonts/wp-share.woff") format("woff"),
    url("<?php echo plugin_dir_url(__FILE__);?>fonts/wp-share.ttf") format("truetype"),
    url("<?php echo plugin_dir_url(__FILE__);?>fonts/wp-share.svg#wp-share") format("svg");
  font-weight: normal;
  font-style: normal;

}

[class^="icon-"]:before,
[class*=" icon-"]:before {
  font-family: "wp-share" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 44px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.icon-twitter:before {
  content: "\61";
}
.icon-facebook:before {
  content: "\62";
}
.icon-linkedin:before {
  content: "\63";
}
.icon-gplus:before {
  content: "\65";
}
