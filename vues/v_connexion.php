<div class="page-container">
  
    <!-- top navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
       <div class="container">
    	<div class="navbar-header">
           
           <a class="navbar-brand" href="#">Gestion des frais - Identification</a>
    	</div>
       </div>
    </div>
      
    <div class="container">
      <div class="row row-offcanvas row-offcanvas-left">
        
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          <div data-spy="affix" data-offset-top="45" data-offset-bottom="90">
            <ul class="nav" id="sidebar-nav">
              <!-- <li><a href="#">Accueil</a></li> -->
              <!-- <li><a href="#section1">Gestion des frais</a></li>  -->           
            </ul>
           </div>
        </div>
  	
        <!-- Corps -->
        <div class="col-xs-12 col-sm-8 textG" data-spy="scroll" data-target="#sidebar-nav">
          <h1 id="section1">Bienvenue sur l'application GSB</h1>
          
          
          <p><img src="img/logo.png" id="testDiv" alt="Test div" title="TestDiv"/></p>
        </div>
        <div class="textD">
          <div id="divIdent" class="ident">
           <h1>Identification</h1>
           <div class="col-md-12 column">
              <form role="form" method="POST" action="index.php?uc=connexion&action=valideConnexion">
               <div class="form-group">
                  <label >Nom utilisateur</label><input class="form-control" id="login" name="login" type="text" />
               </div>
               <div class="form-group">
                  <label >Mot de passe</label><input class="form-control" id="mdp" name="mdp" type="password" />
               </div>
               <input type="submit" class="btnVal" value="Connexion"/>
              </form>
           </div>
          </div>
    
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->
</div><!--/.page-container-->