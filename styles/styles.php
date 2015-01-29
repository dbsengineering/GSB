<?php
   header('content-type: text/css');
   ob_start('ob_gzhandler');
   header('Cache-Control: max-age=31536000, must-revalidate');

   /*--- Déclaration des variables ---*/
   //$coulnavBar = $pdo->
   //--- Les tailles ---
   $tailCen = '100%';


   //--- Couleurs ---
   $coulBla = '#FFFFFF';
?>

/*--- Modules à 100% height non Responsive ---*/
html, body, .page-container, #sidebar {
  height: <?php echo $tailCen; ?>;
}

/*--- Modules background blanc non Responsive ---*/
.btnVal:hover, #btnAProp:hover, #btnSiege:hover, #btnAdm:hover {
  background: <?php echo $coulBla; ?>;
}

/*--- Modules Background noir clair non Responsive ---*/
#footer, #sidebar li a:hover {
  background:#222222;
}

/* wrapper for page content to push down footer */
.page-container {
  min-height: <?php echo $tailCen; ?>;
  height: auto !important;

  /* negative indent footer by its height */
  margin: 0 auto -120px;
  /* pad bottom by footer height */
  padding: 0 0 120px;
  background:url("../img/fondentete.png")no-repeat 0px 0px;
  -webkit-background-size: cover; /* pour anciens Chrome et Safari */
  background-size:cover;
}
.dropdown-menu {
    margin-top:0px;
    margin-left:300px;
    width:100%;
    color: <?php echo $coulBla; ?>;
    background:#222222;
    visibility: hidden;
}
#idBtnSaisieF {
    left: 1000px;
}
#idBtnFicheF {
    left: 1156px;
}
#idBtnSaisieF, #idBtnFicheF {
    position: absolute;
    top:0px;
    height:100%;
    padding:1em 1.5em;
    border: #999999 solid 1px;
    background: #999999;
    color: <?php echo $coulBla; ?>;
    font-family: 'Open Sans', sans-serif;
    font-weight:700;
    z-index:2;
}

#idBtnSaisieF:hover, #idBtnFicheF:hover {
    border: #999999 solid 1px;
    background:#444444;
    color: #999999;
}
#btnMen a {
    color: <?php echo $coulBla; ?>;
    background:#222222;
}
#btnMen a:hover {
    background:#999999;
}

/* set the fixed height of the footer here */
#footer {
  height: 120px;
  border:0 solid #080808;
  border-top-width: 1px;
  margin-top:50px;
}

#footer > .container {
  padding: 20px;
}

#footer a{
  color:#cccccc;
}

#footer a:hover {
  color: <?php echo $coulBla; ?>;
  margin-left:-2px;
  text-decoration:none;
}

body {
  padding-top: 51px; 
  background: #1E1E1E;
  color: #f9f9f9;
}
a {
  color:#efefef;
}
img {
  width: 80%;
  max-width: 400px;
}
.text-center {
  padding-top: 20px;
}
.textG {
  margin-top:50px;
  margin-left:-300px;
}
.textD {
  margin-top:400px;
  margin-left:80%;
}
.ident, #divFichF {
  width: 400px;
  height: 300px;
  text-align: center;
  background: rgba(126,211,232,0.3);
  border: 1px solid #203066;
  
  border-radius: 30px;
  -moz-border-radius: 30px;
  -webkit-border-radius: 30px;

  box-shadow: 8px 10px 10px 5px rgba(119, 119, 119, 0.75);
  -moz-box-shadow: 8px 10px 10px 5px rgba(119, 119, 119, 0.75);
  -webkit-box-shadow: 8px 10px 10px 5px rgba(119, 119, 119, 0.75);
}


.btnVal {
  padding:1em 1.5em;
  border: #FFFFFF solid 1px;
  background:#1C8DD5;
  color: <?php echo $coulBla; ?>;
  font-family: 'Open Sans', sans-serif;
  font-weight:700;
  border-radius:7px;
}
.btnVal:hover {
  color:#1C8DD5;
  text-decoration:none;
  border: #1C8DD5 solid 1px;
  transition:0.5s all;
  -webkit-transition:0.5s all;
  -o-transition:0.5s all;
  -moz-transition:0.5s all;
  -ms-transition:0.5s all;
}

#btnAdm, #btnSiege, #btnAProp {
  padding:0.5em 1em;
  border: #EEEEEE solid 1px;
  background:#666666;
  color: <?php echo $coulBla; ?>;
  font-family: 'Open Sans', sans-serif;
  font-weight:500;
  border-radius:2px;
}
#idLabel, #idTxtDateHF, #idTxtLibelleHF,
#idTxtMontantHF {
    display: block;
    float: left;
    margin-left:0px;
    width: 150px
}
#idFrais, #txtDateHF, #txtLibelleHF,
#txtMontantHF {
    margin-left:5px;
    color:#000000;
}
#btnAProp:hover, #btnSiege:hover, #btnAdm:hover {
  color:#666666;
  text-decoration:none;
  border: #666666 solid 1px;
  transition:0.5s all;
  -webkit-transition:0.5s all;
  -o-transition:0.5s all;
  -moz-transition:0.5s all;
  -ms-transition:0.5s all;
}
#divVisiteur {
    margin-top:15px;
    font-size:2em;
}

#lstMois{
    color:#000000;
}
#divFichF{
    margin-top:20px;
}

#divSign {
  margin-top:20px;
}

#sidebar {
  padding-right: 0;
  padding-top: 20px;
}

#sidebar .affix {
  position:fixed;
  top:55;
  width:220px;
}

#sidebar .affix-bottom {
  position:fixed;
  top:55;
  width:220px;
}

#sidebar .nav {
  width: 95%;
}

#sidebar li {
  border:0 #1e1e1e solid;
  border-bottom-width:1px;
}

#sidebar li a {
  padding-left:1px;
}

#sidebar li a:hover {
  color: <?php echo $coulBla; ?>;
}


/*------------------------*/
/*      Responsive        */
/*------------------------*/
@media screen and (max-width: 1560px) {
    .textD {
        margin-left:70%;
    }
    #idBtnSaisieF {
        left:800px;
    }
    #idBtnFicheF {
        left: 956px;
    }
}

@media screen and (max-width: 1280px) {
    .textD {
        margin-left:10%;
    }
    #idBtnSaisieF {
        left:600px;
    }
    #idBtnFicheF {
        left: 756px;
    }
}

@media screen and (max-width: 979px) {
  .textG {
    margin-top:20px;
    margin-left:10%;
  }

  .textD {
    margin-left:20%;
  }
}

@media screen and (max-width: 768px) {

  .textG {
    margin-top: 50px;
    margin-left:0px;
  }

  .textD {
    margin-left:10%;
  }

  .row-offcanvas {
    position: relative;
    -webkit-transition: all 0.25s ease-out;
    -moz-transition: all 0.25s ease-out;
    transition: all 0.25s ease-out;
  }

  .row-offcanvas-right
  .sidebar-offcanvas {
    right: -41.6%;
  }

  .row-offcanvas-left
  .sidebar-offcanvas {
    left: -41.6%;
  }

  .row-offcanvas-right.active {
    right: 41.6%;
  }

    .row-offcanvas-left.active {
        left: 41.6%;
    }

    .sidebar-offcanvas {
        position: absolute;
        top: 0;
        width: 41.6%;
    }

    #sidebar {
        background-color:#3b3b3b;
        padding-top:0;
    }

    #sidebar .nav>li {
        color: #ddd;
        background: linear-gradient(#3E3E3E, #383838);
        border-top: 1px solid #484848;
        border-bottom: 1px solid #2E2E2E;
        padding-left:10px;
    }

    #sidebar .nav>li:first-child {
        border-top:0;
    }

    #sidebar .nav>li>a {
        color: #ddd;
    }

    #sidebar .nav>li>a>img {
        max-width: 14px;
    }

    #sidebar .nav>li>a:hover, #sidebar .nav>li>a:focus {
        text-decoration: none;
        background: linear-gradient(#373737, #323232);
        color: <?php echo $coulBla; ?>;  
    }

    #sidebar .nav .caret {
        border-top-color: <?php echo $coulBla; ?>;
        border-bottom-color: <?php echo $coulBla; ?>;
    }

    #sidebar .nav a:hover .caret{
        border-top-color: <?php echo $coulBla; ?>;
        border-bottom-color: <?php echo $coulBla; ?>;
    }
    .dropdown-menu {
        margin-top:0px;
        margin-left:570px;
        width:100%;
        visibility: visible;
    }
    #idBtnSaisieF {
        visibility: hidden;
    }
    #idBtnFicheF {
        visibility: hidden;
    }
    #menuGauche {
        visibility: hidden;
    }
}
@media screen and (max-width: 680px) {
    .dropdown-menu {
        margin-top:0px;
        margin-left:400px;
        width:100%;
    }
}

@media screen and (max-width: 480px) {
    .textD {
        margin-left:0px;
        width: <?php echo $tailCen; ?>;
    }

    .ident , #divFichF {
        width: <?php echo $tailCen; ?>;
    }
    .dropdown-menu {
        margin-top:0px;
        margin-left:120px;
        width:100%;
    }
    
}

/*------------------------*/
/*      Fin Responsive    */
/*------------------------*/