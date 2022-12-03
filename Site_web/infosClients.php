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
                        $query2 = "SELECT *
                        FROM client
                       ORDER
                          BY num_client DESC
                       LIMIT 1;";
                        $querynum4 = "SELECT type_chambre, num_chambre, capacite, num_etage, prix FROM chambre GROUP BY chambre.num_chambre,prix HAVING prix >= 150 AND occupation = FALSE;";
                        $resultnum4 = pg_query($querynum4);
                        $result2 = pg_query($query2);


                        //////////

                        echo "<p>Votre profil</p>";
                        echo "<table border='1' cellspacing='0' class='show_tab1'>
                                <tr>
                                    <th>num client</th>
                                    <th>nom client</th>
                                    <th>prenom client</th>
                                    <th>mail client</th>
                                    <th>tel client</th>
                                    <th>addr client</th>
                                    <th>num chambre</th>
                                </tr>";
                        while($row2 = pg_fetch_row($result2)){
                            echo "<tr>";
                            echo "<td>".$row2[0]."</td>";
                            echo "<td>".$row2[1]."</td>";
                            echo "<td>".$row2[2]."</td>";
                            echo "<td>".$row2[3]."</td>";
                            echo "<td>".$row2[4]."</td>";
                            echo "<td>".$row2[5]."</td>";
                            echo "<td>".$row2[6]."</td>";
                            echo "</tr>";
                        }
                        echo "</table>";

                        pg_free_result($result2);


                        /////////////

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
                        pg_free_result($resultnum4);

                        pg_close($con1);
                    ?>
                </article>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>