<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118751810-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-118751810-1');
</script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="chatbot.js"></script>
    <link rel="stylesheet" href="chatbot.css" type="text/css">
    </head>
<body>

<div class="topstrip" id="topstrip"><a href="http://www.svtsydney.org/ask/" style="color:#d3d3d3">SVT Sydney Virtual Assistant</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.svtsydney.org" style="color:#d3d3d3" target="_blank">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div class="topbar" id="chat-text">
</div>
<form>
    <span style="width:100%;">
        <input class="inputbox"
               placeholder="Ask something and press Go or Enter..." id="message" name="date" value="" autocomplete="off">
    </span>
    <input name="submit" type="hidden" value="Submit">
</form>
<?php
$sessionID = uniqid('',true);
include('starter.php');
?>
<span style="display: none;" id="sessionId">
        <?php
        echo $sessionID;
        ?>
    </span>
</body>
</html>
