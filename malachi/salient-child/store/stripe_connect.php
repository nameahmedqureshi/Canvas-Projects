<?php /* Template Name: Stripe */ ?>
<?php
if (isset($_GET['code'])) {
    $code = $_GET['code']; // Authorization code jo Stripe redirect URL mein aaya hai

    $client_id = 'ca_QWvsE4zFUKwS9pbz21Vfdp1LJopap51r';
    $client_secret = 'sk_test_51PNfoGAOqJbE4AIG60PBPpGQCAVI9i6t6K9xSwPwsfyrwGSMl7WCf4SoPRsKqrhDJ49dGEGiue1GMRD7cVNQypPm00Jf7F4l8Z';
    
    $response = wp_remote_post('https://connect.stripe.com/oauth/token', array(
        'method'    => 'POST',
        'body'      => array(
            'client_secret' => $client_secret,
            'code'          => $code,
            'grant_type'    => 'authorization_code'
        )
    ));
    
    if (is_wp_error($response)) {
        echo 'Error in API request';
    } else {
        $body = json_decode(wp_remote_retrieve_body($response), true);

        // var_dump($body);
        // exit;
        
        if (isset($body['access_token'])) {
            $stripe_user_id = $body['stripe_user_id']; // User ka Stripe Account ID
            $access_token = $body['access_token']; // Access Token
            $refresh_token = $body['refresh_token']; // Refresh Token
    
            // Ye tokens apni database table mein store karein
            update_user_meta(get_current_user_id(), 'stripe_user_id', $stripe_user_id);
            update_user_meta(get_current_user_id(), 'stripe_access_token', $access_token);
            update_user_meta(get_current_user_id(), 'stripe_refresh_token', $refresh_token);
    
            echo "Stripe successfully connected!";
        } else {
            echo "Error: " . $body['error_description'];
        }
    }
    
}

?>
<a href="#" id="stripe-connect-button">
    <img src="https://checkout.stripe.com/buttons/connect.svg" alt="Connect with Stripe">
</a>

<script>
document.getElementById('stripe-connect-button').addEventListener('click', function() {
    window.location.href = "https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_QWvsE4zFUKwS9pbz21Vfdp1LJopap51r&scope=read_write";
});
</script>
