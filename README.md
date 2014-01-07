# Libcheck
WorldCat Search [Local Catalog URL api](http://oclc.org/developer/documentation/worldcat-search-api/library-catalog-url) gadgetry (in PHP)


## the problem
when trying to build a staff-side application to assist with purchase suggestions for our library we wanted to find a way to notify the requester that the we already own the book they're asking for. Innovative Millennium (our current ILS) doesn't allow searching the catalog in any way outside of the OPAC, _but_, as we use WorldCat Local as our discovery layer, most of our collection is in WorldCat and searchable with their api. 

## usage
set your OCLC library symbol(s) as an array, and supply your WorldCat Search api key:

```php
$libSymbols = array("EVI");
$wskey = "1234567890";

$libcheck = new Libcheck($libSymbols, $wskey);
$results = $libcheck->search("9780316074230");

if (!$results) {
    echo $libcheck->getMessage();
} else {
    foreach($results as $result) {
        echo "<a href=\"{$result['URL']\">{$result['Institution Name']} ({$result['Symbol']})</a><br />";
    }
}
```

## to do
* sort out ISBNs from OCLC #s from ISSNs
* ~~multi-library support (half-way there w/ imploding `$libSymbols` array)~~
* take in strings as libSymbols as well
