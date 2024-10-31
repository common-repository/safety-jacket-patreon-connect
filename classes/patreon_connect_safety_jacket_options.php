<?php

/*
Plugin Name: Patreon Connect: Safety Jacket
Plugin URI:https://uiux.me/patreon-connect-safety-jacket
Description: A safety jacket for Patreon Connect
Version: 1.0
Author: UIUX <me@uiux.me>
Author URI: https://uiux.me
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Patreon_Connect_Safety_Jacket_Options {


    function __construct() {

        if ( is_admin() ){
            add_action('admin_menu', array($this, 'patreon_plugin_setup') );
            add_action('admin_init', array($this, 'patreon_plugin_register_settings') );
        }

    }

    function patreon_plugin_setup(){
        add_menu_page( 'Patreon Safety Jacket Settings', 'Safety Jacket', 'manage_options', 'patreon-safety-jacket-plugin', array($this, 'patreon_safety_jacket_plugin_setup_page'), 'dashicons-lock' );
    }

    function patreon_plugin_register_settings() {
        register_setting( 'patreon-safety-jacket-options', 'safety-jacket-banner');
        register_setting( 'patreon-safety-jacket-options', 'patreon-safety-jacket-custom-banner');
        register_setting( 'patreon-safety-jacket-options', 'patreon-safety-jacket-custom-banner-content');
        register_setting( 'patreon-safety-jacket-options', 'patreon-safety-jacket-creator-id');
        register_setting( 'patreon-safety-jacket-options', 'patreon-safety-jacket-creator-page-url');
        register_setting( 'patreon-safety-jacket-options', 'patreon-safety-jacket-walled-garden');
        register_setting( 'patreon-safety-jacket-options', 'patreon-safety-jacket-walled-garden-page');
    }

    function patreon_safety_jacket_plugin_setup_page(){

        $args = array(
                'post_type'=>'page',
                'post_status'=>'publish',
                'posts_per_page'=>-1,
                'sort_order'=>'asc',
                'orderby'=>'title'
            );
        $all_pages = get_pages($args);

        ?>

       <form method="post" action="options.php">

            <?php settings_fields( 'patreon-safety-jacket-options' ); ?>
            <?php do_settings_sections( 'patreon-safety-jacket-options' ); ?>
    

        <div class="wrap">

            <div id="icon-options-general" class="icon32"></div>
            <h1>Patreon Connect: Safety Jacket Settings</h1>

            <div id="poststuff">

                <div id="post-body" class="metabox-holder columns-2">

                    <!-- main content -->
                    <div id="post-body-content">

                        <div class="meta-box-sortables ui-sortable">

                            <div class="postbox">

                                <div class="handlediv" title="Click to toggle"><br></div>
                                <!-- Toggle -->

                                <h2 class="hndle"><span>Banner Settings</span>
                                </h2>

                                <div class="inside">

                                    <p><a href="https://www.patreon.com/wordpressplugin">Patreon Connect</a> is designed to protect your content from non-patrons and patrons that have not contributed enough to experience the content of your website.</p>

                                    <p>These are the settings for what is displayed when protected content should hidden from view. You have different banner customisation options available. It will default to a Patreon button by default.</p>

                                    <p>Get your Creator ID <a href="https://www.patreon.com/dashboard/widgets" target="_blank">here</a>, in the url for the button you can find your creator ID.</p>
                                    <p><em>https://www.patreon.com/bePatron?u=<strong>XXXXXXXXXX</strong></em></p>

                                    <table class="widefat">

                                        <tr valign="top">
                                        <th scope="row"><strong>Creator ID</strong></th>
                                        <td><input type="text" name="patreon-safety-jacket-creator-id" value="<?php echo esc_attr( get_option('patreon-safety-jacket-creator-id', '') ); ?>" class="large-text" /></td>
                                        </tr>

                                        <tr valign="top">
                                        <th scope="row"><strong>Creator Page URL</strong></th>
                                        <td><input type="text" name="patreon-safety-jacket-creator-page-url" value="<?php echo esc_attr( get_option('patreon-safety-jacket-creator-page-url', '') ); ?>" class="large-text" /></td>
                                        </tr>

                                        <tr valign="top">
                                        <th scope="row"><strong>Enable walled garden</strong></th>
                                        <td><input type="checkbox" name="patreon-safety-jacket-walled-garden" value="1"<?php checked( get_option('patreon-safety-jacket-walled-garden', false) ); ?>></td>
                                        </tr>
                                        
                                        <?php if(get_option('patreon-safety-jacket-walled-garden', false)) { ?>
                                        <tr valign="top">
                                        <th scope="row"><strong>Walled Garden Page</strong></th>
                                        <td>
                                            <select name="patreon-safety-jacket-walled-garden-page">
                                                <?php foreach($all_pages as $page) {

                                                    $selected = ( $page->ID == get_option('patreon-safety-jacket-walled-garden-page', false) ? 'selected="selected"' : '' );
                                                    echo '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';

                                                } ?>                
                                            </select>
                                        </td>
                                        </tr>
                                        <?php } ?>

                                        <tr valign="top">
                                        <th scope="row"><strong>Enable custom banner</strong></th>
                                        <td><input type="checkbox" name="patreon-safety-jacket-custom-banner" value="1"<?php checked( get_option('patreon-safety-jacket-custom-banner', false) ); ?>></td>
                                        </tr>

                                    </table>

                                    <?php if(get_option('patreon-safety-jacket-custom-banner', false)) { ?>

                                    <br>
                                    
                                    <p>
                                    <strong>Custom Banner Content</strong>
                                    <?php 

                                    $safety_jacket_banner = get_option('patreon-safety-jacket-custom-banner-content', '');
                                    wp_editor( $safety_jacket_banner, 'patreon-safety-jacket-custom-banner-content' );

                                    ?>
                                    </p>

                                    <?php } ?>


                                </div>
                                <!-- .inside -->

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables .ui-sortable -->

                         <?php submit_button('Update Settings', 'primary', 'submit', false); ?>

                    </div>
                    <!-- post-body-content -->

                    <!-- sidebar -->
                    <div id="postbox-container-1" class="postbox-container">

                        <div class="meta-box-sortables">

                            <div class="postbox">

                                <div class="handlediv" title="Click to toggle"><br></div>
                                <!-- Toggle -->

                                <h2 class="hndle">About Safety Jacket</h2>

                                <div class="inside">
                                    
                                    <p>
                                        A time may come when your copy of Patreon Connect is de-activated or not running. When that time comes, it's a good idea to have backup. <br>
                                        <br>
                                        Safety Jacket will ensure your Patreon Content is hidden - even when Patreon Connect isn't functioning. This is the safety net.
                                    </p>

                                </div>
                                <!-- .inside -->

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables -->

                        <div class="meta-box-sortables">

                            <div class="postbox">

                                <div class="handlediv" title="Click to toggle"><br></div>
                                <!-- Toggle -->

                                <h2 class="hndle">About Patreon Connect</h2>

                                <div class="inside">
                                    
                                    <p>Patreon Connect developed by Ben Parry @ <a href="https://uiux.me?utm_source=plugin_settings" target="_blank">https://uiux.me</a></p>
                                    
                                    <p><strong>SUPPORT &amp; TECHNICAL HELP</strong> <br>
                                    If you require support for this plugin, you can go to <a href="https://uiux.me/support?utm_source=plugin_settings" target="_blank">https://uiux.me/support</a> and submit a ticket.</p>
                                    <p><strong>DOCUMENTATION</strong> <br>Technical documentation and code examples available for patrons @ <a href="https://uiux.me/documentation?utm_source=plugin_settings" target="_blank">https://uiux.me/documentation</a></p>
                                    
                                    <p><a href="https://www.patreon.com/bePatron?u=2525709" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script></p>

                                </div>
                                <!-- .inside -->

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables -->

                    </div>
                    <!-- #postbox-container-1 .postbox-container -->

                </div>
                <!-- #post-body .metabox-holder .columns-2 -->

                <br class="clear">
            </div>
            <!-- #poststuff -->

        </div> <!-- .wrap -->
            
        

        </form>


    <?php

    }


}

?>
