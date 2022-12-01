<?php
    $titre = "Hotel TAJ";
    $link = "./css/style.css";
    require "./include/header.inc.php";
?>
        <main>
            <section>
                <h2>Inscrivez-vous</h2>
                <article class="myArticle">
                    <?php

                        $con3 = pg_connect("host=postgresql-tajhotel.alwaysdata.net dbname=tajhotel_db user=tajhotel password=Srijbnih25*");
                        

                        echo "
                            <form action='insertEltsEmploye.php' method='POST'>
                                <label>Num Employe</label>
                                <input type='text' name='elt0' required='required'/> </br>
                                <label>Nom Employee</label>
                                <input type='text' name='elt1'required='required'/> </br>
                                <label>Prenom Employee</label>
                                <input type='text' name='elt2'required='required'/> </br>
                                <label>Mail Employee</label>
                                <input type='text' name='elt3'required='required'/> </br>
                                <label>Tel Employee</label>
                                <input type='text' name='elt4'required='required'/> </br>
                                <label>Type contrat</label>
                                <select name='contrat' required='required'>
                                        <option value='CDD'>CDD</option>
                                        <option value='CDI'>CDI</option>
                                </select> </br> </br>
                                <label>Salaire</label>
                                <select name='salary' required='required'>
                                        <option value='5246.35'>5246.35</option>
                                        <option value='3684.01'>3684.01</option>
                                        <option value='2536.26'>2536.26</option>
                                </select> </br> </br>
                                <label>Poste</label>
                                <select name='poste' required='required'>
                                        <option value='Surveillance'>Surveillance</option>
                                        <option value='Restauration'>Restauration</option>
                                        <option value='Réception'>Réception</option>
                                        <option value='Ménage'>Ménage</option>
                                </select> </br> </br>
                                <label> Mot de passe </label>
                                <input type='text' name='elt8'/> </br></br> 
                                </br></br>

                                <input type='submit' value='Soumettre' />  ";
                                pg_close($con3);                        
                    ?>
                    
                </article>
            </section>
        </main>
<?php
    require "./include/footer.inc.php";
?>