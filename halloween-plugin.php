<?php
/*
* Plugin Name: Product Catalog
* Description: Create a Store to Display Product Information
* Version: 1.0
* Author: Danyal Imran
* Author URI: http://facebook.com/fuNkyBRO1
* License: GPLv2
*/

    /* 
    LICENCE TERMS!
    
    Copyright 2016 Danyal Imran (email : k132089@nu.edu.pk)
    
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
    */
    
    
    /* Setting up default plugin settings when user activates the plugin in WordPress */
    register_activation_hook(__FILE__, 'halloween_store_install');

    function halloween_store_install() {
        $hween_options_array = array(
            'currency_sign' => '$'
        );
        
        update_option('halloween_options', $hween_options_array);
    } // #EndOfHalloweenStoreInstall!

    /* Registering Custom Post Types for Products. Adding and Managing of Products */
    add_action('init', 'halloween_store_init');

    function halloween_store_init() {
        $singular = 'Product';
        $plural = 'Products';
            
        $labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New ' . $singular,
            'edit_item' => 'Edit ' . $singular,
            'new_item' => 'New ' . $singular,
            'all_items' => 'All ' . $plural,
            'view_item' => 'View ' . $singular,
            'search_items' => 'Search ' . $plural,
            'not_found' => 'No ' . $plural . ' Found',
            'not_found_in_trash' => 'No ' . $plural . ' Found in Trash',
            'menu_name' => $plural
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => 'dashicons-list-view',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt')
        );
        
        register_post_type('halloween-products', $args);
    } // #EndOfHalloweenStoreInit!


    // Adding Halloween Store inside Settings Tab
    add_action('admin_menu', 'halloween_store_menu');

    function halloween_store_menu() {
        add_options_page('Halloween Store Settings Page', 'Halloween Store Settings', 'manage_options', 'halloween-store-settings', 'halloween_store_settings_page');
    } // #EndOfHalloweenStoreMenu!


    // Displaying Halloween Store Settings
    function halloween_store_settings_page() {
        $hween_options_array = get_option('halloween-options');
        
        $hs_inventory = (!empty($hween_options_array['show inventory'])) ? $hween_options_array['show inventory'] : '';
        $hs_currency_sign = $hween_options_array['currency sign'];
        ?>

        <!-- HTML Code to Display Page Content! -->
        <div class="wrap">
            <h2>Halloween Store Options</h2> 
            
            <form method='post' action='options.php'>
                <?php settings_fields('halloween-settings-group'); ?>
                <table class='form-table'>
                    <tr valign='top'>
                        <th scope='row'>Show Product Inventory</th>
                        <td><input type='checkbox' name='halloween_options[show_inventory]' <?php echo checked($hs_inventory, 'on'); ?> /></td>
                    </tr>
                    
                    <tr valign='top'>
                        <th scope='row'>Currency Sign</th>
                        <td><input type='text' name='halloween_options[currency_sign]' value='<?php echo esc_attr($hs_currency_sign); ?>' size='2' maxlength='2' /></td>
                    </tr>
                </table>
                
                <p class='submit'>
                    <input type='submit' class='button-primary' value='Save Changes' />
                </p>
            </form>
        </div>

        <?php
    } // #EndOfHalloweenStoreSettingsPage!

    // Registering Settings Field and Sanitizing Functions
    add_action('admin_init', 'halloween_store_register_settings');
        
    function halloween_store_register_settings() {
        register_setting('halloween-settings-group', 'halloween_options', 'halloween_sanitize_option');
    } // #EndOfHalloweenStoreRegisterSettings!
        
    function halloween_sanitize_option() {
        $options['show inventory'] = (!empty($options['show inventory'])) ? sanitize_text_field($options['show_inventory']) : '';
        $options['currency sign'] = (!empty($options['currency sign'])) ? sanitize_text_field($options['currency sign']) : '';
        
        return $options;
    } // #EndOfHalloweenSanitizeOption!
        
        
    // Registering Metabox to save Product Metadata
    add_action('add_meta_boxes', 'halloween_store_register_meta_box');
        
    function halloween_store_register_meta_box() {
        add_meta_box('halloween-product-meta', 'Product Information', 'halloween_meta_box', 'halloween-products', 'side', 'default');
    } // #EndOfHalloweenStoreRegisterMetaBox!
        
    function halloween_meta_box($post, $box) {
        $hween_sku = get_post_meta($post->ID, '_halloween_product_sku', true);
        $hween_price = get_post_meta($post->ID, '_halloween_product_price', true);
        $hween_weight = get_post_meta($post->ID, '_halloween_product_weight', true);
        $hween_color = get_post_meta($post->ID, '_halloween_product_color', true);
        $hween_inventory = get_post_meta($post->ID, '_halloween_product_inventory', true);
            
        wp_nonce_field('meta-box-save', 'halloween-plugin');
            
        echo '<table>';
        echo '<tr>';
        echo '<td>Sku: </td><td><input type="text" name="halloween_product_sku" value="'.esc_attr($hween_sku).'" size="10" /></td>';
        echo '</tr><tr>';
        echo '<td>Price: </td><td><input type="text" name="halloween_product_price" value="'.esc_attr($hween_price).'" size="5" /></td>';
        echo '</tr><tr>';
        echo '<td>Weight: </td><td><input type="text" name="halloween_product_weight" value="'.esc_attr($hween_weight).'" size="5" /></td>';
        echo '</tr><tr>';
        echo '<td>Color: </td><td><input type="text" name="halloween_product_color" value="'.esc_attr($hween_color).'" size="5" /></td>';
        echo '</tr><tr>';
        echo '<td>Inventory:</td>
              <td><select name="halloween_product_inventory" id="halloween_product_inventory">
                      <option value="In Stock"' . selected($hween_inventory, 'In Stock', false) . '>' . 'In Stock' . '</option>
                      <option value="Backordered"' . selected($hween_inventory, 'Backordered', false) . '>' . 'Backordered' . '</option>
                      <option value="Out of Stock"' . selected($hween_inventory, 'Out of Stock', false) . '>' . 'Out of Stock' . '</option>
                      <option value="Discontinued"' . selected($hween_inventory, 'Discontinued', false) . '>' . 'Discontinued' . '</option>
              </select></td>';
        echo '</tr>';
        
        echo '<tr><td colspan="2"><hr></td></tr>';
        echo '<tr><td colspan="2"><strong>Shortcode Legend</strong></td></tr>';
        echo '<tr><td>Sku: </td><td>[hs show=sku]</td></tr>';
        echo '<tr><td>Price: </td><td>[hs show=price]</td></tr>';
        echo '<tr><td>Weight: </td><td>[hs show=weight]</td></tr>';
        echo '<tr><td>Color: </td><td>[hs show=color]</td></tr>';
        echo '<tr><td>Inventory: </td><td>[hs show=inventory]</td></tr>';
        echo '</table>';
    } // #EndOfHalloweenMetaBox!
        
        
    // Save Data Entered in Form
    add_action('save_post','halloween_store_save_meta_box');
    
    function halloween_store_save_meta_box($post_id) {
        if (get_post_type($post_id) == 'halloween-products' && isset($_POST['halloween_product_sku'])) {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;
            
            check_admin_referer('meta-box-save', 'halloween-plugin');
            update_post_meta($post_id, '_halloween_product_sku', sanitize_text_field($_POST['halloween_product_sku']));
            update_post_meta($post_id, '_halloween_product_price', sanitize_text_field($_POST['halloween_product_price']));
            update_post_meta($post_id, '_halloween_product_weight', sanitize_text_field($_POST['halloween_product_weight']));
            update_post_meta($post_id, '_halloween_product_color', sanitize_text_field($_POST['halloween_product_color']));
            update_post_meta($post_id, '_halloween_product_inventory', sanitize_text_field($_POST['halloween_product_inventory']));
        }
    } // #EndOfHalloweenStoreSaveMetaBox!


    // Display Shortcodes in Product Category
    add_shortcode('hs', 'halloween_store_shortcode');

    function halloween_store_shortcode( $atts, $content = null ) {
        global $post;
        extract( shortcode_atts( array( "show" => '' ), $atts ) );
        
        $hween_options_array = get_option( 'halloween_options' );
        
        if ( $show == 'sku' ) {
            $hs_show = get_post_meta( $post->ID, '_halloween_product_sku', true );
        } elseif ( $show == 'price' ) {
            $hs_show = $hween_options_array['currency_sign'].
            get_post_meta( $post->ID, '_halloween_product_price', true );
        } elseif ( $show == 'weight' ) {
            $hs_show = get_post_meta( $post->ID, '_halloween_product_weight', true );
        } elseif ( $show == 'color' ) {
            $hs_show = get_post_meta( $post->ID, '_halloween_product_color', true );
        } elseif ( $show == 'inventory' ) {
            $hs_show = get_post_meta( $post->ID, '_halloween_product_inventory', true );
        }
        
        return $hs_show;
    } // #EndOfHalloweenStoreShortCode!


    // Creating a Widget
    add_action('widgets_init', 'halloween_store_register_widgets' );

    function halloween_store_register_widgets() {
        register_widget('hs_widget');
    } // #EndOfHalloweenStoreRegisterWidget!

    class hs_widget extends WP_Widget {
        /* Deprecated Constructor Removed */
        function __construct() {
            $widget_ops = array(
                'classname' => 'hs-widget-class',
                'description' => 'Display Halloween Products'
            );
            
            parent::__construct('hs_widget', 'Product Widget', $widget_ops);
        } // #EndOfConstructor!
        
        
        // Saving Widget Settings
        function form($instance) {
            $defaults = array(
                'title' => 'Products',
                'number_products' => '3' 
            );
        
            $instance = wp_parse_args((array)$instance, $defaults);
            
            $title = $instance['title'];
            $number_products = $instance['number_products']; ?>

            <p>Title: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        
            <p>Number of Products: <input name="<?php echo $this->get_field_name('number_products'); ?>" type="text" value="<?php echo esc_attr( $number_products ); ?>" size="2" maxlength="2" /></p>
            <?php
        } // #EndOfFormFunction!
        
        
        // Save Widget Settings
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = sanitize_text_field($new_instance['title']);
            $instance['number_products'] = sanitize_text_field($new_instance['number_products']);
            
            return $instance;
        } // #EndOfUpdate!
        
        
        // Displaying The Widget
        function widget($args, $instance) {
            global $post;
            extract($args);
            echo $before_widget;
            
            $title = apply_filters('widget_title', $instance['title']);
            $number_products = $instance['number_products'];
         
            if (!empty($title)) { 
                echo $before_title . esc_html($title) . $after_title; 
            };
            
            $args = array(
                'post_type' => 'halloween-products',
                'posts_per_page' => absint($number_products)
            );
            

            $dispProducts = new WP_Query();
            $dispProducts->query($args);

            while ($dispProducts->have_posts()) : 
                $dispProducts->the_post();

                $hween_options_array = get_option('halloween_options');
                $hs_price = get_post_meta($post->ID, '_halloween_product_price', true);
                $hs_inventory = get_post_meta($post->ID, '_halloween_product_inventory', true); ?>

                <p> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?> Product Information"> <?php the_title(); ?></a> </p>

                <?php echo '<p>Price: ' . $hween_options_array['currency_sign'] . $hs_price .'</p>';

                if ( $hween_options_array['show_inventory'] ) {
                    echo '<p>Stock: ' . $hs_inventory . '</p>';
                }

                echo '<hr>';
            endwhile;

            wp_reset_postdata();
            echo $after_widget;
        } // #EndOfWidget!
    }
?>
