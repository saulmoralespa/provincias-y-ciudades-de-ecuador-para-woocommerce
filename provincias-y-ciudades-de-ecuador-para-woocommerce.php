<?php
/**
 * Plugin Name: Provincias y Ciudades de Ecuador para Woocommerce
 * Description: Plugin modificado con las provincias y ciudades de Ecuador
 * Version: 1.0.0
 * Author: Saul Morales Pacheco
 * Author URI: https://saulmoralespa.com
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: provincias-y-ciudades-de-ecuador-para-woocommerce
 * Domain Path: /languages
 * WC tested up to: 8.0.3
 * WC requires at least: 4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if(!defined('PROVINCIAS_CIUDADES_ECUADOR_PARA_WOOCOMMERCE_VERSION')){
    define('PROVINCIAS_CIUDADES_ECUADOR_PARA_WOOCOMMERCE_VERSION', '1.0.0');
}

add_action('plugins_loaded','states_places_ecuador_init');
add_action( 'admin_enqueue_scripts', 'enqueue_scripts_admin');

function states_places_ecuador_smp_notices($notice){
    ?>
    <div class="error notice">
        <p><?php echo $notice; ?></p>
    </div>
    <?php
}

function states_places_ecuador_init(){

    load_plugin_textdomain('provincias-y-ciudades-de-ecuador-para-woocommerce',
        FALSE, dirname(plugin_basename(__FILE__)) . '/languages');

    if(!provincias_ciudades_ecuador_para_woocommerce_requirements()) return;

    if ( ! function_exists( 'is_plugin_active' ) ) require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

    if (!class_exists('WC_States_Places_Ecuador')) require_once ('includes/states-places.php');
    if (!function_exists('filters_by_cities_method')) require_once ('includes/filter-by-cities.php');
    /**
     * Instantiate class
     */
    $GLOBALS['wc_states_places'] = new WC_States_Places_Ecuador(__FILE__);

    add_filter( 'woocommerce_shipping_methods', 'add_filters_by_cities_method' );

    function add_filters_by_cities_method( $methods ) {
        $methods['filters_by_cities_shipping_method'] = 'Filters_By_Cities_Method';
        return $methods;
    }

    add_action( 'woocommerce_shipping_init', 'filters_by_cities_method' );
}

function provincias_ciudades_ecuador_para_woocommerce_requirements(){

    if ( ! is_plugin_active(
        'woocommerce/woocommerce.php'
    ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() {
                    states_places_ecuador_smp_notices( 'Provincias y Ciudades de Ecuador para Woocommerce requiere que se encuentre instalado y activo el plugin: Woocommerce' );
                }
            );
        }
        return false;
    }

    $woo_countries   = new WC_Countries();
    $default_country = $woo_countries->get_base_country();

    if ( ! in_array( $default_country, array( 'EC' ), true ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() {
                    $country = 'Provincias y Ciudades de Ecuador para Woocommerce requiere que el país donde se encuentra ubicada la tienda sea Ecuador '  .
                        sprintf(
                            '%s',
                            '<a href="' . admin_url() .
                            'admin.php?page=wc-settings&tab=general#s2id_woocommerce_currency">' .
                            'Click para establecer</a>' );
                    states_places_ecuador_smp_notices( $country );
                }
            );
        }
        return false;
    }

    return true;
}

function enqueue_scripts_admin($hook){
    if ($hook === 'woocommerce_page_wc-settings'){
        wp_enqueue_script( 'provincias_ciudades_ecuador_para_woocommerce_rules', trailingslashit( plugin_dir_url( __FILE__ ) ). 'js/rules-shipping.js', array( 'jquery' ), PROVINCIAS_CIUDADES_ECUADOR_PARA_WOOCOMMERCE_VERSION, true );
    }
}


add_filter( 'woocommerce_default_address_fields', 'states_places_ecuador_smp_woocommerce_default_address_fields', 1000, 1 );

function states_places_ecuador_smp_woocommerce_default_address_fields( $fields ) {
    if ($fields['city']['priority'] < $fields['state']['priority']){
        $state_priority = $fields['state']['priority'];
        $fields['state']['priority'] = $fields['city']['priority'];
        $fields['city']['priority'] = $state_priority;

    }
    return $fields;
}