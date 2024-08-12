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
			'has_archive' => true,
			'rewrite' => array('slug' => 'events'),
			'supports' => array('custom-fields', 'title', 'editor')
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

// function unschedule_tangilla_sync() {
// 	$timestamp = wp_next_scheduled('tangilla_sync_event');
// 	if ($timestamp) {
// 			wp_unschedule_event($timestamp, 'tangilla_sync_event');
// 	}
// }
// add_action('shutdown', 'unschedule_tangilla_sync');
