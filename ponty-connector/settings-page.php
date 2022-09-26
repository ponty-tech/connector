<?php
    $pnty_api_key = get_option('pnty_api_key');
    $pnty_slug = get_option('pnty_slug');
    $pnty_slug_showcase = get_option('pnty_slug_showcase');
    $pnty_extcss = get_option('pnty_extcss');
    $pnty_ogtag = get_option('pnty_ogtag');
    $pnty_jsonld = get_option('pnty_jsonld');
    $pnty_show_excerpt = get_option('pnty_show_excerpt');
    $pnty_share = get_option('pnty_share');
    $pnty_rest = get_option('pnty_rest');
    $pnty_webhook_urls = get_option('pnty_webhook_urls');
    $pnty_applybtn_position = get_option('pnty_applybtn_position');
    # for tabbed nav
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'base_settings';
?>
<div class="wrap">
    <h2><img style="vertical-align:middle;" src="<?php echo plugin_dir_url(__FILE__).'favicon-4.min.svg';?>" width="32" height="32" alt="PC logo" /> <?php _e('Ponty Connector settings', 'pnty');?></h2>
    <h2 class="nav-tab-wrapper">
        <a href="?page=pnty-options&tab=base_settings" class="nav-tab <?php echo $active_tab == 'base_settings' ? 'nav-tab-active' : '';?>"><?php _e('Base settings', 'pnty');?></a>
        <a href="?page=pnty-options&tab=advanced_settings" class="nav-tab <?php echo $active_tab == 'advanced_settings' ? 'nav-tab-active' : '';?>"><?php _e('Advanced settings', 'pnty');?></a>
        <a href="?page=pnty-options&tab=docs" class="nav-tab <?php echo $active_tab == 'docs' ? 'nav-tab-active' : '';?>"><?php _e('Documentation', 'pnty');?></a>
    </h2>
    <form method="post" action="<?php echo admin_url('options.php');?>">
        <?php settings_fields('pnty_options'); ?>
        <style>
            /* tab overwrite hack */
            .pnty-options{display:none;}
        </style>
        <?php if(in_array($active_tab, ['base_settings', 'advanced_settings'])):?>
            <?php if($active_tab == 'base_settings'):?>
                <?php echo '<style>.pnty-options--base{display:block;}</style>';?>
            <?php endif;?>
            <table class="form-table pnty-options pnty-options--base">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_api_key"><?php _e('API key', 'pnty');?></label>
                        </th>
                        <td>
                            <input size="30" type="text" id="pnty_api_key" name="pnty_api_key" value="<?php echo $pnty_api_key;?>" />
                            <p class="description"><?php _e('You find the key while logged in to our system.', 'pnty');?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                        <label for="pnty_slug">URL slug (<?php _e('active ads');?>)</label>
                        </th>
                        <td>
                            <input type="text" id="pnty_slug" name="pnty_slug" value="<?php echo $pnty_slug;?>" />
                            <p class="description"><?php _e('What url slug should prefix the jobs. Default is <strong>jobs</strong>.', 'pnty'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_slug_showcase">URL slug (<?php _e('showcase ads');?>)</label>
                        </th>
                        <td>
                            <input type="text" id="pnty_slug_showcase" name="pnty_slug_showcase" value="<?php echo $pnty_slug_showcase;?>" />
                            <p class="description"><?php _e('What url slug should prefix the showcase jobs. Default is <strong>showcase-jobs</strong>.', 'pnty'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <?php _e('Apply button position', 'pnty');?>
                        </th>
                        <td>
                            <fieldset>
                                <label><input type="radio" name="pnty_applybtn_position" value="01"<?php if ($pnty_applybtn_position === '01') echo ' checked="checked"'; ?> /> <span><?php _e('Bottom only', 'pnty');?></span></label><br />
                                <label><input type="radio" name="pnty_applybtn_position" value="10"<?php if ($pnty_applybtn_position === '10') echo ' checked="checked"'; ?> /> <span><?php _e('Top only', 'pnty');?></span></label><br />
                                <label><input type="radio" name="pnty_applybtn_position" value="11"<?php if ($pnty_applybtn_position === '11') echo ' checked="checked"'; ?> /> <span><?php _e('Both', 'pnty');?></span></label><br />
                                <label><input type="radio" name="pnty_applybtn_position" value="00"<?php if ($pnty_applybtn_position === '00') echo ' checked="checked"'; ?> /> <span><?php _e('Do not show', 'pnty');?></span></label><br />
                            </fieldset>
                            <p class="description"><?php _e('Where to show the apply button relative to the ad text.', 'pnty');?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php if($active_tab == 'advanced_settings'):?>
                <?php echo '<style>.pnty-options--advanced{display:block;}</style>';?>
            <?php endif;?>
            <table class="form-table pnty-options pnty-options--advanced">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_extcss"><?php _e('External css file', 'pnty');?></label>
                        </th>
                        <td>
                            <input type="text" id="pnty_extcss" name="pnty_extcss" value="<?php echo $pnty_extcss;?>" />
                            <p class="description"><?php _e('An URL to a web reachable css file.', 'pnty');?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_ogtag"><?php _e('Automatically create Open Graph meta tags within head', 'pnty');?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="pnty_ogtag" name="pnty_ogtag" value="true" <?php echo ($pnty_ogtag) ? 'checked="checked"': '';?> />
                            <p class="description"><?php _e('Use only if no other OG plugin is present.', 'pnty'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_jsonld"><?php _e('Add JSON-LD metadata (JobPosting) to ads.', 'pnty');?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="pnty_jsonld" name="pnty_jsonld" value="true" <?php echo ($pnty_jsonld) ? 'checked="checked"': '';?> />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_show_excerpt"><?php _e('Show excerpt above the ad in single view', 'pnty');?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="pnty_show_excerpt" name="pnty_show_excerpt" value="true" <?php echo ($pnty_show_excerpt) ? 'checked="checked"': '';?> />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_share"><?php _e('Show social media share buttons', 'pnty');?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="pnty_share" name="pnty_share" value="true" <?php echo ($pnty_share) ? 'checked="checked"': '';?> />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_rest"><?php _e('PostTypes visible in REST API', 'pnty');?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="pnty_rest" name="pnty_rest" value="true" <?php echo ($pnty_rest) ? 'checked="checked"': '';?> />
                            <p class="description"><?php _e('pnty_job, pnty_job_showcase will be exposed in REST API /wp-json/wp/v2/pnty_jobs, /wp-json/wp/v2/pnty_job_showcases.', 'pnty'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="pnty_webhook_urls"><?php _e('Webhook URLs', 'pnty');?></label>
                        </th>
                        <td>
                            <input size="70" type="text" id="pnty_webhook_urls" name="pnty_webhook_urls" value="<?php echo $pnty_webhook_urls;?>" />
                            <p class="description"><?php _e('Comma separated urls that gets triggered when a new ad is published.', 'pnty');?></p>
                            <p class="description"><?php _e('Request that gets sent is a POST request with content-type application/json. JSON keys are value1 for ad title and value2 for ad url.', 'pnty');?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button();?>
        <?php elseif($active_tab == 'docs'):?>
            <?php include(plugin_dir_path(__FILE__).'/docs-page.php');?>
        <?php endif;?>
    </form>
</div>
