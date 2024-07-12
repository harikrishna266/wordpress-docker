<?php

/**
 * @link              https://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Builder
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       3D Builder for everything.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://fictive.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once (plugin_dir_path(__FILE__) . 'builder-url.php');
define( 'BUILDER_VERSION', '1.0.0' );
define('TEMPLATE_BUILDER_SLUG', 'template_builder');
define('PRINTING_AREAS_BUILDER_SLUG', 'printing_areas_builder');
define('PRINT_TYPES_BUILDER_SLUG', 'print_types_builder');
define('THREE_D_PRODUCTS_LISTING', 'User_custom_Products');
define('FASHION_DESIGNS_BUILDER_SLUG', 'fashion_designs_builder');
define('MODELS_BUILDER_SLUG', 'models_builder');
define('MODEL_PRINT_AREA_SLUG', 'model_print_areas');
define('PATTERNS_BUILDER_SLUG', 'patterns_builder');
define('DESIGN_LAYERS_SLUG', 'design_layers');
define('TAGS_SLUG', 'tags_builder');
define('PLUGIN_ROOT', plugin_dir_path( __FILE__));
define('PLUGIN_URL', plugins_url('public', __FILE__)."/");
define('FICTIVE_TABLE', 'fictive_');
define('DESIGN_SERIALIZED_DATA', '_serialized_data');
define('IS_CUSTOMIZABLE', '_is_customizable');
define('IS_PRIVATE', '_is_private_product');

 function activate_builder() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-builder-activator.php';
    $activator = new Builder_Activator();
    $activator->activate();;
}

function deactivate_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-builder-deactivator.php';
    Builder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_builder' );
register_deactivation_hook( __FILE__, 'deactivate_builder' );


require plugin_dir_path(__FILE__) . 'includes/class-admin-builder.php';

function run_admin_builder() {
	$plugin = new AdminBuilder();
	$plugin->run();
}

run_admin_builder();
