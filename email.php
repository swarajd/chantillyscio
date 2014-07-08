<?php

require 'PHPMailer/PHPMailerAutoload.php';

function send_mail($email,$subject,$msg) {
    $api_key="key-6y8lrevf0hz8zb2ntvflkvv7yir2j0o8";/* Api Key got from https://mailgun.com/cp/my_account */
    $domain ="php2-chantillyscio.rhcloud.com";/* Domain Name you given to Mailgun */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/'.$domain.'/messages');
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'from' => 'Open <postmaster@php2-chantillyscio.rhcloud.com>',
        'to' => $email,
        'subject' => $subject,
        'html' => $msg,
        'text' => $msg
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (isset($_POST['email']))
{

    $email_to = "chantillyhsscio@gmail.com";
    $email_subject = $_POST['subject'];

    $bad = "false";

    function eh()
    {
        //TODO : make fancy error page
        header('Location: http://php2-chantillyscio.rhcloud.com/');
    }

    if (!isset($_POST['name'])    ||
        !isset($_POST['email'])   ||
        !isset($_POST['subject']) ||
        !isset($_POST['message']))
    {
        $bad = "true";
        eh();
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if (!preg_match($email_exp, $email))
    {
        $bad = "true";
        eh();
    }

    $name_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($name_exp, $name))
    {
        $bad = "true";
        eh();
    }

    if (strlen(message) < 2)
    {
        $bad = "true";
        eh();
    }

    function clean_string($string)
    {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $name = clean_string($name);
    $email = clean_string($email);
    $subject = clean_string($subject);
    $message = clean_string($subject);

    $headers = 'From: '.$email."\r\n";

    if (!mail($email_to, $subject, $message, $headers))
    {
        $bad = "true";
    }

    /*
     *
     * lets try PHPMailer
     */

    
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = "smtp.mailgun.org";
    $mail->SMTPAuth = true;
    $mail->Username = "postmaster@php2-chantillyscio.rhcloud.com";
    $mail->Password = "4673626y-w14";
    $mail->SMTPSecure = 'tls';

    $mail->From = $email;
    $mail->FromName = $name;
    $mail->Subject = $subject;
    $mail->Body = $message;

    if (!$mail->send())
    {
        $bad = "true";
    }
    

    //echo send_mail($email_to, $subject, $message);

    echo $bad . "\n";
    //header('Location: http://php2-chantillyscio.rhcloud.com/');
    echo "success!";
} else {
    //header('Location: http://php2-chantillyscio.rhcloud.com/');
    echo "failed";
}

?>
