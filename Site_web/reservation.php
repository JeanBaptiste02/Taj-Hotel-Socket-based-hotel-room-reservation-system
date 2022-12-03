<?php
    $titre = "Hotel TAJ";
    $link = "./css/style.css";
    require "./include/header.inc.php";
?>
        <main>
            <section>
                <h2> <a href="#form" style="color:white;">>> Réservez <<</a> </h2>

                <?php
                    $con3 = pg_connect("host=postgresql-tajhotel.alwaysdata.net dbname=tajhotel_db user=tajhotel password=Srijbnih25*");
                    $sql = 'SELECT num_chambre FROM chambre;';
                    $querynum2 = "SELECT num_chambre FROM client INTERSECT SELECT num_chambre FROM chambre;";
                    $querynum3 = "SELECT DISTINCT type_chambre, prix AS Chambre_utiliser_par_Hotel, description from chambre WHERE capacite IS NOT NULL AND prix IS NOT NULL;";
                    $querynum4 = "SELECT type_chambre, num_chambre, capacite, num_etage, prix FROM chambre GROUP BY chambre.num_chambre,prix HAVING prix >= 150 AND occupation = FALSE;";
                    $result3 = pg_query($sql);
                    $resultnum2 = pg_query($querynum2);
                    $resultnum3 = pg_query($querynum3);
                    $resultnum4 = pg_query($querynum4);
                ?>


                <article>
                    <?php
                        /////////////

                        echo "<p>Numéros des chambres qui sont déjà pris :<p>";
                        while ($row2 = pg_fetch_row($resultnum2)) {
                            echo "<p>".$row2[0]."</p>";
                        }
                        echo "</br> </br>";

                        pg_free_result($resultnum2);

                        
                        /////////////
                    ?>

                </article>

                <article>
                    <?php
                        /////////////

                        echo "<p>Types de Chambres et leurs prix</p>";
                        echo "<table border='1' cellspacing='0' class='show_tab'>
                                <tr>
                                    <th>Type</th>
                                    <th>Prix</th>
                                </tr>";
                        while ($row3 = pg_fetch_row($resultnum3)) {
                            echo "<tr>";
                            echo "<td>".$row3[0]."</td>";
                            echo "<td>".$row3[1]."</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</br> </br>";

                        pg_free_result($resultnum3);

                    ?>
                </article>

                <article>
                    <?php
                         echo "<p>Les chambres non occupées</p>";
                         echo "<table border='1' cellspacing='0' class='show_tab'>
                                 <tr>
                                     <th>type_chambre</ht>
                                     <th>num_chambre</th>
                                     <th>capacite</th>
                                     <th>num_etage</th>
                                     <th>prix</th>
 
                                 </tr>";
                         while ($row4 = pg_fetch_row($resultnum4)) {
                             echo "<tr>";
                             echo "<td>".$row4[0]."</td>";
                             echo "<td>".$row4[1]."</td>";
                             echo "<td>".$row4[2]."</td>";
                             echo "<td>".$row4[3]."</td>";
                             echo "<td>".$row4[4]."</td>";
                             echo "</tr>";
                         }
                         echo "</table>";
                         echo "</br> </br>";

                         pg_free_result($resultnum4);
                    ?>
                </article>

                </br></br></br>

                <article class="myArticle" id="form">
                    <h2>Formulaire de réservation et d'inscription</h2>
                    <?php

                        echo "
                            <form action='insertEltsClients.php' method='POST'>
                                <label>Num client</label>
                                <input type='text' name='elt0' required='required'/> </br>
                                <label>Nom client</label>
                                <input type='text' name='elt1'required='required'/> </br>
                                <label>Prenom client</label>
                                <input type='text' name='elt2'required='required'/> </br>
                                <label>Mail client</label>
                                <input type='text' name='elt3'required='required'/> </br>
                                <label>Tel client</label>
                                <input type='text' name='elt4'required='required'/> </br>
                                <label>Adresse client</label>
                                <input type='text' name='elt5'required='required'/> </br>
                                <label>Num chambre</label>
                                <select name='room' required='required'>";
                                    while ($ligne = pg_fetch_row($result3))
                                    {
                                        echo "<option value='$ligne[0]'>$ligne[0]</option>";
                                    } 
                            echo"
                                </select></br>
                                <label>Mot de passe</label>
                                <input type='password' name='elt7'/> </br></br> 
                                </br></br>

                                <input type='submit' value='Soumettre' />  ";
                                pg_free_result($result3);
                                pg_close($con3);                        
                    ?>
                    
                </article>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>