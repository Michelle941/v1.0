<html>
<head>
    <title></title>
    <script type="text/javascript" src="js/instafeed.js"></script>
</head>
<body>
<?php print_r($_GET)?>
<?php print_r($_REQUEST)?>
<div id="instafeed"></div>
<script type="text/javascript">
    var userFeed = new Instafeed({
        get: 'user',
        userId: 445487135,
        accessToken: '7ddaa5a81acf4eb6b29389324043bec9',
        template: '<a href="{{link}}"><img src="{{image}}" /></a>'
    });
    userFeed.run();
</script>
</body>
</html>
https://api.instagram.com/oauth/authorize/?client_id=2c5211a5d3b1462f89df7ef812c86513&redirect_uri=local.942.com/test.php&response_type=code