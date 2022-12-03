package serveur;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.PreparedStatement;


/**
 * Connexion a la Base de données PostgreSQL alwaysdata.
 * @author srigu, jb, nih
 *
 */
public class PostgresSQLJDBC {
	
	private Connection c;
    private PreparedStatement stmt;
    private ResultSet res;
    private int tentavites; //variable utiliser pour blocker la carte

	public PostgresSQLJDBC() {
		
		try {
			Class.forName("org.postgresql.Driver");
			c = DriverManager.getConnection("jdbc:postgresql://postgresql-tajhotel.alwaysdata.net:5432/tajhotel_db","tajhotel", "Srijbnih25*");
			
			System.out.println("Opened database successfully");
			
			
		} catch ( Exception e ) {
	         System.err.println( e.getClass().getName()+": "+ e.getMessage() );
	         System.exit(0);
	    }	
	}
	
	public Boolean requete1(String chaine_entree) { // verifie si num_badge existe
		Boolean sol = false;
		try {
			String queryBadge = "SELECT num_badge FROM badge WHERE num_badge=?";
			PreparedStatement stmt = getC().prepareStatement(queryBadge);
			setStmt(stmt);
			getStmt().setString(1, chaine_entree); // a la place de "?" 
			ResultSet resBadge = getStmt().executeQuery();
			setRes(resBadge);
			
		    while(getRes().next()){
		    	
		    	if(getRes().getString("num_badge").equals(chaine_entree)) {
		    		sol = true;
		    	} 
		    }
		    stopRequete();
			
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return sol;
	}
	
	public Boolean requete2(String chaine_entree, String chaine_entree2) { // verifie si le num_badge correspond au num_chambre
		Boolean sol = false;
		try {
			String queryChambre = "SELECT num_chambre FROM accede WHERE num_badge=? AND num_chambre=?";
			PreparedStatement stmt = getC().prepareStatement(queryChambre);
			setStmt(stmt);
			getStmt().setString(1, chaine_entree); // a la place du 1er "?"
			getStmt().setString(2, chaine_entree2); // a la place du 2eme "?"
			ResultSet resBadge = getStmt().executeQuery();
			setRes(resBadge);
			
		    while(getRes().next()){
		    	
		    	if(getRes().getString("num_chambre").equals(chaine_entree2)) {
		    		sol = true;
		    	} 
		    }
		    
		    if(sol == false) { // si num_chambre ne correspond pas alors on incremente +1
		    	recupTentatives(chaine_entree);
		    }
		    stopRequete();
			
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return sol;
	}
	
	public void recupTentatives(String chaine_entree) {
		try {
			String queryBadge = "SELECT * FROM badge WHERE num_badge=? AND num_badge!=?";
			PreparedStatement stmt = getC().prepareStatement(queryBadge);
			setStmt(stmt);
			getStmt().setString(1, chaine_entree); // a la place de "?" 
			getStmt().setString(2, "b1102");
			ResultSet resBadge = getStmt().executeQuery();
			setRes(resBadge);
			
			while(getRes().next()){
			    	
			    	if(getRes().getString("num_badge").equals(chaine_entree)) {
				    	int tenta = resBadge.getInt("tentative_access")+1;
				    	setTentavites(tenta);
			    	} 
			 }
		    stopRequete();
			
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	public void requete3(String chaine_entree) { //mise a jour de table badge et colonne tentaive_access
		try {
			String queryUpdate = "UPDATE badge SET tentative_access=? WHERE num_badge=?";
			PreparedStatement stmt= getC().prepareStatement(queryUpdate);
			setStmt(stmt);
            getStmt().setInt(1, getTentavites()); 
            getStmt().setString(2, chaine_entree);
       	 	getStmt().executeUpdate(); 		 
       	 	getStmt().close();	
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	public void requete4(String chaine_entree) { //bloque le badge en fesant la mise a jour de table badge et colonne droitaccess
		try {
			String queryUpdate2 = "UPDATE badge SET droitaccess=FALSE WHERE num_badge=?"; 
			PreparedStatement stmt= getC().prepareStatement(queryUpdate2);
			setStmt(stmt);
            getStmt().setString(1, chaine_entree);
       	 	getStmt().executeUpdate(); 		 
       	 	getStmt().close();	
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	public Boolean requete5(String chaine_entree) { //verifie si le badge est bloquer
		   Boolean sol = false;
			try {
				String queryBadge = "SELECT * FROM badge WHERE num_badge=?";
				PreparedStatement stmt = getC().prepareStatement(queryBadge);
				setStmt(stmt);
				getStmt().setString(1, chaine_entree); // a la place de "?" 
				ResultSet resBadge = getStmt().executeQuery();
				setRes(resBadge);
				
			    while(getRes().next()){
			    	
			    	if(getRes().getString("num_badge").equals(chaine_entree) && resBadge.getBoolean("droitaccess") == false){
			    		sol = true;
			    	} 
			    }
			    stopRequete();
				
			} catch (SQLException e) {
				e.printStackTrace();
			}
			return sol;
	}
	
	public void stopRequete() {
		try {
			getRes().close();
			getStmt().close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	public void stopConnexionBD() {
		try {
			getC().close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	public Connection getC() {
		return c;
	}
	
	public PreparedStatement getStmt() {
		return stmt;
	}

	public void setStmt(PreparedStatement stmt) {
		this.stmt = stmt;
	}
	
	
	public ResultSet getRes() {
		return res;
	}

	public void setRes(ResultSet res) {
		this.res = res;
	}   
	
	public int getTentavites() {
		return tentavites;
	}

	public void setTentavites(int tentavites) {
		this.tentavites = tentavites;
	}

}
