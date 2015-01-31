<div class="page-container">
    <!-- Barre de navigation -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" id="idBtnMenu" class="navbar-toggle dropdown" data-toggle="dropdown" data-target=".sidebar-nav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="index.php?uc=validationFrais&action=validationFrais">Validation des frais</a></li>
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="#">Options</a></li>
                    <li id="btnMen" role="presentation" class="divider"></li>
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="index.php?uc=connexion&action=deconnexion">Déconnexion</a></li>
                </ul>
                <div id="divVisiteur">Comptable : <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></div>
                <div id="idMenCompta">
                    <a id="idBtnSaisieF" href="index.php?uc=validationFrais&action=validationFrais"/>Validation des frais</a>
                    <a id="idBtnOptionC" href="#">Options</a>
                    <a id="idBtnDeconnexion" href="index.php?uc=connexion&action=deconnexion">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>


