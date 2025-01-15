# Progetto Gestione Inventario

Questo progetto consiste nello sviluppo di un sito web per la gestione di un e-commerce. Gli utenti possono accedere al sito tramite un account, con funzionalità specifiche per amministratori e utenti normali. Il sistema include anche la possibilità di recuperare la password tramite email.

## Funzionalità principali
- **Accesso utenti e amministratori**: Login personalizzato per utenti e admin.
- **Recupero password**: Funzionalità di reset tramite email.
- **Gestione prodotti**: Dettagli dei prodotti e possibilità di gestione avanzata per gli admin.
- **Acquisti**: Pagamento con riepilogo finale.
- **Esperienza utente ottimizzata**: Controlli lato client tramite JavaScript e pagine dinamiche.

---

## Suddivisione delle attività

### **Colombo**
- **Autenticazione**:
  - Login
  - Logout
  - Recupero password
  - Gestione invio email
- **Amministrazione**:
  - Pannello admin
  - Classe per la gestione degli utenti
- **Componenti aggiuntive**:
  - Pagina di redirect

### **Ramella**
- **Esperienza utente**:
  - Homepage
  - Registrazione nuovi utenti
- **E-commerce**:
  - Pagamento con riepilogo finale
  - Dettagli prodotto (in comune con Colombo: Ramella si occupa della parte utente admin)
  - Carrello prodotti
- **Sviluppo tecnico**:
  - Classe per la gestione dei prodotti
  - Controlli lato client tramite JavaScript

---

## Struttura del progetto
Il progetto è organizzato in modo modulare per garantire una manutenzione semplice e una scalabilità futura. Le principali componenti includono:
- **Frontend**: HTML, CSS, JavaScript per l'interfaccia utente e le validazioni lato client.
- **Backend**: Gestione della logica di business, autenticazione, e invio email.
- **Database**: Archiviazione di utenti, prodotti e ordini.

---

## Requisiti
- **Linguaggi e strumenti**: 
  - HTML, CSS, JavaScript, PHP
  - IDE
- **Configurazione ambiente**: 
  - Server web (Apache)


## Installazione
1. Clona il repository:
   git clone https://github.com/tuo-repo/progetto-gestione-inventario.git
