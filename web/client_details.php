<?php
    $titre = "Hotel TAJ";
    $link = "./css/style.css";
    require "./include/header.inc.php";
?>
        <main>
            <section>
                <article>
                    <?php
                        $con2 = pg_connect("host=postgresql-tajhotel.alwaysdata.net dbname=tajhotel_db user=tajhotel password=Srijbnih25*");
                        $query2 = "SELECT * FROM client ORDER BY num_client, nom_client, prenom_client, mail_client, tel_client, num_chambre ASC LIMIT 1;";
                        $result2 = pg_query($query2);
                        echo "<p>Détails du dernier inscrit</p>";
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
                        pg_close($con2);
                    ?>
                </article>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>