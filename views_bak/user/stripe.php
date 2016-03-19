<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Wilde Things</title>
  </head>
  <body>
  <div id="container">
<?php
$stripe = array(
  'secret_key'      => 'sk_test_qpV2JCzs4alPgE6CfRgP57Kl',
  'publishable_key' => 'pk_test_gHAejR60WGSspFvjaZPnrbvC'
  );
\Stripe\Stripe::setApiKey($stripe['secret_key']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $charge = \Stripe\Charge::create(array(
    'source'     => $_POST['stripeToken'],
    'amount'   => 53500,
    'currency' => 'usd'
  ));
  $wildeQuotes = array(
    "A little sincerity is a dangerous thing, and a great deal of it is absolutely fatal.",
    "Always forgive your enemies; nothing annoys them so much.",
    "America is the only country that went from barbarism to decadence without civilization in between.",
    "I think that God in creating Man somewhat overestimated his ability.",
    "I am not young enough to know everything.",
    "Fashion is a form of ugliness so intolerable that we have to alter it every six months.",
    "Most modern calendars mar the sweet simplicity of our lives by reminding us that each day that passes is the anniversary of some perfectly uninteresting event.",
    "Scandal is gossip made tedious by morality."
    );
  echo "<h1>Here's your quote!</h1>";
  echo "<h2>".$wildeQuotes[array_rand($wildeQuotes)]."</h2>";
}
else
{ ?>
  <h2>Wilde Things</h2>
  <h3>Purchase a quote by Oscar Wilde today! Only $535! Limited supply and going fast, buy now!!</h3>
  <form action="/user/stripe" method="POST">
    <script
      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
      data-key="<?php echo $stripe['publishable_key']; ?>"
      data-description="One Wilde quote"
      data-amount="53500">
    </script>
  </form>
<?php
}
?>
  </div><!-- #container -->
  </body>
</html>
