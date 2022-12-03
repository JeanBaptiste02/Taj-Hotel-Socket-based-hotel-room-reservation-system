<?php
    $titre = "Hotel TAJ";
    $link = "./css/style.css";
    require "./include/header.inc.php";
?>
        <main>
            <section>
                <article>
                    <?php
                        session_start();
                        $user=$_SESSION['nom_user'];
                        echo"<h2 style='color:#4f0;'>Bienvenue $user </h2>";

                        $con1 = pg_connect("host=postgresql-tajhotel.alwaysdata.net dbname=tajhotel_db user=tajhotel password=Srijbnih25*");
                        $querynum1 = "SELECT COUNT(num_chambre) FROM client;";
                        $querynum2 = "SELECT num_chambre FROM client INTERSECT SELECT num_chambre FROM chambre;";
                        $query = "SELECT * FROM client;";
                        $querynum3 = "SELECT DISTINCT type_chambre, prix AS Chambre_utiliser_par_Hotel, description from chambre WHERE capacite IS NOT NULL AND prix IS NOT NULL;";
                        $querynum4 = "SELECT type_chambre, num_chambre, capacite, num_etage, prix FROM chambre GROUP BY chambre.num_chambre,prix HAVING prix >= 150 AND occupation = FALSE;";
                        $querynum5 = "SELECT num_chambre AS Chambre_utiliser_par_Hotel, description from chambre WHERE capacite IS NULL AND prix IS NULL;";
                        $resultnum1 = pg_query($querynum1);
                        $resultnum2 = pg_query($querynum2);
                        $result = pg_query($query);
                        $resultnum3 = pg_query($querynum3);
                        $resultnum4 = pg_query($querynum4);
                        $resultnum5 = pg_query($querynum5);


                        echo "<p>Nombres de chambres déjà prises :<p>";
                        while ($row1 = pg_fetch_row($resultnum1)) {
                            echo "<p>".$row1[0]."</p>";
                        }
                        pg_free_result($resultnum1);

                        echo "</br> </br>";

                        /////////////

                        echo "<p>Numéros des chambres qui sont déjà prises :<p>";
                        while ($row2 = pg_fetch_row($resultnum2)) {
                            echo "<p>".$row2[0]."</p>";
                        }
                        pg_free_result($resultnum2);

                        echo "</br> </br>";

                        /////////////

                        echo "<p>Détails de tous les clients</p>";
                        echo "<table border='1' cellspacing='0' class='show_tab'>
                                <tr>
                                    <th>num client</th>
                                    <th>nom client</th>
                                    <th>prenom client</th>
                                    <th>mail client</th>
                                    <th>tel client</th>
                                    <th>addr client</th>
                                    <th>num chambre</th>
                                </tr>";
                        while($row = pg_fetch_row($result)){
                            echo "<tr>";
                            echo "<td>".$row[0]."</td>";
                            echo "<td>".$row[1]."</td>";
                            echo "<td>".$row[2]."</td>";
                            echo "<td>".$row[3]."</td>";
                            echo "<td>".$row[4]."</td>";
                            echo "<td>".$row[5]."</td>";
                            echo "<td>".$row[6]."</td>";
                            echo "</tr>";
                        }
                        echo "</table> </br> </br>";

                        ////////////
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
                        echo "</table> </br> </br>";
                        pg_free_result($resultnum3);

                        /////////////

                        echo "<p>Les chambres de luxe non occupées</p>";
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
                        echo "</table> </br> </br>";
                        pg_free_result($resultnum4);


                        ///////////

                         echo "<p>Chambres réservées aux personnels de l'hôtel</p>";
                         echo "<table border='1' cellspacing='0' class='show_tab'>
                                 <tr>
                                     <th>Type de Chambre</th>
                                     <th>Description</th>
                                 </tr>";
                         while ($row5 = pg_fetch_row($resultnum5)) {
                             echo "<tr>";
                             echo "<td>".$row5[0]."</td>";
                             echo "<td>".$row5[1]."</td>";
                             echo "</tr>";
                         }
                         echo "</table>";
                         pg_free_result($resultnum5);
 
                         /////////////



                        pg_close($con1);
                    ?>
                </article>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>