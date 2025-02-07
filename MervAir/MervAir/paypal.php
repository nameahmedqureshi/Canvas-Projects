<?php /* Template Name: Paypal Page */ ?>
<?php get_header(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal JS SDK Advanced Integration</title>
    <link
      rel="stylesheet"
      type="text/css"
      href="https://www.paypalobjects.com/webstatic/en_US/developer/docs/css/cardfields.css"
    >
    <script
        src="https://www.paypal.com/sdk/js?client-id=AdudKmSwJFFIW0oUSj5dBpvhyH950Fa3y1C2qxKWqIY0yHKEDEr4CDVLWp_5syvMqoz0qtb9mz_CQu7O&components=buttons,hosted-fields&enable-funding=&disable-funding=paylater,venmo"
        data-client-token="<%= clientToken %>"
        data-sdk-integration-source="integrationbuilder_ac">
    </script>
  </head>
  <body>
    <div id="paypal-button-container" class="paypal-button-container"></div>
    <div class="card_container">
      <form id="card-form">
        <label for="card-number">Card Number</label>
        <div id="card-number" class="card_field"></div>
        <div style="display: flex; flex-direction: row">
          <div>
            <label for="expiration-date">Expiration Date</label>
            <div id="expiration-date" class="card_field"></div>
          </div>
          <div style="margin-left: 10px">
            <label for="cvv">CVV</label>
            <div id="cvv" class="card_field"></div>
          </div>
        </div>
        <label for="card-holder-name">Name on Card</label>
        <input
          type="text"
          id="card-holder-name"
          name="card-holder-name"
          autocomplete="off"
          placeholder="card holder name"
        >
      
       
        <br><br>
        <button value="submit" id="submit" class="btn">Pay</button>
      </form>
      <p id="result-message"></p>
    </div>
  </body>
</html>

<?php get_footer(); ?>
<script>

</script>