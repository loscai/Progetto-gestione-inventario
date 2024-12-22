<?php
    class Prodotto
    {
        private $IDprodotto;
        private $Nome;
        private $Descrizione;
        private $Fornitore;
        private $Prezzo;
        private $pathImmagine;

        public function __construct($IDprodotto, $Nome, $Descrizione, $Fornitore, $Prezzo, $pathImmagine)
        {
            $this->IDprodotto = $IDprodotto;
            $this->Nome = $Nome;
            $this->Descrizione = $Descrizione;
            $this->Fornitore = $Fornitore;
            $this->Prezzo = $Prezzo;
            $this->pathImmagine = $pathImmagine;
        }

        public function toCSV(){
            file_put_contents("../prodotti/datas/prodotti.csv",
            $this->IDprodotto . ";" .
            $this->Nome . ";" .
            $this->Descrizione . ";". 
            $this->Fornitore . ";". 
            $this->Prezzo . ";" .
            $this->pathImmagine . "\r\n");
        }
    }
?>