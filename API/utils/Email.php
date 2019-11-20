<?php


class Email
{
 public $fname;
 public $email;
 public $message;
 public $path;


   function emailsend( ){

        /**
         * This example shows settings to use when sending via Google's Gmail servers.
         */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');

        require '../phpmailer/PHPMailerAutoload.php';

//Load dependencies from composer
//If this causes an error, run 'composer install'
        require '../phpmailer/vendor/autoload.php';

//Create a new PHPMailer instance
        $mail = new PHPMailerOAuth;
        $mail->CharSet = "UTF-8";
//Tell PHPMailer to use SMTP
        $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

//Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'ssl';

//Whether to use SMTP authentication
        $mail->SMTPAuth = true;// Connection with the SMTP does require authorization

//Set AuthType
        $mail->AuthType = 'XOAUTH2';
        $mail->Encoding = '8bit';

//User Email to use for SMTP authentication - user who gave consent to our app
        $mail->oauthUserEmail = "panduka29@gmail.com";

//Obtained From Google Developer Console
        $mail->oauthClientId = "763711806159-cifmfnpp4jq86ggk3k76vis1ifqobhd7.apps.googleusercontent.com";

//Obtained From Google Developer Console
        $mail->oauthClientSecret = "0HvFlGVPWpWMAPxihXnui8D5";

//Obtained By running get_oauth_token.php after setting up APP in Google Developer Console.
//Set Redirect URI in Developer Console as [https/http]://<yourdomain>/<folder>/get_oauth_token.php
// eg: http://localhost/phpmail/get_oauth_token.php
        $mail->oauthRefreshToken = "1/5xWT854gOTZ4dI-Z6uPEgaE_YDhEIUJaYb5LSs3waMY";

//Set who the message is to be sent from
//For gmail, this generally needs to be the same as the user you logged in as
//$mail->setFrom('from@example.com', 'First Last');
        // Compose
        $mail->setFrom($this->email, $this->fname);
        $mail->addReplyTo($this->email, $this->fname);
        $mail->Subject = "New User register inquery";
        // Subject (which isn't required)
        $mail->addAttachment('../pdf/'.$this->path);
        $mail->msgHTML($this->message);
//Set who the message is to be sent to
        $mail->addAddress('radus288@gmail.com.com', 'radus 28');
        $mail->addBCC( 'panduka29@gmail.com','radus assignment');

//Set the subject line
//$mail->Subject = 'PHPMailer GMail SMTP test';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//    $mail->addAttachment('images/phpmailer_mini.png');


//send the message, check for errors
        try {
            $mail->send();

        } catch (phpmailerException $e) {
           echo $e->errorMessage();
           //Pretty error messages from PHPMailer
        }
// clear all  email hedders to send email to applicant
       $mail->ClearAddresses();
       $mail->ClearAllRecipients();
       $mail->ClearReplyTos();
       $mail->ClearCustomHeaders();

       $mail->setFrom('radus28@gmail.com','radus28');
       $mail->addReplyTo('radus28@gmail.com','radus28');

       // Subject (which isn't required)
       $mail->Subject = "Response to the requset";
       $mail->msgHTML('Dear applicant, <br><br>Please refer the attachment.<br><br><br><br>__<br>Best regards<br>radus28');

       //Set whom the message is to be sent to
       $mail->addAddress($this->email, $this->fname);
       $mail->addBCC( 'panduka29@gmail.com','radus assignment');


       try {
           $mail->send();

       } catch (phpmailerException $e) {
           echo $e->errorMessage();
           //Pretty error messages from PHPMailer
       }

        unset($mail);
    }



}