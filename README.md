# Libcheck
WorldCat Search [Local Catalog URL api](http://oclc.org/developer/documentation/worldcat-search-api/library-catalog-url) gadgetry (in PHP)


## the problem
when trying to build a staff-side application to assist with purchase suggestions for our library we wanted to find a way to notify the requester that the we already own the book they're asking for. Innovative Millennium (our current ILS) doesn't allow searching the catalog in any way outside of the OPAC, _but_, as we use WorldCat Local as our discovery layer, most of our collection is in WorldCat and searchable with their api. 

## usage
set your OCLC library symbol(s) as an array, and supply your WorldCat Search api key:

```php
$libSymbols = array("EVI");
$wskey = "ABCDEFG1234567"; // NOT the WorldCat Basic api key

$czech = new Libcheck($libSymbols, $wskey);

/**
 *  search takes in an ISBN number and an optional callback function
 *  	that uses the node.js style of inputs: error first, then payload
 */

$czech->search("1592408508", function($err, $url) {
	if ($err) {
    	echo $err;
        return false;
    } else {
    	echo $url;
    }

/**
 *  search example w/o callback
 */

$response = $czech->search("1592408508");

if ($response) {
    header('Location: {$response}');
    exit;
} else {
    echo "The library doesn't own that item!";
});
```

## to do
* add regex to sort out ISBNs from OCLC #s from ISSNs
* multi-library support (half-way there w/ imploding `$libSymbols` array)
* maybe just bite the bullet and do a full-flegged WorldCat Search class
* snazzier name (of the __utmost__ importance)
