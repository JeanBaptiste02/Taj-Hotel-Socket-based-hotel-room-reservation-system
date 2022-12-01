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

                        session_start();

                        $user = $_POST['user'];
                        $pass = $_POST['pass'];

                        $query=("SELECT * FROM client 
                            WHERE nom_client='$user' AND mdp='$pass'");

                        $consult = pg_query($query);
                        $quant = pg_num_rows($consult);

                        if($quant>0){
                            $_SESSION['nom_user']=$user;
                            header('Location:infosClients.php');
                        }else{
                            echo "<p style='color:white;font-size:30px;'>Les données ne sont pas correctes</p>";
                        }

                    ?>

                    <a href="connectClient.php"><button class="myb">Retour en arrière<button></a>
                </article>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>