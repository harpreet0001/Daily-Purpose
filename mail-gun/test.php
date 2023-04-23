
<html>
<head>
<title>
Send Email via Mailgun API Using PHP
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-12">
<div id="main">
<h1>Send Email via Mailgun API Using PHP</h1>
</div>
</div>
<div class="col-md-12">
<div class="matter">
<div id="login">
<h2>Send Email</h2>
<form action="test2.php" method="post">
<label class="lab">Sender's Name :</label>
<input type="text" name="sname" id="to" placeholder="Senders Name"/>
<label class="lab">Receiver's Email Address :</label>
<input type="email" name="to" id="to" placeholder="Receiver's email address" />
<label class="lab">Email type:</label><div class="clr"></div>
<div class="lab">
<input type="radio" value="def" name="etype" checked>Default
<input type="radio" value="cc" name="etype" >cc
<input type="radio" value="bcc" name="etype" >bcc </div>
<div class="clr"></div>
<label class="lab">Subject :</label>
<input type="text" name="subject" id="subject" placeholder="subject" required />
<label class="lab">Message body :</label><div class="clr"></div>
<div class="lab">
<input type="radio" value="text" name="msgtype" checked>Text
<input type="radio" value="html" name="msgtype" >HTML</div>
<textarea type="text" name="msg" id="msg" placeholder="Enter your message here.." required ></textarea>
<input type="submit" value=" Send " name="submit"/>
</form>
</div>
</div>
</div>
</div>
<!-- Right side div -->
</div>
</body>
</html>
