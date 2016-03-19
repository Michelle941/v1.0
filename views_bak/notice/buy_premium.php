<?php $user_email = $user->email; ?>
<style>
    .upgrade__info{clear: both;}
</style>


<div class="form popup__form upgrade-form">
    <h2 class="popup__title">SORRY CHARLIE</h2>
    <h3 class="popup__subtitle">
        YOU NEED TO UPGRADE YOUR MEMBERSHIP<br>
        IN ORDER TO READ MESSAGES FROM OTHER MEMBERS
    </h3>

<script src="https://checkout.stripe.com/checkout.js"></script>

    <div class="upgrade">
        <ul>
            <li class="upgrade__item">
                <span class="upgrade__price">$10/month</span>
                <button id="customButton" class="stripe-monthly button-inverted">SELECT</button>
                <span class="upgrade__info">NO COMMITMENT,<br>CANCEL ANYTIME</span>
            </li>
            <li class="upgrade__item">
                <span class="upgrade__price">$50/year</span>
                <button class="stripe-annual button-inverted">SELECT</button>
                <span class="upgrade__info">THAT’S RIGHT, YOU<br>SAVE MORE THAN 50%</span>
            </li>
        </ul>
    </div>

    <footer class="popup__footer">
        <p>
            MEMBERSHIP FEES HELP US KEEP THIS WEBSITE AD FREE! YEE-HAW!!!
        </p>
    </footer>
</div>

<script>
  var user_email = "<?php echo $user_email; ?>";
  var handler = StripeCheckout.configure({
    key: 'pk_test_gHAejR60WGSspFvjaZPnrbvC',
    locale: 'auto',
    token: function(token) {
      // Use the token to create the charge with a server-side script.
      // You can access the token ID with `token.id`
      console.log(token)
      $.ajax({
          url: 'link/to/php/stripeDonate.php',
          type: 'post',
          data: {tokenid: token.id, email: token.email, donationAmt: donationAmt},
          success: function(data) {
            if (data == 'success') {
                console.log("Card successfully charged!");
            }
            else {
                console.log("Success Error!");
            }

          },
          error: function(data) {
            console.log("Ajax Error!");
            console.log(data);
          }
        }); // end ajax call
    }
  });

  $('.stripe-monthly').on('click', function(e) {
    // Open Checkout with further options
    handler.open({
      name: '941 Social Club',
      email: user_email,
      description: 'Monthly Premium Membership',
      amount: 1000,
      billingAddress: true,
      closed: function(){ location.reload() }, 
    });
    e.preventDefault();
  });

   $('.stripe-annual').on('click', function(e) {
    // Open Checkout with further options
    handler.open({
      name: '941 Social Club',
      email: user_email,
      description: 'Annual Premium Membership',
      amount: 5000,
      billingAddress: true,
      closed: function(){ location.reload() },
    });
    e.preventDefault();
  });



  // Close Checkout on page navigation
  $(window).on('popstate', function() {
    handler.close();
  });
</script>
