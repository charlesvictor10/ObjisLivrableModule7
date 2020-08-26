<?php
    include 'inc/server.class.php';
	header('Content-type: application/json');
	$status = array(
		'type'=>'success',
		'message'=>'Merci de nous avoir contacté. Nous allons vous répondre dans les plus bref délai '
	);

    $nom = @trim(stripslashes($_POST['nom']));
    $email = @trim(stripslashes($_POST['email']));
    $objet = @trim(stripslashes($_POST['objet']));
    $message = @trim(stripslashes($_POST['message']));

    $retour = SendMail($pdo,$nom,$email,$objet,$message);
    echo $retour;

    $email_from = $email;
    $email_to = 'victorcharleswade@gmail.com';//replace with your email

    $body = 'Nom: ' . $nom . "\n\n" . 'Email: ' . $email . "\n\n" . 'Objet: ' . $sujet . "\n\n" . 'Message: ' . $message;

    $success = @mail($email_to, $objet, $body, 'From: <'.$email_from.'>');

    echo json_encode($status);
    header('location:index.php');
    die;