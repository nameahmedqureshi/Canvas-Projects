<?php

// Search by first name
if (!empty($_GET['first_name'])) {
    $first_name = [
        [
            'key'     => 'name', 
            'value'   => sanitize_text_field($_GET['first_name']), 
            'compare' => 'LIKE'
        ]
    ];
}

// Search by surname
if (!empty($_GET['surname'])) {
    $surname = [
        [
            'key'     => 'surname',
            'value'   => sanitize_text_field($_GET['surname']),
            'compare' => 'LIKE'
        ]
    ];
}

// Search by county
if (!empty($_GET['county'])) {
    $county = [
        [
            'key'     => 'country',
            'value'   => sanitize_text_field($_GET['county']),
            'compare' => '='
        ]
    ];
}

// Search by category
if (!empty($_GET['cat_type'])) {
    $cat_type = [
        [
            'taxonomy' => 'death-notice-category', // Replace with your actual taxonomy slug
            'field'    => 'slug', // Can be 'id' if filtering by term ID
            'terms'    => sanitize_text_field($_GET['cat_type']),
            'operator' => 'IN',
        ]
    ];
}

// Set default date range (last one month)
$default_from_date = date('Y-m-d', strtotime('-1 month')); // One month before today
$default_to_date   = date('Y-m-d'); // Today

// Check if 'from_date' is provided in the URL
if (!empty($_GET['from'])) {
    
    $from_date = [
        [
            'after' => sanitize_text_field($_GET['from']),
            'inclusive' => true 
        ]
    ];
}  else {
    // Use default 'from_date' if not provided
    $from_date = [
        [
            'after'     => $default_from_date,
            'inclusive' => true,
        ],
    ];
}

// Check if 'to_date' is provided in the URL
if (!empty($_GET['to'])) {
    $to_date = [
        [
            'before' => sanitize_text_field($_GET['to']),
            'inclusive' => true
        ]
    ];
} else {
    // Use default 'to_date' if not provided
    $to_date = [
        [
            'before'    => $default_to_date,
            'inclusive' => true,
        ],
    ];
}


$args = array(
    'post_type'      => 'cpt-death-notice',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [$first_name, $surname, $county, $cat_type],
    'tax_query'      => [$cat_type],
    'date_query'     => [$from_date , $to_date]
);

// var_dump($args);

$death_notices = new WP_Query($args);
?>

<table id="deathNotic" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Town</th>
            <th>County</th>
            <th>Published</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($death_notices->have_posts()) :
            while ($death_notices->have_posts()) : 
                $death_notices->the_post();
                $metaData = get_post_meta(get_the_ID());
        ?>
        <tr>
            <td>
                <a href="<?= esc_url(home_url('death-notice-details/?slug=' . get_the_ID())) ?>">
                    <?= esc_html($metaData['name'][0] ?? 'No Name') ?>
                </a>
            </td>
            <td><?= esc_html($metaData['town'][0] ?? 'N/A') ?></td>
            <td><?= esc_html($metaData['country'][0] ?? 'N/A') ?></td>
            <td><?= get_the_date('d M Y') ?></td>
            </tr>
        <?php 
            endwhile;
            wp_reset_postdata();
        else:
        ?>
        <tr><td></td><td colspan="4" style="text-align: center;">No death notices found.</td><td></td><td></td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    new DataTable('#deathNotic');
</script>
