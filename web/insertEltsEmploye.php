<?php
    $titre = "Hotel TAJ";
    $link = "./css/style.css";
    require "./include/header.inc.php";
?>
        <main>
            <section class="index">
                <article>
                <?php
                    $con = pg_connect("host=postgresql-tajhotel.alwaysdata.net dbname=tajhotel_db user=tajhotel password=Srijbnih25*");


                    $query = "INSERT INTO employe(num_employe,nom_employe,prenom_employe,mail_employe,tel_employe,type_contrat,salaire,poste,mdp) VALUES(
                                    '". $_POST['elt0']."','". $_POST['elt1']."','". $_POST['elt2']."','". $_POST['elt3']."','". $_POST['elt4']."','". $_POST['contrat']."','". $_POST['salary']."','". $_POST['poste']."','". $_POST['elt8']."')";

                    pg_query($query);

                    echo "<p style='color:white;font-size:30px;'>Vos données ont été enregistrées avec succès</p>";
                    pg_close($con);
                ?>
                </article>
                <a href="connectEmployee.php"><button class="myb">Retour en arrière<button></a>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>
