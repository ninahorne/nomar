<?php

/**
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
 * The code that runs during plugin activation.
 */
function activate_nomar_events()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-nomar-events-activator.php';
	Nomar_Events_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
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

add_shortcode('events_calendar', 'events_calendar_shortcode');

// Create and register the post type for Events
function create_post_type_events()
{
	register_post_type(
		'events',
		array(
			'labels' => array(
				'name' => __('Events'),
				'singular_name' => __('Event')
			),
			'public' => true,
			'has_archive' => 'events-archive', // Archive will be accessible at /events-archive
			'rewrite' => array('slug' => 'events'), // Single posts will be at /events/{post-name}
			'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions'),
			'taxonomies' => array('category', 'post_tag'), // Adds support for categories and tags
			'show_in_rest' => true, // Enables Gutenberg editor support
		)
	);
}
add_action('init', 'create_post_type_events');

// Register ACF Fields if ACF is installed and active
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
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_ce',
				'label' => 'CE',
				'name' => 'ce',
				'type' => 'true_false',
				'show_in_rest' => true,
			),

			array(
				'key' => 'field_ce_credits',
				'label' => 'CE Credits',
				'name' => 'ce_credits',
				'type' => 'number',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_ce_type_name',
				'label' => 'CE Type Name',
				'name' => 'ce_type_name',
				'type' => 'text',
				'show_in_rest' => true,
				'required' => 0
			),
			array(
				'key' => 'field_course_id',
				'label' => 'Course ID',
				'name' => 'course_id',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_course_image',
				'label' => 'Course Image',
				'name' => 'course_image',
				'type' => 'url',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_course_number',
				'label' => 'Course Number',
				'name' => 'course_number',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_early_bird_end_date',
				'label' => 'Early Bird End Date',
				'name' => 'early_bird_end_date',
				'type' => 'date_picker',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_early_bird_member_price',
				'label' => 'Early Bird Member Price',
				'name' => 'early_bird_member_price',
				'type' => 'number',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_early_bird_price',
				'label' => 'Early Bird Price',
				'name' => 'early_bird_price',
				'type' => 'number',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_early_bird_pricing',
				'label' => 'Early Bird Pricing',
				'name' => 'early_bird_pricing',
				'type' => 'true_false',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_end_time',
				'label' => 'End Time',
				'name' => 'end_time',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_event_date',
				'label' => 'Event Date',
				'name' => 'event_date',
				'type' => 'date_picker',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_event_description',
				'label' => 'Event Description',
				'name' => 'event_description',
				'type' => 'textarea',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_event_id',
				'label' => 'Event ID',
				'name' => 'event_id',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_event_title',
				'label' => 'Event Title',
				'name' => 'event_title',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_event_type',
				'label' => 'Event Type',
				'name' => 'event_type',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_instructor2_bio',
				'label' => 'Instructor 2 Bio',
				'name' => 'instructor2_bio',
				'type' => 'textarea',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_instructor2_image',
				'label' => 'Instructor 2 Image',
				'name' => 'instructor2_image',
				'type' => 'url',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_instructor2_name',
				'label' => 'Instructor 2 Name',
				'name' => 'instructor2_name',
				'type' => 'text',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_instructor_bio',
				'label' => 'Instructor Bio',
				'name' => 'instructor_bio',
				'type' => 'textarea',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_instructor_image',
				'label' => 'Instructor Image',
				'name' => 'instructor_image',
				'type' => 'url',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_instructor_name',
				'label' => 'Instructor Name',
				'name' => 'instructor_name',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_last_updated',
				'label' => 'Last Updated',
				'name' => 'last_updated',
				'type' => 'date_picker',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_location',
				'label' => 'Location',
				'name' => 'location',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_location_address',
				'label' => 'Location Address',
				'name' => 'location_address',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_location_notes',
				'label' => 'Location Notes',
				'name' => 'location_notes',
				'type' => 'textarea',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_location_type',
				'label' => 'Location Type',
				'name' => 'location_type',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_member_only',
				'label' => 'Member Only',
				'name' => 'member_only',
				'type' => 'true_false',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_member_price',
				'label' => 'Member Price',
				'name' => 'member_price',
				'type' => 'number',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_online_registration',
				'label' => 'Online Registration',
				'name' => 'online_registration',
				'type' => 'true_false',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_price',
				'label' => 'Price',
				'name' => 'price',
				'type' => 'number',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_provider_name',
				'label' => 'Provider Name',
				'name' => 'provider_name',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_provider_number',
				'label' => 'Provider Number',
				'name' => 'provider_number',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_registered',
				'label' => 'Registered',
				'name' => 'registered',
				'type' => 'number',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_registration_close',
				'label' => 'Registration Close',
				'name' => 'registration_close',
				'type' => 'date_picker',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_registration_link',
				'label' => 'Registration Link',
				'name' => 'registration_link',
				'type' => 'url',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_room',
				'label' => 'Room',
				'name' => 'room',
				'type' => 'text',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_room_notes',
				'label' => 'Room Notes',
				'name' => 'room_notes',
				'type' => 'textarea',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_secondary_ce_credits',
				'label' => 'Secondary CE Credits',
				'name' => 'secondary_ce_credits',
				'type' => 'text',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_secondary_ce_type_name',
				'label' => 'Secondary CE Type Name',
				'name' => 'secondary_ce_type_name',
				'type' => 'text',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_segment_applied',
				'label' => 'Segment Applied',
				'name' => 'segment_applied',
				'type' => 'true_false',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_start_time',
				'label' => 'Start Time',
				'name' => 'start_time',
				'type' => 'text',
				'show_in_rest' => true,

			),
			array(
				'key' => 'field_tags',
				'label' => 'Tags',
				'name' => 'tags',
				'type' => 'text',
				'show_in_rest' => true,
				'required' => 0,
			),
			array(
				'key' => 'field_time_zone',
				'label' => 'Time Zone',
				'name' => 'time_zone',
				'type' => 'text',
				'show_in_rest' => true,

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

// Function to update all custom fields
function update_all_custom_fields($post_id, $event_data)
{
	// Update all custom fields
	update_post_meta($post_id, 'capacity', $event_data['capacity']);
	update_post_meta($post_id, 'ce', $event_data['ce']);
	update_post_meta($post_id, 'ce_credits', $event_data['ce_credits']);
	update_post_meta($post_id, 'ce_type_name', $event_data['ce_type_name']);
	update_post_meta($post_id, 'course_id', $event_data['course_id']);
	update_post_meta($post_id, 'course_image', $event_data['course_image']);
	update_post_meta($post_id, 'course_number', $event_data['course_number']);
	update_post_meta($post_id, 'early_bird_end_date', $event_data['early_bird_end_date']);
	update_post_meta($post_id, 'early_bird_member_price', $event_data['early_bird_member_price']);
	update_post_meta($post_id, 'early_bird_price', $event_data['early_bird_price']);
	update_post_meta($post_id, 'early_bird_pricing', $event_data['early_bird_pricing']);
	update_post_meta($post_id, 'end_time', $event_data['end_time']);
	update_post_meta($post_id, 'event_date', $event_data['event_date']);
	update_post_meta($post_id, 'event_description', $event_data['event_description']);
	update_post_meta($post_id, 'event_id', $event_data['event_id']);
	update_post_meta($post_id, 'event_title', $event_data['event_title']);
	update_post_meta($post_id, 'event_type', $event_data['event_type']);
	update_post_meta($post_id, 'instructor2_bio', $event_data['instructor2_bio']);
	update_post_meta($post_id, 'instructor2_image', $event_data['instructor2_image']);
	update_post_meta($post_id, 'instructor2_name', $event_data['instructor2_name']);
	update_post_meta($post_id, 'instructor_bio', $event_data['instructor_bio']);
	update_post_meta($post_id, 'instructor_image', $event_data['instructor_image']);
	update_post_meta($post_id, 'instructor_name', $event_data['instructor_name']);
	update_post_meta($post_id, 'last_updated', $event_data['last_updated']);
	update_post_meta($post_id, 'location', $event_data['location']);
	update_post_meta($post_id, 'location_address', $event_data['location_address']);
	update_post_meta($post_id, 'location_notes', $event_data['location_notes']);
	update_post_meta($post_id, 'location_type', $event_data['location_type']);
	update_post_meta($post_id, 'member_only', $event_data['member_only']);
	update_post_meta($post_id, 'member_price', $event_data['member_price']);
	update_post_meta($post_id, 'online_registration', $event_data['online_registration']);
	update_post_meta($post_id, 'price', $event_data['price']);
	update_post_meta($post_id, 'provider_name', $event_data['provider_name']);
	update_post_meta($post_id, 'provider_number', $event_data['provider_number']);
	update_post_meta($post_id, 'registered', $event_data['registered']);
	update_post_meta($post_id, 'registration_close', $event_data['registration_close']);
	update_post_meta($post_id, 'registration_link', $event_data['registration_link']);
	update_post_meta($post_id, 'room', $event_data['room']);
	update_post_meta($post_id, 'room_notes', $event_data['room_notes']);
	update_post_meta($post_id, 'secondary_ce_credits', $event_data['secondary_ce_credits']);
	update_post_meta($post_id, 'secondary_ce_type_name', $event_data['secondary_ce_type_name']);
	update_post_meta($post_id, 'segment_applied', $event_data['segment_applied']);
	update_post_meta($post_id, 'start_time', $event_data['start_time']);
	update_post_meta($post_id, 'tags', $event_data['tags']);
	update_post_meta($post_id, 'time_zone', $event_data['time_zone']);
}

// Manually include ACF fields as top-level fields in the REST API response for the 'events' post type
add_action('rest_api_init', function () {
	// List all the ACF field names that you want to expose as top-level fields
	$acf_field_names = array(
		'capacity',
		'ce',
		'ce_credits',
		'ce_type_name',
		'course_id',
		'course_image',
		'course_number',
		'early_bird_end_date',
		'early_bird_member_price',
		'early_bird_price',
		'early_bird_pricing',
		'end_time',
		'event_date',
		'event_description',
		'event_id',
		'event_title',
		'event_type',
		'instructor2_bio',
		'instructor2_image',
		'instructor2_name',
		'instructor_bio',
		'instructor_image',
		'instructor_name',
		'last_updated',
		'location',
		'location_address',
		'location_notes',
		'location_type',
		'member_only',
		'member_price',
		'online_registration',
		'price',
		'provider_name',
		'provider_number',
		'registered',
		'registration_close',
		'registration_link',
		'room',
		'room_notes',
		'secondary_ce_credits',
		'secondary_ce_type_name',
		'segment_applied',
		'start_time',
		'tags',
		'time_zone'
	);

	// Loop through each ACF field and add it as a top-level field in the REST API response
	foreach ($acf_field_names as $field_name) {
		register_rest_field('events', $field_name, array(
			'get_callback' => function ($post) use ($field_name) {
				return get_field($field_name, $post['id']);  // Get the value of the ACF field
			},
			'schema' => null,
		));
	}
});



// Function to sync events with the API
function sync_events_with_api()
{
	$api_url = 'https://api.tangilla.com/event/v1/feed/4420/live?include_current_month_events=true';
	$response = wp_remote_get($api_url);

	if (is_wp_error($response)) {
		error_log('Error fetching events from API: ' . $response->get_error_message());
		return;
	}

	$body = wp_remote_retrieve_body($response);
	$events_data = json_decode($body, true);

	if (empty($events_data)) {
		error_log('No events data received from API.');
		return;
	}

	$existing_events = new WP_Query(array(
		'post_type' => 'events',
		'posts_per_page' => -1,
		'post_status' => 'publish',
	));

	$existing_event_ids = array();
	$event_ids_to_keep = array();

	if ($existing_events->have_posts()) {
		while ($existing_events->have_posts()) {
			$existing_events->the_post();
			$post_id = get_the_ID();
			$event_id = get_post_meta($post_id, 'event_id', true);

			$matching_event = array_filter($events_data, function ($event) use ($event_id) {
				return $event['event_id'] == $event_id;
			});

			if (!empty($matching_event)) {
				$matching_event = reset($matching_event);

				wp_update_post(array(
					'ID' => $post_id,
					'post_title' => $matching_event['event_title'],
					'post_content' => $matching_event['event_description'],
				));

				update_all_custom_fields($post_id, $matching_event);
				$event_ids_to_keep[] = $event_id;
			} else {
				wp_delete_post($post_id, true);
			}

			$existing_event_ids[] = $event_id;
		}
	}

	wp_reset_postdata();

	foreach ($events_data as $event) {
		if (!in_array($event['event_id'], $existing_event_ids)) {
			$new_post_id = wp_insert_post(array(
				'post_type' => 'events',
				'post_title' => $event['event_title'],
				'post_content' => $event['event_description'],
				'post_status' => 'publish',
			));

			update_all_custom_fields($new_post_id, $event);
		}
	}
}

// Add the sync button to the admin bar on the events list page
function add_sync_events_button($which)
{
	global $post_type;

	if ($post_type === 'events' && $which === 'top') {
		$sync_url = wp_nonce_url(admin_url('edit.php?post_type=events&sync_events=1'), 'sync_events_nonce');
		echo '<div class="alignleft actions"><a href="' . esc_url($sync_url) . '" class="button button-primary">Sync Events with Tangilla</a></div>';
	}
}
add_action('manage_posts_extra_tablenav', 'add_sync_events_button');

// Handle the sync button click on the main events page
function handle_sync_events_main_page()
{
	if (isset($_GET['sync_events']) && check_admin_referer('sync_events_nonce')) {
		sync_events_with_api();

		wp_redirect(add_query_arg('synced', 'true', admin_url('edit.php?post_type=events')));
		exit;
	}
}
add_action('admin_init', 'handle_sync_events_main_page');

// Display a notice after sync
function sync_events_notice_main_page()
{
	if (isset($_GET['synced']) && $_GET['synced'] === 'true') {
		echo '<div class="notice notice-success is-dismissible"><p>Events have been synced with Tangilla.</p></div>';
	}
}
add_action('admin_notices', 'sync_events_notice_main_page');

function custom_cron_schedule($schedules)
{
	// Adds a new cron schedule for every 5 minutes
	$schedules['every_five_minutes'] = array(
		'interval' => 300, // 300 seconds = 5 minutes
		'display'  => esc_html__('Every 5 Minutes')
	);
	return $schedules;
}
add_filter('cron_schedules', 'custom_cron_schedule');

function schedule_tangilla_sync()
{
	if (!wp_next_scheduled('tangilla_sync_event')) {
		wp_schedule_event(time(), 'every_five_minutes', 'tangilla_sync_event');
	}
}
add_action('wp', 'schedule_tangilla_sync');

add_action('tangilla_sync_event', 'sync_events_with_api');


function make_acf_fields_read_only($field)
{
	$field['readonly'] = true; // Make the field read-only
	$field['disabled'] = true; // Disable the field, which will prevent editing

	// Set the value directly in the input HTML to retain the current value
	if (!empty($field['value'])) {
		$field['wrapper']['data-value'] = $field['value'];
	}

	return $field;
}
add_filter('acf/load_field', 'make_acf_fields_read_only');

function custom_admin_styles()
{
	echo '
	<style>
			.acf-field[data-value] input,
			.acf-field[data-value] textarea,
			.acf-field[data-value] select {
					background-color: #f1f1f1; /* Light grey background */
					pointer-events: none; /* Prevent interaction */
			}
	</style>
	';
}
add_action('admin_head', 'custom_admin_styles');

// function unschedule_tangilla_sync() {
// 	$timestamp = wp_next_scheduled('tangilla_sync_event');
// 	if ($timestamp) {
// 			wp_unschedule_event($timestamp, 'tangilla_sync_event');
// 	}
// }
// add_action('shutdown', 'unschedule_tangilla_sync');

// Hook into the save_post action to modify and save additional formats for specific fields
add_action('save_post', 'save_custom_formats_for_fields', 10, 3);

function save_custom_formats_for_fields($post_id, $post, $update)
{
	// Make sure this is for the 'events' post type
	if ($post->post_type !== 'events') {
		return;
	}

	// Avoid infinite loop
	remove_action('save_post', 'save_custom_formats_for_fields');

	// List of date fields and boolean fields to process
	$date_fields = array('event_date', 'early_bird_end_date', 'registration_close', 'last_updated');
	$boolean_fields = array('ce', 'early_bird_pricing', 'online_registration', 'member_only', 'segment_applied');
	$time_fields = array('start_time', 'end_time');

	// Process date fields
	foreach ($date_fields as $field) {
		$date_value = get_post_meta($post_id, $field, true);
		if (!empty($date_value)) {
			$formatted_date = date('D, F jS, Y', strtotime($date_value)); // Format: Mon, July 4th, 2024
			update_post_meta($post_id, $field . '_formatted', $formatted_date);
		}
	}

	// Process boolean fields
	foreach ($boolean_fields as $field) {
		$boolean_value = get_post_meta($post_id, $field, true);
		if ($boolean_value !== '') {
			$formatted_boolean = $boolean_value ? 'yes' : 'no'; // Convert to 'yes' or 'no'
			update_post_meta($post_id, $field . '_formatted', $formatted_boolean);
		} else {
			update_post_meta($post_id, $field . '_formatted', 'no');
		}
	}

	// Process time fields
	foreach ($time_fields as $field) {
		$time_value = get_post_meta($post_id, $field, true);
		if (!empty($time_value)) {
			$formatted_time = format_time($time_value); // Custom function to format time
			update_post_meta($post_id, $field . '_formatted', $formatted_time);
		}
	}

	// Re-add the action after processing
	add_action('save_post', 'save_custom_formats_for_fields', 10, 3);
}

// Custom function to format time (e.g., '09:00' to '9am' and '13:00' to '1pm')
function format_time($time)
{
	return strtolower(date('gA', strtotime($time)));
}

function add_custom_columns($columns)
{
	// Add new columns after the 'Title' column
	$columns['event_date'] = __('Event Date');
	$columns['event_type'] = __('Event Type');
	return $columns;
}
add_filter('manage_events_posts_columns', 'add_custom_columns');
function display_custom_columns($column, $post_id)
{
	switch ($column) {
		case 'event_date':
			$event_date = get_post_meta($post_id, 'event_date', true);
			echo $event_date ? esc_html($event_date) : __('N/A');
			break;
		case 'event_type':
			$event_type = get_post_meta($post_id, 'event_type', true);
			echo $event_type ? esc_html($event_type) : __('N/A');
			break;
	}
}
add_action('manage_events_posts_custom_column', 'display_custom_columns', 10, 2);
function make_custom_columns_sortable($columns)
{
	$columns['event_date'] = 'event_date';
	$columns['event_type'] = 'event_type';
	return $columns;
}
add_filter('manage_edit-events_sortable_columns', 'make_custom_columns_sortable');


// ** LOOPER PROVIDER STUFF ** //
// Custom Looper Provider for Cornerstone
add_filter('cs_looper_custom_my_data', function ($result, $params) {

	// Extract the parameters passed from the Looper's Params field
	global $captured_params;
	$category = isset($captured_params['c_cat']) ? sanitize_text_field($captured_params['c_cat']) : '';
	$location = isset($captured_params['loc']) ? sanitize_text_field($captured_params['loc']) : '';
	$event_type = isset($params['event_type']) ? sanitize_text_field($params['event_type']) : '';

	// Get today's date in the format needed for comparison (Ymd)
	$today = date('Ymd');

	// Basic query arguments
	$args = array(
		'post_type' => 'events',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation' => 'AND',
			// Filter for events today or in the future
			array(
				'key' => 'event_date',
				'value' => $today,
				'compare' => '>=',
				'type' => 'DATE',
			),
			// Filter by event type if provided
			array(
				'key' => 'event_type',
				'value' => $event_type,
				'compare' => '=',
			),
		),
		// Sort by event date, ascending (soonest to latest)
		'orderby' => 'meta_value',
		'meta_key' => 'event_date',
		'order' => 'ASC',
	);

	// Add category filter if provided
	if (!empty($category)) {
		// Check if tax_query already exists, and if so, append to it
		if (isset($args['tax_query'])) {
			$args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field' => 'name',
				'terms' => $category,
			);
		} else {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'name',
					'terms' => $category,
				),
			);
		}
	}

	// Add location filter if provided
	if (!empty($location)) {
		$args['meta_query'][] = array(
			'key' => 'location',
			'value' => $location,
			'compare' => '='
		);
	}

	// Perform the query
	$query = new WP_Query($args);
	$events = array();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$post = get_post();
			// Get all ACF fields for the post
			$acf_fields = get_fields();

			// If there are ACF fields, add them to the post object
			if ($acf_fields) {
				foreach ($acf_fields as $field_key => $field_value) {
					$post->$field_key = $field_value;
				}
			}
			// Add categories as well
			$post->category = wp_get_post_terms(get_the_ID(), 'category', array('fields' => 'names'));
			// Add the featured image URL
			$post->featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full'); // 'full' can be replaced with any size

			// Add the post object to the events array
			$events[] = $post;
		}
	}
	// Reset the global post data
	wp_reset_postdata();

	return $events;
}, 10, 2);


function events_filters_shortcode($atts)
{
	// Enqueue your JavaScript file
	wp_enqueue_script('events-filters', '/wp-content/plugins/nomar-events/public/js/events-filters.js', array(), null, true);

	ob_start();
	$atts = shortcode_atts(array(
		'event_type' => 'event', // Default to 'event' if not provided
	), $atts);

	// Include your PHP template file
	include __DIR__ . '/templates/events-filters.php';

	// Get the content from the output buffer and clean it
	return ob_get_clean();
}

add_shortcode('events_filters', 'events_filters_shortcode');


function add_custom_query_vars($vars)
{
	$vars[] = 'c_cat';
	$vars[] = 'loc';
	return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');

function capture_query_parameters()
{
	global $captured_params;

	$captured_params = array(
		'c_cat' => get_query_var('c_cat', ''),
		'loc' => get_query_var('loc', '')
	);
}
add_action('wp', 'capture_query_parameters');

function save_category_list_meta($post_id)
{
	// Check if this is an 'event' post type
	if (get_post_type($post_id) !== 'events') {
		return;
	}

	// Avoid infinite loops by checking if the post is being autosaved or a revision
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (wp_is_post_revision($post_id)) {
		return;
	}

	// Get the categories associated with the post
	$categories = wp_get_post_terms($post_id, 'category', array('fields' => 'names'));

	// Capitalize and create a comma-separated list
	$category_list = array_map('ucwords', $categories); // Capitalize each category name
	$category_list_string = implode(', ', $category_list); // Join them into a string

	// Update the post meta with the generated string
	update_post_meta($post_id, 'category_list', $category_list_string);
}
add_action('save_post', 'save_category_list_meta');

function add_category_names_to_events()
{
	register_rest_field('events', 'category_names', array(
		'get_callback' => function ($object) {
			$category_ids = wp_get_post_categories($object['id']);
			$categories = [];
			foreach ($category_ids as $category_id) {
				$category = get_category($category_id);
				if ($category) {
					$categories[] = $category->name;
				}
			}
			return $categories;
		},
		'schema' => null,
	));
}
add_action('rest_api_init', 'add_category_names_to_events');
