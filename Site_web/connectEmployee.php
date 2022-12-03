<?php
    $titre = "Hotel TAJ";
    $link = "./css/style.css";
    require "./include/header.inc.php";
?>
        <main>
            <section>
            <h2>Connectez-vous (Espace Employees)</h2>

                <div>
                    <?php


                        echo '
                        
                        <form action="sesionEmpl.php" method="POST">
                        <div>
                            <p style"text-align:center;">
                                Se connecter
                            </p>
                        </div>
                        <div>
                            <input type="text" name="user" placeholder="Utilisateur" required/>
                        </div>

                        <div>
                            <input type="password" name="pass" placeholder="Mot de passe" required/>
                        </div>

                        <div>
                            <input type="submit" name="entrar" placeholder="User" >
                        </div>

                    </form>

                        ';
                    ?>
                
                </div>

                    <a href="connectClient.php"><button class="myb">Espace Clients<button></a>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>