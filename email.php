<?php

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

    $headers = 'From: '.$email."\r\n".

    @mail($email_to, $subject, $message, $headers);

    echo $bad;
    //header('Location: http://php2-chantillyscio.rhcloud.com/');
    echo "success!";
} else {
    //header('Location: http://php2-chantillyscio.rhcloud.com/');
    echo "failed";
}

?>
