<?php
    $pnty_api_key = get_option('pnty_api_key');
    $pnty_slug = get_option('pnty_slug');
    $pnty_slug_showcase = get_option('pnty_slug_showcase');
    $pnty_lang = get_option('pnty_lang');
    $pnty_extcss = get_option('pnty_extcss');
    $pnty_ogtag = get_option('pnty_ogtag');
    $pnty_show_excerpt = get_option('pnty_show_excerpt');
    $pnty_share = get_option('pnty_share');
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
                    <label for="pnty_slug">URL slug (<?php _e('active ads');?>)</label>
                    </th>
                    <td>
                        <input type="text" id="pnty_slug" name="pnty_slug" value="<?php echo $pnty_slug;?>" />
                        <p class="description"><?php _e('What url slug should prefix the jobs. Default is <strong>pnty_job</strong>.', 'pnty'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="pnty_slug_showcase">URL slug (<?php _e('showcase ads');?>)</label>
                    </th>
                    <td>
                        <input type="text" id="pnty_slug_showcase" name="pnty_slug_showcase" value="<?php echo $pnty_slug_showcase;?>" />
                        <p class="description"><?php _e('What url slug should prefix the showcase jobs. Default is <strong>pnty_job_showcase</strong>.', 'pnty'); ?></p>
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
                        <p class="description"><?php _e('Use only if no other OG plugin is present.', 'pnty'); ?></p>
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
    <h4><code>[pnty_jobs_table] <?php _e('or', 'pnty');?> [pnty_showcase_table]</code></h4>
    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th><?php _e('Attribute', 'pnty');?></th>
                <th><?php _e('Default value', 'pnty');?></th>
                <th><?php _e('Example', 'pnty');?></th>
                <th><?php _e('Description', 'pnty');?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>title_column_name</td>
                <td><?php _e('Title', 'pnty');?></td>
                <td><code>[... titel_column_name="Role"]</code></td>
                <td><?php _e('The column name for the ad title.', 'pnty');?></td>
            </tr>
            <tr>
                <td>publish_date</td>
                <td><?php _e('true', 'pnty');?></td>
                <td><code>[... publish_date="1"]</code></td>
                <td><?php _e('Shows the publish date as a table column.', 'pnty');?></td>
            </tr>
            <tr>
                <td>organization_name</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... organization_name="1"]</code></td>
                <td><?php _e('Shows the organization name as a table column.', 'pnty');?></td>
            </tr>
            <tr>
                <td>region</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... region="1"]</code></td>
                <td><?php _e('Shows the region as a table column.', 'pnty');?></td>
            </tr>
            <tr>
                <td>location</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... location="1"]</code></td>
                <td><?php _e('Shows the location as a table column.', 'pnty');?></td>
            </tr>
            <tr>
                <td>numberposts</td>
                <td>-1</td>
                <td><code>[... numberposts="5"]</code></td>
                <td><?php _e('How many items to show.', 'pnty');?></td>
            </tr>
            <tr>
                <td>link_all</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... link_all="1"]</code></td>
                <td><?php _e('Make all table cell data linked.', 'pnty');?> (<?php _e('Only for active ads', 'pnty');?>)</td>
            </tr>
            <tr>
                <td>tag</td>
                <td></td>
                <td><code>[... tag="a-tag-slug,another-tag"]</code></td>
                <td><?php _e('Only show items that has this tag (slug). Separate with commas.', 'pnty');?></td>
            </tr>
            <tr>
                <td>class</td>
                <td></td>
                <td><code>[... class="my-custom-class another-class"]</code></td>
                <td><?php _e('CSS class for the &lt;table&gt;.', 'pnty');?></td>
            </tr>
            <tr>
                <td>excerpt_title</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... excerpt_title="1"]</code></td>
                <td><?php _e('Adds the excerpt as a title attribute to all &lt;tr&gt; tags.', 'pnty');?></td>
            </tr>
        </tbody>
    </table>
    <h4><code>[pnty_jobs_list] <?php _e('or', 'pnty');?> [pnty_showcase_list]</code></h4>
    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th><?php _e('Attribute', 'pnty');?></th>
                <th><?php _e('Default value', 'pnty');?></th>
                <th><?php _e('Example', 'pnty');?></th>
                <th><?php _e('Description', 'pnty');?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>organization_name</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... organization_name="1"]</code></td>
                <td><?php _e('Show the organization name.', 'pnty');?></td>
            </tr>
            <tr>
                <td>excerpt</td>
                <td><?php _e('false', 'pnty');?></td>
                <td><code>[... excerpt="1"]</code></td>
                <td><?php _e('Show excerpt as part of the &lt;li&gt; tag.', 'pnty');?></td>
            </tr>
            <tr>
                <td>logo</td>
                <td><?php _e('', 'pnty');?></td>
                <td><code>[... logo="1"]</code></td>
                <td><?php _e('To show the client logo.', 'pnty');?></td>
            </tr>
            <tr>
                <td>logo_width</td>
                <td>200</td>
                <td><code>[... logo_width="200"]</code></td>
                <td><?php _e('Logo image width.', 'pnty');?></td>
            </tr>
            <tr>
                <td>readmore</td>
                <td></td>
                <td><code>[... readmore="Read more"]</code></td>
                <td><?php _e('Adds a read more link with attribute value as text.', 'pnty');?> (<?php _e('Only for active ads', 'pnty');?>)</td>
            </tr>
            <tr>
                <td>numberposts</td>
                <td>-1</td>
                <td><code>[... numberposts="10"]</code></td>
                <td><?php _e('How many items to show.', 'pnty');?></td>
            </tr>
            <tr>
                <td>tag</td>
                <td></td>
                <td><code>[... tag="a-tag-slug,another-tag"]</code></td>
                <td><?php _e('Only show items that has this tag (slug). Separate with commas.', 'pnty');?></td>
            </tr>
            <tr>
                <td>class</td>
                <td></td>
                <td><code>[... class="my-custom-class another-class"]</code></td>
                <td><?php _e('CSS class for the &lt;ul&gt;.', 'pnty');?></td>
            </tr>
        </tbody>
    </table>
    <h3><?php _e('Extra meta data associated with every post', 'pnty');?></h3>
    <p><code>_pnty_assignment_id</code> the unique id from the Ponty system.</p>
    <p><code>_pnty_withdrawal_date</code> the date where an ad will be removed.</p>
    <p><code>_pnty_organization_name</code> the name of the organization.</p>
    <p><code>_pnty_name</code> the name of the person responsible for the assignment.</p>
    <p><code>_pnty_user_title</code> the title of the person responsible.</p>
    <p><code>_pnty_phone</code> phone number to the person responsible.</p>
    <p><code>_pnty_email</code> email address to the person responsible.</p>
    <p><code>_pnty_client_contact</code> json representation of the person the recruitment is for. Contains name, title, phone and email.</p>
    <p><code>_pnty_location</code></p>
    <p><code>_pnty_region</code></p>
    <p><code>_pnty_address</code> json representation of an address. Contains address, postalcode, city and country.</p>
    <p><code>_pnty_logo</code> a logo if attached.</p>
    <p><code>_pnty_apply_btn</code> the JavaScript widget for exposing the apply button.</p>
</div>
