package serveur;

import java.net.InetSocketAddress;
import java.net.ServerSocket ;
import java.net.Socket ;
import java.io.IOException ;
import java.io.BufferedReader ;
import java.io.InputStreamReader ;
import java.io.PrintWriter ;


/**
 * Socket Serveur TCP.
 * @author srigu, jb, nih
 *
 */
public class ServeurTCP {

	private ServerSocket serverSocket;
	private Socket clientSocket;
	private PrintWriter flux_sortie;
	private BufferedReader flux_entree;
	
	public ServeurTCP() {
		
		try {
			serverSocket = new ServerSocket();
			
			serverSocket.bind(new InetSocketAddress("127.0.0.1", 5644), 1);
			
			System.out.println ("En ecoute ...");
			
			clientSocket = serverSocket.accept();
			
			
			flux_sortie = new PrintWriter (clientSocket.getOutputStream(), true);
			flux_entree = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			
			System.out.println("Un client connecte.");
			
		} catch (IOException e) {
			System.err.println("Port déjà ouvert.");
			System.exit(1);
		}
	}
	
	public String readData() {
		String chaine_entree = null;
		try {
			chaine_entree = getFlux_entree().readLine();
		} catch (IOException e) {
		}
		return chaine_entree;	
	}
	
	public void sendData(String str) {
		getFlux_sortie().println(str);
	}
	
	public void stop() {
        try {
			flux_entree.close();
			flux_sortie.close();
	        clientSocket.close();
	        serverSocket.close();
		} catch (IOException e) {
			e.printStackTrace();
		}  
	 }

	public PrintWriter getFlux_sortie() {
		return flux_sortie;
	}

	public BufferedReader getFlux_entree() {
		return flux_entree;
	}


	public void setFlux_entree(BufferedReader flux_entree) {
		try {
			flux_entree = new BufferedReader(new InputStreamReader(getClientSocket().getInputStream()));
		} catch (IOException e) {
			e.printStackTrace();
		}
		this.flux_entree = flux_entree;
	}

	public Socket getClientSocket() {
		return clientSocket;
	}
	


	
	
	
}
