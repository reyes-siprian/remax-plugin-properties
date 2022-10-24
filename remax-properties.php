<?php
/**
 * Plugin Name:       Remax Properties
 * Description:       Shows the properties published on the Remax platforms. 
 * Version:           1.2.0
 * Requires at least: 5.9.3
 * Requires PHP:      7.2
 * Text Domain:       remax-properties
 * Author:            Adrian Reyes
 **/

defined("ABSPATH") or die;

/**
 * Add plugin settings.
 */
add_shortcode("remax-properties-page", "remax_properties_front_page");
add_shortcode("remax-properties-slider", "remax_properties_slider");
add_shortcode("remax-properties-search", "remax_properties_search");
add_shortcode("remax-properties-featured", "remax_properties_featured");
register_uninstall_hook(__FILE__, 'uninstall_remax_properties');
register_activation_hook(__FILE__, 'remax_properties_install');

/**
 * Add Actions
 */
add_action("admin_menu", "remax_properties_setup_menu");

/**
 * Includes
 */
require_once "inc/classes/Property.php";

if (!function_exists("remax_properties_setup_menu")) {
    function remax_properties_setup_menu() {
        add_menu_page(
            "Remax Properties",
            "Remax Properties",
            "manage_options",
            "remax-properties-plugin",
            "remax_properties_init",
            "dashicons-building",
            20
        );
    }
}

function remax_properties_install() {
    add_option('remax_properties_api_status', '' );
    add_option('remax_properties_token', '');
    add_option('remax_properties_page_url', '');
    add_option('remax_properties_agency_properties', '');
    add_option('remax_properties_featured', ['', '', '', '']);
}

function uninstall_remax_properties(){
    delete_option("remax_properties_token");
    delete_option("remax_properties_page_url");
    delete_option("remax_properties_api_status");
    delete_option("remax_properties_featured");
    delete_option("remax_properties_agency_properties");
}

if (!function_exists("remax_properties_init")){
    function remax_properties_init() {
        if (isset($_POST['submit']) && $_POST['submit'] == 'Y') {
            $token = $_POST['token'];
            $details_page = $_POST['details_page'];
            $api_status  = $_POST['api_status'];
            $agency_properties = $_POST['agency_properties'];
            
            update_option('remax_properties_agency_properties', $agency_properties);
            update_option('remax_properties_token', $token);
            update_option('remax_properties_page_url', $details_page);
            update_option('remax_properties_api_status', $api_status );
            update_option('remax_properties_featured', array(
                $_POST['featured_1'],
                $_POST['featured_2'],
                $_POST['featured_3'],
                $_POST['featured_4']
            ));
        }
        
        $token = get_option('remax_properties_token');
        $details_page = get_option('remax_properties_page_url');
        $api_status = get_option('remax_properties_api_status');
        $featured_properties =  get_option('remax_properties_featured');
        $agency_properties = get_option('remax_properties_agency_properties');

        require_once __DIR__ . "/templates/options_admin_page_config.php";
    }
}

if(!function_exists("remax_properties_search")) {
    function remax_properties_search() {
        $property = NEW Property;
        $provinces = $property->getAgentProvices();
        $properties_url = get_option('remax_properties_page_url');

        wp_enqueue_style("properties-search-styles", plugins_url("assets/css/search.css", __FILE__), array(), "1.0", "all");
        wp_enqueue_script("properties-search-js", plugins_url("assets/js/search.js", __FILE__), array('jquery'), "1.0", false);

        require_once __DIR__ . "/templates/search.php";
    }
}

if(!function_exists("remax_properties_slider")) {
    function remax_properties_slider() {
        $property = NEW Property;
        $properties = $property->getPropertiesData('properties');

        wp_enqueue_style("properties-slider-styles", plugins_url("assets/css/properties-slider-styles.css", __FILE__), array(), '1.0', "all");
        wp_enqueue_style("swiper-bundle-css", "https://unpkg.com/swiper@8/swiper-bundle.min.css", array(), "8.1.4", "all");
        wp_enqueue_script("swiper-bundle-scripts", "https://unpkg.com/swiper@8/swiper-bundle.min.js", array(), "8.1.4", false);
        wp_enqueue_script("properties-slider-scripts", plugins_url("assets/js/properties-slider-scripts.js", __FILE__), array('jquery'), '1.0', false);

        require_once __DIR__ . "/templates/properties-slider.php";
    }
}

if(!function_exists("remax_properties_featured")){
    function remax_properties_featured() {
        $property = NEW Property;
        $featured_properties = $property->getPropertiesData('featured');
        $page_url = get_option('home') . $_SERVER["REDIRECT_URL"];

        wp_enqueue_style("properties-featured-styles", plugins_url("assets/css/properties-featured-styles.css", __FILE__), array(), '1.0', "all");

        require_once __DIR__ . "/templates/featured-properties.php";
    }
}

if (!function_exists("remax_properties_front_page")) {
    function remax_properties_front_page() {
        $property = NEW Property;

        $page_url = get_option('home') . $_SERVER["REDIRECT_URL"];

        if (is_active_sidebar('rp_sidebar')) {
            $card_container_class = 'rp-content';
            wp_enqueue_style("property-styles", plugins_url("assets/css/property-styles.css", __FILE__), array(), '1.0', "all");
        } else {
            $card_container_class = '';
        }

        if(isset($_GET['code'])) {
            $property_code = $_GET['code'];
            $property_details = $property->getPropertiesData('property', $property_code);

            // echo "<pre>";
            // var_dump($property_details[0]->agents);
            // echo "</pre>";

            // echo "<pre>";
            // var_dump($featured_properties);
            // echo "</pre>";

            if ($property_details == '' || $property_details == NULL) {
                echo "<h2 style='text-align: center; width: 100%;'>Sin Resultados</h2>";
                return;
            }

            if (is_active_sidebar('rpd_sidebar') || isset($property_details[0]->agents)) {
                $card_container_class = 'rp-content';
                wp_enqueue_style("property-styles", plugins_url("assets/css/property-styles.css", __FILE__), array(), '1.0', "all");
            } else {
                $card_container_class = '';
            }

            wp_enqueue_style("property-details-css", plugins_url("assets/css/property-details-page.css", __FILE__), array(), '1.0', "all");
            wp_enqueue_style("swiper-bundle-css", "https://unpkg.com/swiper@8/swiper-bundle.min.css", array(), "8.1.4", "all");
            wp_enqueue_script("swiper-bundle-scripts", "https://unpkg.com/swiper@8/swiper-bundle.min.js", array(), "8.1.4", false);
            wp_enqueue_script("property-details-scripts", plugins_url("assets/js/property-details-page.js", __FILE__), array('jquery'), '1.0', false);

            require_once __DIR__ . "/templates/property-details-page.php";
        } else {
            $properties = $property->getPropertiesData('properties');
            
            if(!isset($properties->data[0])){
                echo "<h2 style='text-align: center; width: 100%;'>Sin Resultados</h2>";
                return;
            }
            
            if (is_active_sidebar('rpl_sidebar')) {
                $card_container_class = 'rp-content';
                wp_enqueue_style("property-styles", plugins_url("assets/css/property-styles.css", __FILE__), array(), '1.0', "all");
            } else {
                $card_container_class = '';
            }

            $page_url = get_option('home') . $_SERVER["REDIRECT_URL"];
            
            wp_enqueue_style("property-listing-page", plugins_url("assets/css/property-listing-page.css", __FILE__), array(), '1.0', "all");
            
            require_once __DIR__ . "/templates/property-listing-page.php";
        }
    }
}

add_action('widgets_init', 'remax_properties_sidebars');

function remax_properties_sidebars() {
    register_sidebar( array(
        'name'          => 'Remax Properties Listing Sidebar',
        'id'            => 'rpl_sidebar',
        'before_widget' => '<div class="rp-sidebar__content">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="rp-sidebar__title">',
        'after_title'   => '</div>'
    ));

    register_sidebar(array(
        'name'          => 'Remax Property Details Sidebar',
        'id'            => 'rpd_sidebar',
        'before_widget' => '<div class="rp-sidebar__content">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="rp-sidebar__title">',
        'after_title'   => '</div>'
    ));

    register_sidebar(array(
        'name'          => 'Remax Properties Footerbar',
        'id'            => 'rp_footerbar',
        'before_widget' => '<div class="rp-footerbar__content">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="rp-footerbar__title">',
        'after_title'   => '</div>'
    ));
}