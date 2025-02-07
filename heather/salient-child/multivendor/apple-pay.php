<?php /* Template Name: Apple Pay */ ?>
<?php //get_header(); ?>

<meta name="viewport" content="width=device-width, initial-scale=1" />
<div id="express-checkout-element"></div>
<script src="https://pay.google.com/gp/p/web_manifest.json"></script>
<style>
#express-checkout-element {
  width: 300px; /* Adjust this value as needed */
}

</style>
<script src="https://js.stripe.com/v3/"></script>

<script>
        // Initialize Stripe
        const stripe = Stripe('pk_test_51PNfoGAOqJbE4AIGUB2S5oYWIWMRjB0N4otuUHZKgYZk7TwZ3MDhFN1lJQqq3JoFfyHzvMWoA2bRH3SecQ1L8VdF00XTYhOqiJ');

        // Create an instance of Stripe Elements
        const elements = stripe.elements();

        // Define the payment request
        const paymentRequest = stripe.paymentRequest({
            country: 'US',
            currency: 'usd',
            total: {
                label: 'Total',
                amount: 1099,
            },
            requestPayerName: true,
            requestPayerEmail: true,
        });

        // Create the Payment Request Button
        const prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
        });

        // Check the availability of the Payment Request Button
        paymentRequest.canMakePayment().then(function(result) {
            if (result) {
                prButton.mount('#express-checkout-element');
            } else {
                document.getElementById('express-checkout-element').style.display = 'none';
            }
        });

        // Handle errors
        prButton.on('error', function(error) {
            console.error('Stripe Payment Request Button error:', error);
            // Display an error message to the user
        });
        
    </script>

<?php //get_footer(); ?>