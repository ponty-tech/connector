<?php
    $pnty_api_key = get_option('pnty_api_key');
    $pnty_slug = get_option('pnty_slug');
    $pnty_lang = get_option('pnty_lang');
    $pnty_extcss = get_option('pnty_extcss');
    $pnty_ogtag = get_option('pnty_ogtag');
    $pnty_show_excerpt = get_option('pnty_show_excerpt');
    $pnty_applybtn_position = get_option('pnty_applybtn_position');
?>
<div class="wrap">
    <h2><img style="vertical-align:middle;" src="<?php echo plugin_dir_url(__FILE__).'wpicon.svg';?>" width="32" height="32" alt="PC logo" /> Ponty Connector settings</h2>
    <form method="post" action="options.php">
        <?php settings_fields('pnty_options'); ?>
        <table class="form-table">
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
                        <label for="pnty_slug">URL slug</label>
                    </th>
                    <td>
                        <input type="text" id="pnty_slug" name="pnty_slug" value="<?php echo $pnty_slug;?>" />
                        <p class="description"><?php _e('What url slug should prefix the jobs. Default is <strong>pnty_job</strong>.', 'pnty'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="pnty_slug"><?php _e('Language', 'pnty');?></label>
                    </th>
                    <td>
                        <select id="pnty_lang" name="pnty_lang">
                            <option value="en_US"<?php echo ($pnty_lang=='en_US')?' selected="selected"':'';?>><?php _e('English', 'pnty');?></option>
                            <option value="sv_SE"<?php echo ($pnty_lang=='sv_SE')?' selected="selected"':'';?>><?php _e('Swedish', 'pnty');?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="pnty_slug"><?php _e('External css file', 'pnty');?></label>
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
                        <?php _e('Apply button position', 'pnty');?>
                    </th>
                    <td>
                        <fieldset>
                            <label><input type="radio" name="pnty_applybtn_position" value="01"<?php if ($pnty_applybtn_position === '01') echo ' checked="checked"'; ?> /> <span><?php _e('Bottom only', 'pnty');?></span></label><br />
                            <label><input type="radio" name="pnty_applybtn_position" value="10"<?php if ($pnty_applybtn_position === '10') echo ' checked="checked"'; ?> /> <span><?php _e('Top only', 'pnty');?></span></label><br />
                            <label><input type="radio" name="pnty_applybtn_position" value="11"<?php if ($pnty_applybtn_position === '11') echo ' checked="checked"'; ?> /> <span><?php _e('Both', 'pnty');?></span></label>
                        </fieldset>
                        <p class="description"><?php _e('Where to show the apply button relative to the ad text.', 'pnty');?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button();?>
    </form>
    <h3><?php _e('Available shortcodes', 'pnty'); ?></h3>
    <p><code>[pnty_jobs_table]</code></p>
    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th><?php _e('Attribute', 'pnty');?></th>
                <th>Default</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>publish_date</td>
                <td><?php _e('yes', 'pnty');?></td>
            </tr>
            <tr>
                <td>organization_name</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
            <tr>
                <td>region</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
            <tr>
                <td>location</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
        </tbody>
    </table>
    <p><code>[pnty_jobs_list]</code></p>
    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th><?php _e('Attribute', 'pnty');?></th>
                <th>Default</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>organization_name</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
            <tr>
                <td>excerpt</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
            <tr>
                <td>logo</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
            <tr>
                <td>logo_width</td>
                <td><?php _e('no', 'pnty');?></td>
            </tr>
        </tbody>
    </table>
    <h3><?php _e('Extra meta data associated with every post', 'pnty');?></h3>
    <p><code>_pnty_assignment_id</code> the unique id from our system.</p>
    <p><code>_pnty_organization_name</code> the name of the organization.</p>
    <p><code>_pnty_name</code> the name of the person responsible for the assignment.</p>
    <p><code>_pnty_user_title</code> the title of the person responsible.</p>
    <p><code>_pnty_phone</code> phone number to the person responsible.</p>
    <p><code>_pnty_email</code> email address to the person responsible.</p>
    <p><code>_pnty_location</code></p>
    <p><code>_pnty_region</code></p>
    <p><code>_pnty_logo</code> a logo if attached.</p>
    <p><code>_pnty_apply_btn</code> the JavaScript widget for exposing the apply button.</p>
</div>
