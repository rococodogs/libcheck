<?php
class Libcheck {
    // checks to see if the library owns an item using WorldCat searching

    public $libSymbols;
    private $wskey;

    public $message = "";

    public function __construct($libSymbols, $wskey) {
        $this->libSymbols = $libSymbols;
        $this->wskey = $wskey;
    }
        
    
    /**
     *  search:
     *  -------
     *  @param string: isbn to search with
     *  @return array
     *      'Institution Name' => Name of the institution
     *      'Symbol' => OCLC symbol for institution
     *      'URL' => WorldCat link to institution's catalog entry
     *  
     */


    public function search($isbn) {

        $libSymbolString = implode(",", $this->libSymbols);
        $isbn = str_replace("-", "", $isbn);
        
        $url  = "http://www.worldcat.org/webservices/catalog/content/libraries/isbn/{$isbn}?";
        $url .= "oclcsymbol={$libSymbolString}&wskey={$this->wskey}";

        $results = array();

        try {
            $xml = new SimpleXMLElement($this->pullXml($url));
            
            // 'holding' being populated means we have a url available
            if ($xml->holding) {
                foreach($xml->holding as $holding) {
                    $results[] = array(
                        "Institution Name" => (string) $holding->{'physicalLocation'},
                        "Symbol" => (string) $holding->{'institutionIdentifier'}->{'value'},
                        "URL" => (string) $holding->{'electronicAddress'}->{'text'}
                    );

                }

                return $results;

            } elseif ($xml->diagnostic) {
                $this->message = (string) $xml->diagnostic->message;
                return false;
                
            } else {
                $this->message = "Unexpected Response";
                return false;
            }

        } catch (Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }
    }

    public function getMessage() {
        return $this->message;
    }

    private function buildURL($isbn) {
        $libSymbolString = implode(",", $this->libSymbols);
        $isbn = str_replace("-", "", $isbn);

        return "http://www.worldcat.org/webservices/catalog/content/libraries/isbn/{$isbn}?"
             . "oclcsymbol={$libSymbolString}&wskey={$this->wskey}";
    }

    private function pullXml($url) {
        $xml = file_get_contents($url);

        if (!$xml) {
            throw new Exception("Unable to get results!");
        } else {
            return $xml;
        }
    }
}
?>
