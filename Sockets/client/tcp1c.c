#include <sys/types.h>
#include <winsock2.h>
#include <strings.h>
#include <stdio.h>
#include <unistd.h>


#pragma comment(lib,"ws2_32.lib") //Winsock Library


int main(int argc , char *argv[])
{
	WSADATA wsa;
	SOCKET s;
	struct sockaddr_in server;
    char buf [2800] ;

	printf("\nInitialising Winsock...");
	if (WSAStartup(MAKEWORD(2,2),&wsa) != 0)
	{
		printf("Failed. Error Code : %d",WSAGetLastError());
		return 1;
	}

	printf("Initialised.\n");

	//Create a socket
	if((s = socket(AF_INET , SOCK_STREAM , 0 )) == INVALID_SOCKET)
	{
		printf("Could not create socket : %d" , WSAGetLastError());
	}

	printf("Socket created.\n");


	server.sin_addr.s_addr = inet_addr("127.0.0.1");
	server.sin_family = AF_INET;
	server.sin_port = htons( 5644 );



	//Connect to remote server
	if (connect(s , (struct sockaddr *)&server , sizeof(server)) < 0){
		puts("Connexion echouee : le port nest pas ouvert ou ladresse IP non atteignable.");
		return 1;
	}

	puts("Connected");

	/* on lit l'entree standard (0) et on l'envoie au serveur */
  	while (1) {

        int j = strncmp(buf,"lumiere verte", 13); // sa compare si les 7 premiers caractere de buf sont les memes que lumiere
        if(j == 0) {
            break;
        }
        int i = strncmp(buf,"lumiere rouge", 13);
        if(i == 0) {
            break;
        }

        /* Lecture de l'entree standard */
	  	read (0, buf, 2800) ;

	  	/* Envoi de ce qui a ete lu sur l'entree standard au serveur */
        send(s, buf, strlen(buf), 0);

        //reception des donn�es
        bzero(buf, 2800);
        int r = recv(s, buf, sizeof(buf), 0);
        if(r == 0) {
            printf ("Le serveur est deconnecter.") ;
            break;
        }
        printf ("Le serveur a repondu : %s\n", buf) ;
  	}

    printf ("Fermeture du client.") ;
    close (s) ;


	return 0;
}
