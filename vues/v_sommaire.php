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
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="index.php?uc=gererFrais&action=saisirFrais">Saisie fiche de frais</a></li>
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="index.php?uc=etatFrais&action=selectionnerMois">Mes fiches de frais</a></li>
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="index.php?uc=options&action=">Options</a></li>
                    <li id="btnMen" role="presentation" class="divider"></li>
                    <li id="btnMen" role="presentation"><a role="menuitem" tabindex="-1" href="index.php?uc=connexion&action=deconnexion">Déconnexion</a></li>
                </ul>
                <div id="divVisiteur">Visiteur : <?php echo $_SESSION['prenom'] ." ". $_SESSION['nom'] ?></div>
                
                <a id="idBtnSaisieF" href="index.php?uc=gererFrais&action=saisirFrais"/>Saisie des Frais</a>
                <a id="idBtnFicheF" href="index.php?uc=etatFrais&action=selectionnerMois"/>Consultation des Frais</a>
                <a id="idBtnOption" href="index.php?uc=options&action=">Options</a>
                <a id="idBtnDeconnexion" href="index.php?uc=connexion&action=deconnexion">Déconnexion</a>
            </div>
        </div>
    </div>


