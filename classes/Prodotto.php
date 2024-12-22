<?php
    class Prodotto
    {
        private $IDprodotto;
        private $Nome;
        private $Descrizione;
        private $Fornitore;
        private $Prezzo;
        private $pathImmagine;
        private $tipo;

        public function __construct($IDprodotto, $Nome, $Descrizione, $Fornitore, $Prezzo, $pathImmagine, $tipo)
        {
            $this->IDprodotto = $IDprodotto;
            $this->Nome = $Nome;
            $this->Descrizione = $Descrizione;
            $this->Fornitore = $Fornitore;
            $this->Prezzo = $Prezzo;
            $this->pathImmagine = $pathImmagine;
            $this->tipo = $tipo;
        }

        // Getter per tutti gli attributi
        public function getIDprodotto() {
            return $this->IDprodotto;
        }

        public function getNome() {
            return $this->Nome;
        }

        public function getDescrizione() {
            return $this->Descrizione;
        }

        public function getFornitore() {
            return $this->Fornitore;
        }

        public function getPrezzo() {
            return $this->Prezzo;
        }

        public function getPathImmagine() {
            return $this->pathImmagine;
        }

        public function getTipo() {
            return $this->tipo;
        }

        // Salva l'utente su file in formato CSV
        public function salvaSuFile($filePath)
        {
            $riga = "\r\n" . $this->IDprodotto . ";" . $this->Nome . ";" . $this->Descrizione . ";" . $this->Fornitore . ";" . $this->Prezzo . ";" . $this->pathImmagine . ";" . $this->tipo;
            file_put_contents($filePath, $riga, FILE_APPEND);
        }

        // Funzione per caricare utenti da file
        public static function caricaProdotti($filePath)
        {
            $contenuto = file_get_contents($filePath);
            $righe = explode("\r\n", trim($contenuto));
            $prodotti = [];
            foreach ($righe as $riga) {
                $campi = explode(";", $riga);
                if (count($campi) === 7) {
                    $prodotti[] = new Utente($campi[0], $campi[1], $campi[2], $campi[3], $campi[4], $campi[5], $campi[6]);
                }
            }
            return $prodotti;
        }
    }
?>