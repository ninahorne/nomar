<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ninahorne.io
 * @since             1.0.0
 * @package           Nomar_Events
 *
 * @wordpress-plugin
 * Plugin Name:       NOMAR Events
 * Plugin URI:        https://nomar.org
 * Description:       This is a custom plugin for NOMAR to display events from Tangilla. 
 * Version:           1.0.0
 * Author:            Nina Horne
 * Author URI:        https://ninahorne.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nomar-events
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('NOMAR_EVENTS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nomar-events-activator.php
 */
function activate_nomar_events()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-nomar-events-activator.php';
	Nomar_Events_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nomar-events-deactivator.php
 */
function deactivate_nomar_events()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-nomar-events-deactivator.php';
	Nomar_Events_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_nomar_events');
register_deactivation_hook(__FILE__, 'deactivate_nomar_events');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-nomar-events.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nomar_events()
{

	$plugin = new Nomar_Events();
	$plugin->run();
}
run_nomar_events();



function events_calendar_shortcode()
{

	include __DIR__ .  "/templates/events-calendar.php";
}

// Step 3: Register the shortcode
add_shortcode('events_calendar', 'events_calendar_shortcode');


// Create and register the post type for Events
function create_post_type_events()
{
	register_post_type(
		'events',
		array(
			'labels' => array(
				'name' => __('Events'),
				'singular_name' => __('Events')
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'events'),
			'supports' => array('custom-fields')
		)
	);
}


add_action('init', 'create_post_type_events');
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group(array(
		'key' => 'group_event_details',
		'title' => 'Event Details',
		'fields' => array(
			array(
				'key' => 'field_capacity',
				'label' => 'Capacity',
				'name' => 'capacity',
				'type' => 'number',
				'required' => 1,
			),
			array(
				'key' => 'field_ce',
				'label' => 'CE',
				'name' => 'ce',
				'type' => 'true_false',
				'required' => 1,
			),
			array(
				'key' => 'field_ce_credits',
				'label' => 'CE Credits',
				'name' => 'ce_credits',
				'type' => 'number',
				'required' => 0,
			),
			array(
				'key' => 'field_ce_type_name',
				'label' => 'CE Type Name',
				'name' => 'ce_type_name',
				'type' => 'text',
				'required' => 0,
			),
			array(
				'key' => 'field_course_id',
				'label' => 'Course ID',
				'name' => 'course_id',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_course_image',
				'label' => 'Course Image',
				'name' => 'course_image',
				'type' => 'url',
				'required' => 0,
			),
			array(
				'key' => 'field_course_number',
				'label' => 'Course Number',
				'name' => 'course_number',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_early_bird_end_date',
				'label' => 'Early Bird End Date',
				'name' => 'early_bird_end_date',
				'type' => 'date_picker',
				'required' => 0,
			),
			array(
				'key' => 'field_early_bird_member_price',
				'label' => 'Early Bird Member Price',
				'name' => 'early_bird_member_price',
				'type' => 'number',
				'required' => 0,
			),
			array(
				'key' => 'field_early_bird_price',
				'label' => 'Early Bird Price',
				'name' => 'early_bird_price',
				'type' => 'number',
				'required' => 0,
			),
			array(
				'key' => 'field_early_bird_pricing',
				'label' => 'Early Bird Pricing',
				'name' => 'early_bird_pricing',
				'type' => 'true_false',
				'required' => 0,
			),
			array(
				'key' => 'field_end_time',
				'label' => 'End Time',
				'name' => 'end_time',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_event_date',
				'label' => 'Event Date',
				'name' => 'event_date',
				'type' => 'date_picker',
				'required' => 1,
			),
			array(
				'key' => 'field_event_description',
				'label' => 'Event Description',
				'name' => 'event_description',
				'type' => 'textarea',
				'required' => 1,
			),
			array(
				'key' => 'field_event_id',
				'label' => 'Event ID',
				'name' => 'event_id',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_event_title',
				'label' => 'Event Title',
				'name' => 'event_title',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_event_type',
				'label' => 'Event Type',
				'name' => 'event_type',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_instructor2_bio',
				'label' => 'Instructor 2 Bio',
				'name' => 'instructor2_bio',
				'type' => 'textarea',
				'required' => 0,
			),
			array(
				'key' => 'field_instructor2_image',
				'label' => 'Instructor 2 Image',
				'name' => 'instructor2_image',
				'type' => 'url',
				'required' => 0,
			),
			array(
				'key' => 'field_instructor2_name',
				'label' => 'Instructor 2 Name',
				'name' => 'instructor2_name',
				'type' => 'text',
				'required' => 0,
			),
			array(
				'key' => 'field_instructor_bio',
				'label' => 'Instructor Bio',
				'name' => 'instructor_bio',
				'type' => 'textarea',
				'required' => 1,
			),
			array(
				'key' => 'field_instructor_image',
				'label' => 'Instructor Image',
				'name' => 'instructor_image',
				'type' => 'url',
				'required' => 0,
			),
			array(
				'key' => 'field_instructor_name',
				'label' => 'Instructor Name',
				'name' => 'instructor_name',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_last_updated',
				'label' => 'Last Updated',
				'name' => 'last_updated',
				'type' => 'date_picker',
				'required' => 0,
			),
			array(
				'key' => 'field_location',
				'label' => 'Location',
				'name' => 'location',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_location_address',
				'label' => 'Location Address',
				'name' => 'location_address',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_location_notes',
				'label' => 'Location Notes',
				'name' => 'location_notes',
				'type' => 'textarea',
				'required' => 0,
			),
			array(
				'key' => 'field_location_type',
				'label' => 'Location Type',
				'name' => 'location_type',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_member_only',
				'label' => 'Member Only',
				'name' => 'member_only',
				'type' => 'true_false',
				'required' => 0,
			),
			array(
				'key' => 'field_member_price',
				'label' => 'Member Price',
				'name' => 'member_price',
				'type' => 'number',
				'required' => 0,
			),
			array(
				'key' => 'field_online_registration',
				'label' => 'Online Registration',
				'name' => 'online_registration',
				'type' => 'true_false',
				'required' => 1,
			),
			array(
				'key' => 'field_price',
				'label' => 'Price',
				'name' => 'price',
				'type' => 'number',
				'required' => 1,
			),
			array(
				'key' => 'field_provider_name',
				'label' => 'Provider Name',
				'name' => 'provider_name',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_provider_number',
				'label' => 'Provider Number',
				'name' => 'provider_number',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_registered',
				'label' => 'Registered',
				'name' => 'registered',
				'type' => 'number',
				'required' => 0,
			),
			array(
				'key' => 'field_registration_close',
				'label' => 'Registration Close',
				'name' => 'registration_close',
				'type' => 'date_picker',
				'required' => 1,
			),
			array(
				'key' => 'field_registration_link',
				'label' => 'Registration Link',
				'name' => 'registration_link',
				'type' => 'url',
				'required' => 0,
			),
			array(
				'key' => 'field_room',
				'label' => 'Room',
				'name' => 'room',
				'type' => 'text',
				'required' => 0,
			),
			array(
				'key' => 'field_room_notes',
				'label' => 'Room Notes',
				'name' => 'room_notes',
				'type' => 'textarea',
				'required' => 0,
			),
			array(
				'key' => 'field_secondary_ce_credits',
				'label' => 'Secondary CE Credits',
				'name' => 'secondary_ce_credits',
				'type' => 'text',
				'required' => 0,
			),
			array(
				'key' => 'field_secondary_ce_type_name',
				'label' => 'Secondary CE Type Name',
				'name' => 'secondary_ce_type_name',
				'type' => 'text',
				'required' => 0,
			),
			array(
				'key' => 'field_segment_applied',
				'label' => 'Segment Applied',
				'name' => 'segment_applied',
				'type' => 'true_false',
				'required' => 0,
			),
			array(
				'key' => 'field_start_time',
				'label' => 'Start Time',
				'name' => 'start_time',
				'type' => 'text',
				'required' => 1,
			),
			array(
				'key' => 'field_tags',
				'label' => 'Tags',
				'name' => 'tags',
				'type' => 'text',
				'required' => 0,
			),
			array(
				'key' => 'field_time_zone',
				'label' => 'Time Zone',
				'name' => 'time_zone',
				'type' => 'text',
				'required' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));
}
