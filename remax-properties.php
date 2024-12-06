<?php
/**
 * Plugin Name:       Remax RD Properties
 * Description:       Shows the properties published on the Remax RD platforms. 
 * Version:           1.2.0
 * Requires at least: 5.9.3
 * Requires PHP:      7.4
 * Text Domain:       remax-properties
 * Author:            Version Do
 * Author URI:        https://version.do
 **/

defined("ABSPATH") or die;
define("PLUGIN_REMAXRD_PROPERTIES_URL", plugins_url('', __FILE__));

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

        $city = isset($_GET['province']) ? $_GET['province'] : '';
        $minPrice = isset($_GET['min-price']) ? $_GET['min-price'] : '';
        $maxPrice = isset($_GET['max-price']) ? $_GET['max-price'] : '';

        if(!isset($_GET['currency']) || $_GET['currency'] == 'us' || $_GET['currency'] == '') {
            $currency = 'us';
        }

        if(isset($_GET['currency']) && $_GET['currency'] == 'rd' ) {
            $currency = 'rd';
        }

        $isExclusive = '';
        if(isset($_GET['exclusive']) && $_GET['exclusive'] !== '' ) {
            $isExclusive = true;
        }

        wp_enqueue_style("properties-search-styles", plugins_url("assets/css/search.css", __FILE__), array(), "1.0", "all");
        wp_enqueue_script("properties-search-js", plugins_url("assets/js/search.js", __FILE__), array('jquery'), "1.0", false);

        ob_start();
        require_once __DIR__ . "/templates/search.php";
        return ob_get_clean();
    }
}

if(!function_exists("remax_properties_slider")) {
    function remax_properties_slider() {
        $property = NEW Property;
        $properties = $property->getPropertiesData('properties');

        // echo "<pre>";
        // var_dump($properties->data);
        // echo "</pre>";

        wp_enqueue_style("properties-slider-styles", plugins_url("assets/css/properties-slider-styles.css", __FILE__), array(), '1.0', "all");
        wp_enqueue_style("swiper-bundle-css", "https://unpkg.com/swiper@8/swiper-bundle.min.css", array(), "8.1.4", "all");
        wp_enqueue_script("swiper-bundle-scripts", "https://unpkg.com/swiper@8/swiper-bundle.min.js", array(), "8.1.4", true);
        wp_enqueue_script("properties-slider-scripts", plugins_url("assets/js/properties-slider-scripts.js", __FILE__), array('jquery'), '1.0', true);

        ob_start();
        require_once __DIR__ . "/templates/properties-slider.php";
        return ob_get_clean();
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
        
        if(isset($_GET['property-id']) && $_GET['property-id'] !== '' ) {
            $url = get_option('remax_properties_page_url');
            $property_url = $url . "?code=" . $_GET['property-id'];  
            wp_redirect($property_url);
            
            exit;
        }


        $property = NEW Property;

        $page_url = get_option('home') . $_SERVER["REDIRECT_URL"];

        $card_container_class = '';
        if (is_active_sidebar('rp_sidebar')) {
            $card_container_class = 'rp-content';
            wp_enqueue_style("property-styles", plugins_url("assets/css/property-styles.css", __FILE__), array(), '1.0', "all");
        }

        // wp_enqueue_style("property-listing-bootstrap", "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css", array(), '1.0', "all");

        if(isset($_GET['code'])) {
            $property_code = $_GET['code'];
            $property_details = $property->getPropertiesData('property', $property_code);

            // echo "<pre>";
            // var_dump($property_details);
            // echo "</pre>";

            // echo "<pre>";
            // var_dump($featured_properties);
            // echo "</pre>";

            if ($property_details == '' || $property_details == NULL) {
                echo "<h2 style='text-align: center; width: 100%;'>Sin Resultados</h2>";
                return;
            }

            $card_container_class = '';
            if (is_active_sidebar('rpd_sidebar') || isset($property_details->data->agent_list[0])) {
                $card_container_class = 'rp-content';
            }
            wp_enqueue_style("property-agents-styles", plugins_url("assets/css/property-styles.css", __FILE__), array(), '1.0', "all");

            if(!isset($property_details->data)){
                return "<p style='text-align: left; width: 100%;'>Error al obtener los datos de esta propiedad. Por favor recargue la página o verifique si el código de la propiedad está correcto.</p>";
            }
            
            $property_details = $property_details->data;
            // echo "<pre>";
            // var_dump(plugins_url("assets/css/property-details-page.css", __FILE__));
            // echo "</pre>";

            wp_enqueue_style("property-details-css", plugins_url("assets/css/property-details-page.css", __FILE__), array(), '1.0');

            wp_enqueue_style("swiper-bundle-css", "https://unpkg.com/swiper@8/swiper-bundle.min.css", array(), "8.1.4", "all");
            wp_enqueue_script("swiper-bundle-scripts", "https://unpkg.com/swiper@8/swiper-bundle.min.js", array(), "8.1.4", true);
            wp_enqueue_script("property-details-scripts", plugins_url("assets/js/property-details-page.js", __FILE__), array('jquery'), '1.0', true);

            ob_start();
            require_once __DIR__ . "/templates/property-details-page.php";
            return ob_get_clean();
        }

        $properties = $property->getPropertiesData('properties');

        // do_action('logger', $properties);
        // echo "<pre>";
        // var_dump($properties);
        // echo "</pre>";

        $haveResult = isset($properties->data[0]);
        
        $card_container_class = '';
        if (is_active_sidebar('rpl_sidebar')) {
            $card_container_class = 'rp-content';
        }
        wp_enqueue_style("property-styles", plugins_url("assets/css/property-styles.css", __FILE__), array(), '1.0', "all");

        $page_url = get_option('home') . $_SERVER["REDIRECT_URL"];

        // var_dump(plugins_url("assets/css/property-listing-page.css", __FILE__));
        
        wp_enqueue_style("property-listing-page", plugins_url("assets/css/property-listing-page.css", __FILE__), array(), '1.0', "all");
        // echo "<pre>";
        // var_dump($klk);
        // echo "</pre>";
        ob_start();
        require_once __DIR__ . "/templates/property-listing-page.php";
        return ob_get_clean();
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