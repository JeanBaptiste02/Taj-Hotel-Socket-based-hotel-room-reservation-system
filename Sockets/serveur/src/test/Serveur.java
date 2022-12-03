package test;

import java.io.BufferedReader ;

import serveur.PostgresSQLJDBC;
import serveur.ServeurTCP;

/**
 * Programme principal.
 * @author srigu, jb, nih
 *
 */
public class Serveur {

	public static void main(String[] args) {
		
		ServeurTCP server = new ServeurTCP();
		
		PostgresSQLJDBC db = new PostgresSQLJDBC(); 
		
		String chaine_entree = server.readData();
        
		if(chaine_entree == null){
			System.out.println("Le client est deconnecter.");
		} else {
			 //buffer
	        if (chaine_entree.length() > 5 || chaine_entree.length() < 5) {
	       	 server.sendData("lumiere rouge (mauvaise format de données)");
	       	 server.stop();
	        } else {
	        	System.out.println("Le client a envoyer : " + chaine_entree);
	    		if(db.requete1(chaine_entree) == true) { // verifie dans la bd si le badge existe
	    			if(db.requete5(chaine_entree) == true) { // verifie dans la bd si le badge est bloquer
	    				server.sendData("lumiere rouge (votre badge est bloquer ou nest pas encore activer, veuillez contacter la reception)");
	    			} else {
	    				server.sendData("ok, veuillez indiquer votre numero de chambre.");
	    				
	    				BufferedReader r1 = null;
	    				server.setFlux_entree(r1);
	    				String chaine_entree2 = server.readData();
	    				
	    				
	    				if(chaine_entree2 == null){
	    					System.out.println("Le client est deconnecter.");
	    				} else {
	    					 //buffer
	    					if (chaine_entree2.length() > 5 || chaine_entree2.length() < 5) {
	    				       	 server.sendData("lumiere rouge (mauvaise format de donnees)");
	    				       	 server.stop();
	    				    } else {
	    				    	System.out.println("Le client a envoyer : " + chaine_entree2);
	    				    	if(db.requete2(chaine_entree, chaine_entree2) == true) { // verifie dans la bd si le num_chambre correspond avec le badge saisie avant
	    							server.sendData("lumiere verte");	
	    						} else {
	    							db.requete3(chaine_entree); // incremente le nbr de tentative du badge
	    							int nbrTentatives = db.getTentavites();
	    							int i = 3 - nbrTentatives;
	    							
	    							if(nbrTentatives > 2) { // si le nbr de tentative est 3 alors
	    								db.requete4(chaine_entree); // on bloque le badge
	    								server.sendData("lumiere rouge (votre badge vient detre bloquer, veuillez contactez la reception)");
	    							} else {
	    								server.sendData("lumiere rouge (pas la bonne chambre, il vous reste "+ i + "essai)");
	    							}
	    						}
	    				    }
	    				}
	    			
	    			}			
	    		} else {
	    			server.sendData("lumiere rouge (ne peut pas detecter votre badge)");
	    			db.stopConnexionBD();
	    		
	    		}
	        }
		}
		System.out.println("Fermeture du serveur.");
		server.stop();
		}
			
}
