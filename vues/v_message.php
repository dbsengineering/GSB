<div class ="alert-success">
<ul>
<?php 
    foreach($_REQUEST['erreurs'] as $erreur) {
      echo "<li>$erreur</li>";
    }
?>
</ul></div>
