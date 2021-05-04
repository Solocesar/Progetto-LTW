# Progetto-LTW
Progetto LTW Film Share

1. Funzionalità  
   - Homepage con vista (film popolari, Recenti ecc )  
   - Profili utenti  
        - Foto
        - Nome utente
        - Bio
        - Recensioni 
    - Film visti  
        - Recensioni  
        - Commenti  
        - Lista amici  
    - TheMovieDB implementare uso API 
    


2. Grafica
    - Blu/bianco
    - Homepage  
    - Nav bar sempre in alto  
    - Sfondo    
    - Utenti?
    - Ricerca?  

3. DB
    - Utente
    - Email
    - password
    - fotoProfilo
    - MappaRecensioni [id -> recensione] 
    - ListaAmici [email]

Cose da fare 
- Homepage con Vista recensioni .

- ID utenti
- film.html 
    - Tasto per i trailer da nascondere
    - Tasto per le recensioni che apre la Card
    - Card recensione , con punteggio ,timestamp 

- Lista Amici, 

<!-- ------------------ -->
Tabelle 
Utente:
	id 
	email
	nickname
	password
	img url
	List[id.recensione]

Tabella Recensioni:
	id
	timestamp
	recensione stringa
	voto
	film.id
	utente.id
    Like
