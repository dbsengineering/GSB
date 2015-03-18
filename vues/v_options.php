<div class="page-container">
  
 

    <div class="container">
        <div class="row row-offcanvas row-offcanvas-left">
        
            <!-- sidebar -->
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
                <div data-spy="affix" data-offset-top="45" data-offset-bottom="90">
                    <ul class="nav" id="sidebar-nav">
        
                    </ul>
                </div>
            </div>
  	
            <!-- Corps -->
            <div class="col-xs-12 col-sm-8 textG" data-spy="scroll" data-target="#sidebar-nav">
                <h1 id="section1">Bienvenue sur l'application GSB</h1>
                <p><img src="img/logo.png" id="testDiv" alt="Test div" title="TestDiv"/></p>
            </div>
        
            <div class="textD">
                <div id="divIdent" class="ident" style="height:400px;">
                    <h1>Changer votre mot de passe</h1>
                    <div class="col-md-12 column">
                        <form role="form" method="POST" action="index.php?uc=options&action=changeMdp"><!--  -->
                            <br>
                            <div class="form-group">
                                <label >Nouveau mot de passe</label><input class="form-control" id="mdp" name="mdp" type="password" />
                                <br>
                                <br>
                                <label >Resaisissez à nouveau le mot de passe</label><input class="form-control" id="mdpNew" name="mdpNew" type="password" />
                            </div>
                            <input type="submit" class="btnVal" value="Changer"/>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-xs-12 main -->
        </div>
    </div><!--/.row-->
</div><!--/.page-container-->
