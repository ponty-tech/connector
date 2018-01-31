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
            <td></td>
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
<p><code>_pnty_logo_attachment_id</code> an attachment id. Can be used with any of the built in methods for dealing with associated attachments. The attachment is an image stored as a media object in WP.</p>
