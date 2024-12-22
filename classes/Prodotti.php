class Prodotto {
    public $nome;
    public $descrizione;
    public $quantita;
    public $immagine;
    public $tipo;
    public $prezzo;

    // Costruttore
    public function __construct($nome, $descrizione, $quantita, $immagine, $tipo, $prezzo) {
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->quantita = $quantita;
        $this->immagine = $immagine;
        $this->tipo = $tipo;
        $this->prezzo = $prezzo;
    }

    // Getter per nome
    public function getNome() {
        return $this->nome;
    }

    // Getter per descrizione
    public function getDescrizione() {
        return $this->descrizione;
    }

    // Getter per quantità
    public function getQuantita() {
        return $this->quantita;
    }

    // Getter per immagine
    public function getImmagine() {
        return $this->immagine;
    }

    // Getter per tipo
    public function getTipo() {
        return $this->tipo;
    }

    // Getter per prezzo
    public function getPrezzo() {
        return $this->prezzo;
    }
}
