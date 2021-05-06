<?php if(isset($_SESSION['login']) && $_SESSION['login'] === true):?>
    <div class="loggedUserContainer">
        <div class="loggedUserInfo">
            <img class="imgProfil" src="img/<?=$_SESSION['imgProfil']?>">
            <p><?= $_SESSION['username']?></p>
        </div>
    </div>
<?php endif; ?> 