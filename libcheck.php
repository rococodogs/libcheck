<?php
class Libcheck {
    // checks to see if the library owns an item using WorldCat searching

    public $libSymbols = array("EVI");
    public $wskey;

    /**
     *  search will take an isbn and use WorldCat's Library Catalog URL search service
     *      to check to see if an item is available in the library and will return the
     *      catalog url if so. also offers the option of using a callback function with
     *      the url or error message provided.
     *  
     *  ~ NOTE ~ 
     *      uses the node.js setup for callbacks, where the error is the first input val
     *      and the payload is the second. ~ function($error, $statusGoodies) ~
     */

    public function search($isbn, $callback = "") {
        
        try {
            $this->wskeyCheck($this->wskey);    
        } catch (Exception $e) {
            echo $e->getMessage();
        }


        $libSymbolString = implode(",", $this->libSymbols);
        $isbn = str_replace("-", "", $isbn);
        
        $url = "http://www.worldcat.org/webservices/catalog/content/libraries/isbn/{$isbn}?";
        $url .= "oclcsymbol={$libSymbolString}&wskey={$this->wskey}";

        try {
            $xml = new SimpleXMLElement($this->pullXml($url));
            if ($xml->holding) {
                $url = $xml->holding[0]->electronicAddress->text;
                return $callback ? $callback(null, $url) : $url;

            } elseif ($xml->diagnostic) {
                return $callback ? $callback($xml->diagnostic[0]->message) : false;

            } else {
                return $callback("Uh-oh! Something went wrong!");
            }

        } catch (Exception $e) {
            return $callback ? $callback($e->getMessage()) : false;
        }
    }

    private function pullXml($url) {
        $xml = file_get_contents($url);

        if (!$xml) {
            throw new Exception("Unable to get results!");
        } else {
            return $xml;
        }
    }

    private function wskeyCheck($wskey = null) {
        if (!$wskey) {
            throw new Exception("No WorldShare key provided!");
        }
    }

}
?>