<?php
session_start();
$_SESSION['recuperation']=[];
include('bdd.php');

if(isset($_POST['pseudo']) 
&& isset($_POST['mail']) 
&& !empty($_POST['pseudo']) 
&& !empty($_POST['mail'])
&& filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    $pseudo=$_POST['pseudo'];
    $mail=$_POST['mail'];
    $req1=$bdd->prepare("SELECT * FROM utilisateur WHERE mail= ?");
    $req1->execute([$mail]);
    $resultrow=$req1->fetch(PDO::FETCH_ASSOC);
    if ($resultrow) {
        $string = implode('', array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9')));
        $token = substr(str_shuffle($string), 0, 20);
        $token_hash = password_hash($token, PASSWORD_DEFAULT);
        $req2=$bdd->prepare("UPDATE utilisateur SET mdp =? WHERE mail=? ");
        // $req2->bindValue(1, $token);
        // $req2->bindValue(2, $_POST["mail"]);
        $req2->execute([$token_hash, $_POST["mail"]]);

        // variables du mail
        $link = "http://localhost/base-learn?token'.$token.'";
        $objet = 'Nouveau mot de passe';
        $to = 'lafarge21@hotmail.fr';
        $header =[];
        $header = "From: Support :<zzzzzzz@zzzz.zz> \n";
        $header = "MIME-version: 1.0\n";
        $header = "Content-type: text/html; charset=utf-8\n";
        $header = "Content-Transfer-Encoding: 8bit";
        $message = "<html>".
        "<body>".
        "<p>Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe et en recevoir un nouveau.</p>".
        "<a href=".$link." style='font-size: 18px'>Cliquez ici</a>".
        "</body>".
        "</html>";

        //===== Envoi du mail
        mail($to, $objet, $message, $header);
        array_push($_SESSION['recuperation'],["Un mail a été envoyé à votre adresse mail.","success"]);
        header("Location:recuperation.php");
    }
    else {
        array_push($_SESSION['recuperation'],["Votre mail est incorrect.", "danger"]);
        header("Location:recuperation.php");
    }
    header("Location:echec.php");
}
array_push($_SESSION['recuperation'],["Veuillez remplir les champs ci-dessous.", "danger"]);
header("Location:recuperation.php");