<?php
session_start();

use \Antoine\Database;

require_once '../src/Database.php';
require '../components/previous.php';
$pageTitle = "se connecter";
$styleSheetBis = "css/login.css";
$scriptJS = "js/script.js";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    header('Location:' . $router->generate("home"));
    $_SESSION['AC'] = "<h1 class='alreadyConnected'> Vous êtes déjà connecté </h1>";
}

if (isset($_POST['submit'])) {
    $mdpconnect = sha1($_POST['passwdSubmit']);
    $mailconnect = htmlspecialchars($_POST['mailSubmit']);
    if (!empty($mailconnect) && !empty($mdpconnect)) {
        $param = [];
        array_push($param, $mailconnect, $mdpconnect);
        $bdd = new Database("natpass");

        $userInfo = $bdd->queryMultipleValue("SELECT * FROM membre WHERE mbr_mail = ? AND mbr_passwd = ?", $param);


        if (count($userInfo) == 1) {
            $_SESSION['usr_id'] = $userInfo[0]->mbr_id;
            $_SESSION['usr_mail'] = $userInfo[0]->mbr_mail;
            $_SESSION['login'] = true;
            $_SESSION['usr_imgProfil'] = $userInfo[0]->mbr_imgProfil;
            header("Location: / ");
        } else {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}


?>
<div class="movieFootage">
    <video src="./img/backgroundLog.mp4" autoplay muted loop>
    </video>
</div>
<div class="loginContainer">
    <div class="formLogin">
        <h1>connexion</h1>
        <form action="<?= $router->generate('login') ?>" method="POST">
            <div class="pseudo">
                <i class="fas fa-user fa-2x"></i>
                <input required name="mailSubmit" type="text" placeholder="entrer votre email">
            </div>
            <div class="passwd">
                <i class="fas fa-key fa-2x"></i>
                <input required name="passwdSubmit" type="password" placeholder="entrer votre mot de passe">
            </div>
            <p><?= $err ?? "" ?></p>
            <div class="buttonContainer">
                <button class="loginBTN" name="submit" type="submit">connexion</button>
                <button class="createAccount"> <a href="">ou créer un compte</a></button>
            </div>
        </form>
    </div>
</div>