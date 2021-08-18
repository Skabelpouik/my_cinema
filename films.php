<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>My Cinema</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <?php include('bdd_connect.php'); ?>
        <section>
        	<div>
                <form method="POST" action="#">
                    <label for="titre">Titre du film recherché:</label><input type="text" name="titre" id="titre" minlength="2"/>
                    <select name="genre">
                        <option value="all" selected="selected">Tous les genres</option>
                        <?php 
                            $req = $bdd->query("SELECT * FROM genre");
                            while ($data = $req->fetch()){
                                echo "<option value='".$data["id_genre"]."'>".$data['nom']."</option>";
                            }
                            $req->closeCursor();
                        ?>
                        
                    </select>
                    <select name="distrib">
                        <option value="all" selected="selected">Tous les distributeurs</option>
                        <?php 
                            $req = $bdd->query("SELECT * FROM distrib");
                            while ($data = $req->fetch()){
                                echo "<option value='".$data["id_distrib"]."'>".$data['nom']."</option>";
                            }
                            $req->closeCursor();
                        ?>
                        
                    </select>
                    <input type="submit" name="recherche" value="Recherche">
                </form>
            </div>
        </section>
        <section>
            <div>
                <?php
                    if ($_POST['genre'] != "all" && $_POST['distrib'] != "all")
                    {
                        $req = $bdd->query("SELECT * FROM film WHERE titre 
                            LIKE '%".$_POST['titre']."%' AND id_genre=".$_POST['genre']."
                             AND id_distrib=".$_POST['distrib']);
                       
                    }
                    else if ($_POST['distrib'] != "all" && $_POST['genre'] == "all")
                    {
                        $req = $bdd->query("SELECT * FROM film WHERE titre 
                            LIKE '%".$_POST['titre']."%' AND id_distrib=".$_POST['distrib']);
                    }
                    else if ($_POST['genre'] != "all" && $_POST['distrib'] == "all")
                    {
                         $req = $bdd->query("SELECT * FROM film WHERE titre 
                            LIKE '%".$_POST['titre']."%' AND id_genre=".$_POST['genre']);
                    }
                    else
                    {
                        $req = $bdd->query("SELECT * FROM film WHERE titre LIKE '%".$_POST['titre']."%'");
                    }
                    if ($_POST['titre'] == NULL)
                    {
                        echo "<p>Vous n'avez entré aucun titre de film.</p>";
                    }
                    else if ($data = $req->fetch())
                    {
                         while ($data = $req->fetch()) 
                         {
                            echo "<p><strong>Titre:</strong> " . $data['titre'] . 
                                " <strong>Années:</strong> " . $data['annee_prod'] .
                                " <strong>Résumé:</strong> " . $data['resum'] . "</p>";
                        }
                        $bdd->closeCursor();
                    }
                    else 
                    {
                        echo "<p>Aucuns films ne correspond à votre recherche.</p>";
                    }
                ?>
            </div>
        </section>
    </body>
</html>