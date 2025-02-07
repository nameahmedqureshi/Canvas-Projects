<?php /* Template Name: Browse Profiles */ 
if(!is_user_logged_in()) {
    wp_redirect( home_url( 'login' ));
    exit;
}

get_header(); 

// if(current_user_can('helper')){ 
// Process search query
$search_string = isset( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : '';
$current_user_id = wp_get_current_user();
$user_type = get_user_meta($current_user_id->ID, 'user_type', true);
$subscription_plan = get_user_meta($current_user_id->ID, 'subscription_plan', true);
var_dump($user_type );
var_dump($subscription_plan );
if($search_string){
    $users = new WP_User_Query( array(
        'role_in'     => array('farmer', 'supplier', ' restaurant'),
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => 'full_name',
                'value'   => $search_string,
                'compare' => 'LIKE'
            ),
        )
    ) );
}
if(in_array('farmer', $current_user_id->roles)){
    $users = new WP_User_Query( array(
        'role_in'     => array('supplier', 'restaurant'),
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => 'subscription_plan',
                'value'   => $subscription_plan,
                'compare' => '='
            ),
            array(
                'key'     => 'start_featured_date',
                'value'   => date('Y-m-d'),
                'compare' => '>'
            ),
            array(
                'key'     => 'end_featured_date',
                'value'   => date('Y-m-d'),
                'compare' => '<'
            )
        )
    ) );
} elseif(in_array('supplier', $current_user_id->roles)) {
    $users = new WP_User_Query( array(
        'role_in'     => array('farmer', 'restaurant'),
        'meta_query' => array(
            array(
                'key'     => 'subscription_plan',
                'value'   => $subscription_plan,
                'compare' => '='
            ),
            array(
                'key'     => 'start_featured_date',
                'value'   => date('Y-m-d'),
                'compare' => '>'
            ),
            array(
                'key'     => 'end_featured_date',
                'value'   => date('Y-m-d'),
                'compare' => '<'
            )
        )
    ) );
} elseif(in_array('restaurant', $current_user_id->roles)) {
    $users = new WP_User_Query( array(
        'role_in'     => array('farmer', 'supplier'),
        'meta_query' => array(
            array(
                'key'     => 'subscription_plan',
                'value'   => $subscription_plan,
                'compare' => '='
            ),
            array(
                'key'     => 'start_featured_date',
                'value'   => date('Y-m-d'),
                'compare' => '>'
            ),
            array(
                'key'     => 'end_featured_date',
                'value'   => date('Y-m-d'),
                'compare' => '<'
            )
        )
    ) );
}
   



$get_users = $users->get_results();
//$contributor_users = get_users( array( 'role' => 'contributor' ) );
// var_dump($contributor_users);

?>
<style>
    @media (min-width: 690px) {
    .span_4 {
        width: 20%;
    }
}

</style>

<section>
    <div class="container main-content">
        <div class="row" id="browse_profiles">
            <h1>Browse Profiles</h1>
            <form class="form">
                    <input type="text" id="course_code" name="search" value="<?= $search_string ; ?>" placeholder="Search by Name">
                    <button type="submit" id="submit">Search</button>
                    <a class="reset" href="<?= site_url('browse-profiles') ?>">Reset</a>
            </form>
        </div>

        <div class="row" id="browse_profiles2">
            <!-- First Column (4 spans) -->
            <div class="col span_12">
                <?php if ( !empty( $get_users ) ) {
                    foreach ( $get_users as $user ) { 
                        $profile_pic = get_user_meta($user->ID, 'profile_pic', true);
                        $store_details = get_user_meta($user->ID, 'store_details', true);

                        if ($user->ID === $current_user_id->ID) { // Skip the current logged-in user
                            continue;
                        } ?>
                        <div class="col span_4">
                            
                            <div class="box">
                                <img src="<?= $profile_pic ? wp_get_attachment_url($profile_pic) : get_stylesheet_directory_uri() . '/multivendor/assets/images/avatar.png' ?>">
                                <h3><?= $user->display_name ?></h3>
                                <p><?= !empty($store_details) && $store_details['store_about'] ? $store_details['store_about'] : '' ?></p>
                                <a href="<?= site_url('store-profile?id='.$user->ID); ?>" target="_blank">View </a>
                            </div>
                           
                        </div>
                <?php  } } else { ?>
                    <p>No Records Found!</p>
                <?php   } ?>
            <!-- Close the second column here -->
        </div>
    </div>
</section>
<?php  get_footer(); ?>