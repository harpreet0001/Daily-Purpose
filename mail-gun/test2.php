<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//composer require mailgun/mailgun-php:~1.7.2
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;
?>
<?php

if (isset($_POST['sname'])) {
$sname=$_POST['sname'];
$to = $_POST['to'];
$subject = $_POST['subject'];
$msg = $_POST['msg'];
$msgtype = $_POST['msgtype'];
if($msgtype=='text'){
$html='';
}
else{
$msg = htmlentities($msg);
$html=$msg;
$msg='';
}
$mgClient = new Mailgun('45a1ce323c321f6f496d45c825628e85-62916a6c-591b76cc');
// Enter domain which you find in Default Password
$domain = "crm.rateshop.ca";


// # Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
"from" => "no-reply@crm.rateshop.ca",
"to" => "$to",
"subject" => "$subject",
"text" => "$msg!",
'html' => "$html"
));

echo "<script>alert('Email Sent Successfully.. !!');</script>";
}
?>