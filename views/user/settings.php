<?php
    $type = $user->subscription_type;
    $membership = $type === 'monthly' ? '$10 monthly' : '$50 annual';
?>

<style>
    .settings{font-size: 16px;}
</style>
<div class="news-index settings">
    <p>Thanks for joining the club and supporting the website with your <?php echo $membership?> membership. &nbsp; &nbsp;We hope you are having fun meeting other members. &nbsp; &nbsp;Messaging allows you to continue talking with people you met in real life.</p>
    <br>
    <br>
    <p>Want to cancel your membership?</p>
    <p>What?   &nbsp; &nbsp;Why?   &nbsp; &nbsp;No!   &nbsp; &nbsp;Don't go!   &nbsp; &nbsp;Please stay!   &nbsp; &nbsp; Ok.   &nbsp; &nbsp;Fine.   &nbsp; &nbsp;You can cancel.</p>
    <br>
    <p>Remember once you cancel your membership you can no longer read messages from other members.</p>
    <br>
</div>
<a style="font-size: 16px" href="/user/unpremium" class="button">Cancel Membership</a>
