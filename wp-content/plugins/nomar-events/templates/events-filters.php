<?php

$event_type = $atts['event_type'];

// Get the current date in 'Y-m-d' format
$today = date('Ymd');

// Get categories associated with events of the specified type
$event_categories = get_terms(array(
  'taxonomy' => 'category',
  'hide_empty' => false,
  'fields' => 'all', // Retrieve all fields
));

// Fetch all event posts with the specified event type
$events = get_posts(array(
  'post_type' => 'events',
  'posts_per_page' => -1,
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'event_type',
      'value' => $event_type,
      'compare' => '=',
    ),
    array(
      'key' => 'event_date', // Assuming 'event_date' is the field for the event date
      'value' => $today,
      'compare' => '>=',
      'type' => 'DATE'
    ),
  ),
));

$locations = [];
$filtered_categories = [];

// Collect locations and filter categories based on event type
foreach ($events as $event) {
  $location = get_field('location', $event->ID);
  $categories = wp_get_post_categories($event->ID);

  if ($location && !in_array($location, $locations)) {
    $locations[] = $location;
  }

  foreach ($categories as $cat_id) {
    if (!in_array($cat_id, $filtered_categories)) {
      $filtered_categories[] = $cat_id;
    }
  }
}

// Filter event categories to only include those associated with the filtered events
$filtered_event_categories = array_filter($event_categories, function ($category) use ($filtered_categories) {
  return in_array($category->term_id, $filtered_categories);
});

// Get the URL parameters for category and location
$selected_cat = isset($_GET['cat']) ? intval($_GET['cat']) : '';
$selected_loc = isset($_GET['loc']) ? sanitize_text_field($_GET['loc']) : '';

ob_start(); // Start output buffering
?>

<form id="filters">
  <!-- Category Dropdown -->
  <select id="category" name="cat">
    <option value="">All Categories</option>
    <?php foreach ($filtered_event_categories as $category): ?>
      <option value="<?php echo esc_attr($category->name); ?>" <?php selected($category->term_id, $selected_cat); ?>>
        <?php echo esc_html($category->name); ?>
      </option>
    <?php endforeach; ?>
  </select>

  <!-- Location Dropdown -->
  <select id="location" name="loc">
    <option value="">All Locations</option>
    <?php foreach ($locations as $location): ?>
      <option value="<?php echo esc_attr($location); ?>" <?php selected($location, $selected_loc); ?>>
        <?php echo esc_html($location); ?>
      </option>
    <?php endforeach; ?>
  </select>
</form>