<?php

namespace Jstewmc\UspsAddress;

use Jstewmc\PhpHelpers\Num;

class Normalize
{
    /**
     * An array of compass directions indexed by abbreviation
     */
    private const DIRECTIONS = [
        'n'  => 'north',
        'ne' => 'northeast',
        'e'  => 'east',
        'se' => 'southeast',
        's'  => 'south',
        'sw' => 'southwest',
        'w'  => 'west',
        'nw' => 'northwest'
    ];

    /**
     * An array of US states indexed by abbreviation (includes military "states"
     * but uses a custom state name for the ambigous "ae" abbreviation).
     *
     * @see  https://www.usps.com/send/official-abbreviations.htm  a list of USPS
     *   state and military state abbreviations ("States" tab)
     */
    private const STATES = [
        // military "states"
        'aa' => 'armed forces americas (except canada)',
        'ap' => 'armed forces pacific',
        // a custom name for the ambiguous "ae" abbreviation
        'ae' => 'armed forces africa, canada, europe, or middle east',
        // 'ae' => 'armed forces africa',
        // 'ae' => 'armed forces canada',
        // 'ae' => 'armed forces europe',
        // 'ae' => 'armed forces middle east',

        // us states
        'al' => 'alabama',
        'ak' => 'alaska',
        'as' => 'american samoa',
        'az' => 'arizona',
        'ar' => 'arkansas',
        'ca' => 'california',
        'co' => 'colorado',
        'ct' => 'connecticut',
        'de' => 'delaware',
        'dc' => 'district of columbia',
        'fm' => 'federated states of micronesia',
        'fl' => 'florida',
        'ga' => 'georgia',
        'gu' => 'guam gu',
        'hi' => 'hawaii',
        'id' => 'idaho',
        'il' => 'illinois',
        'in' => 'indiana',
        'ia' => 'iowa',
        'ks' => 'kansas',
        'ky' => 'kentucky',
        'la' => 'louisiana',
        'me' => 'maine',
        'mh' => 'marshall islands',
        'md' => 'maryland',
        'ma' => 'massachusetts',
        'mi' => 'michigan',
        'mn' => 'minnesota',
        'ms' => 'mississippi',
        'mo' => 'missouri',
        'mt' => 'montana',
        'ne' => 'nebraska',
        'nv' => 'nevada',
        'nh' => 'new hampshire',
        'nj' => 'new jersey',
        'nm' => 'new mexico',
        'ny' => 'new york',
        'nc' => 'north carolina',
        'nd' => 'north dakota',
        'mp' => 'northern mariana islands',
        'oh' => 'ohio',
        'ok' => 'oklahoma',
        'or' => 'oregon',
        'pw' => 'palau',
        'pa' => 'pennsylvania',
        'pr' => 'puerto rico',
        'ri' => 'rhode island',
        'sc' => 'south carolina',
        'sd' => 'south dakota',
        'tn' => 'tennessee',
        'tx' => 'texas',
        'ut' => 'utah',
        'vt' => 'vermont',
        'vi' => 'virgin islands',
        'va' => 'virginia',
        'wa' => 'washington',
        'wv' => 'west virginia',
        'wi' => 'wisconsin',
        'wy' => 'wyoming'
    ];

    /**
     * An array of street suffixes indexed by abbreviation or common misspelling
     *
     * @see  https://www.usps.com/send/official-abbreviations.htm  a list of
     *   USPS street abbreviations ("Street Suffixes" tab)
     */
    private const SUFFIXES = [
        'allee' =>'alley',
        'ally' =>'alley',
        'aly' =>'alley',
        'anex' =>'annex',
        'anx' =>'annex',
        'arc' =>'arcade',
        'av' =>'avenue',
        'ave' =>'avenue',
        'aven' =>'avenue',
        'avenu' =>'avenue',
        'avn' =>'avenue',
        'avnue' =>'avenue',
        'bayou' =>'bayoo',
        'bch' =>'beach',
        'blf' =>'bluff',
        'bluf' =>'bluff',
        'blvd' =>'boulevard',
        'bnd' =>'bend',
        'bot' =>'bottom',
        'bottm' =>'bottom',
        'boul' =>'boulevard',
        'boulv' =>'boulevard',
        'br' =>'branch',
        'brdge' =>'bridge',
        'brg' =>'bridge',
        'brk' =>'brook',
        'brnch' =>'branch',
        'btm' =>'bottom',
        'byp' =>'bypass',
        'bypa' =>'bypass',
        'bypas' =>'bypass' ,
        'byps' =>'bypass',
        'canyn' =>'canyon',
        'causway' =>'causeway',
        'cen' =>'center',
        'cent' =>'center',
        'centr' =>'center',
        'centre' =>'center',
        'cir' =>'circle',
        'circ' =>'circle',
        'circl' =>'circle',
        'ck' =>'creek',
        'clb' =>'club',
        'clf' =>'cliff',
        'clfs' =>'cliffs',
        'cmp' =>'camp',
        'cnter' =>'center',
        'cntr' =>'center',
        'cnyn' =>'canyon',
        'cor' =>'corner',
        'cors' =>'corners',
        'cp' =>'camp',
        'cpe' =>'cape',
        'cr' =>'creek',
        'crcl' =>'circle',
        'crcle' =>'circle',
        'crecent' =>'crescent',
        'cres' =>'crescent',
        'cresent' =>'crescent',
        'crk' =>'creek',
        'crscnt' =>'crescent',
        'crse' =>'course',
        'crsent' =>'crescent',
        'crsnt' =>'crescent',
        'crssing' =>'crossing',
        'crssng' =>'crossing',
        'crt' =>'court',
        'cswy' =>'causeway',
        'ct' =>'court',
        'ct' =>'courts',
        'ctr' =>'center',
        'cv' =>'cove',
        'cyn' =>'canyon',
        'div' =>'divide',
        'dl' =>'dale',
        'dm' =>'dam',
        'dr' =>'drive',
        'driv' =>'drive',
        'drv' =>'drive',
        'dv' =>'divide',
        'dvd' =>'divide',
        'est' =>'estate',
        'ests' =>'estates',
        'exp' =>'expressway',
        'expr' =>'expressway',
        'express' =>'expressway',
        'expw' =>'expressway',
        'expy' =>'expressway',
        'ext' =>'extension',
        'extn' =>'extension',
        'extnsn' =>'extension',
        'exts' =>'extensions',
        'fld' =>'field',
        'flds' =>'fields',
        'fls' =>'falls',
        'flt' =>'flat',
        'flts' =>'flats',
        'forests' =>'forest',
        'forg' =>'forge',
        'frd' =>'ford',
        'freewy' =>'freeway',
        'frg' =>'forge',
        'frk' =>'fork',
        'frks' =>'forks',
        'frry' =>'ferry',
        'frst' =>'forest',
        'frt' =>'fort',
        'frway' =>'freeway',
        'frwy' =>'freeway',
        'fry' =>'ferry',
        'ft' =>'fort',
        'fwy' =>'freeway',
        'gardn' =>'garden',
        'gatewy' =>'gateway',
        'gatway' =>'gateway',
        'gdn' =>'garden',
        'gdns' =>'gardens',
        'gln' =>'glen',
        'grden' =>'garden',
        'grdn' =>'garden',
        'grdns' =>'gardens',
        'grn' =>'green',
        'grov' =>'grove',
        'grv' =>'grove',
        'gtway' =>'gateway',
        'gtwy' =>'gateway',
        'harb' =>'harbor',
        'harbr' =>'harbor',
        'havn' =>'haven',
        'hbr' =>'harbor',
        'height' =>'heights',
        'hgts' =>'heights',
        'highwy' =>'highway',
        'hiway' =>'highway',
        'hiwy' =>'highway',
        'hl' =>'hill',
        'hllw' =>'hollow',
        'hls' =>'hills',
        'hollows' =>'hollow',
        'holw' =>'hollow',
        'holws' =>'hollow',
        'hrbor' =>'harbor',
        'ht' =>'heights',
        'hts' =>'heights',
        'hvn' =>'haven',
        'hway' =>'highway',
        'hwy' =>'highway',
        'inlt' =>'inlet',
        'is' =>'island',
        'isles' =>'isle',
        'islnd' =>'island',
        'islnds' =>'islands',
        'iss' =>'islands',
        'jct' =>'junction',
        'jction' =>'junction',
        'jctn' =>'junction',
        'jctns' =>'junctions',
        'jcts' =>'junctions',
        'junctn' =>'junction',
        'juncton' =>'junction',
        'knl' =>'knoll',
        'knls' =>'knolls',
        'knol' =>'knoll',
        'ky' =>'key',
        'kys' =>'keys',
        'la' =>'lane',
        'lanes' =>'lane',
        'lck' =>'lock',
        'lcks' =>'locks',
        'ldg' =>'lodge',
        'ldge' =>'lodge',
        'lf' =>'loaf',
        'lgt' =>'light',
        'lk' =>'lake',
        'lks' =>'lakes',
        'ln' =>'lane',
        'lndg' =>'landing',
        'lndng' =>'landing',
        'lodg' =>'lodge',
        'loops' =>'loop',
        'mdw' =>'meadow',
        'mdws' =>'meadows',
        'medows' =>'meadows',
        'missn' =>'mission',
        'ml' =>'mill',
        'mls' =>'mills',
        'mnr' =>'manor',
        'mnrs' =>'manors',
        'mnt' =>'mount',
        'mntain' =>'mountain',
        'mntn' =>'mountain',
        'mntns' =>'mountains',
        'mountin' =>'mountain',
        'msn' =>'mission',
        'mssn' =>'mission',
        'mt' =>'mount',
        'mtin' =>'mountain',
        'mtn' =>'mountain',
        'nck' =>'neck',
        'orch' =>'orchard',
        'orchrd' =>'orchard',
        'ovl' =>'oval',
        'parkwy' =>'parkway',
        'paths' =>'path',
        'pikes' =>'pike',
        'pk' =>'park',
        'pkway' =>'parkway',
        'pkwy' =>'parkway',
        'pkwys' =>'parkways',
        'pky' =>'parkway',
        'pl' =>'place',
        'plaines' =>'plains',
        'pln' =>'plain',
        'plns' =>'plains',
        'plz' =>'plaza',
        'plza' =>'plaza',
        'pnes' =>'pines',
        'pr' =>'prairie',
        'prarie' =>'prairie',
        'prk' =>'park',
        'prr' =>'prairie',
        'prt' =>'port',
        'prts' =>'ports',
        'pt' =>'point',
        'pts' =>'points',
        'rad' =>'radial',
        'radiel' =>'radial',
        'radl' =>'radial',
        'ranches' =>'ranch',
        'rd' =>'road',
        'rdg' =>'ridge',
        'rdge' =>'ridge',
        'rdgs' =>'ridges',
        'rds' =>'roads',
        'riv' =>'river',
        'rivr' =>'river',
        'rnch' =>'ranch',
        'rnchs' =>'ranch',
        'rpd' =>'rapid',
        'rpds' =>'rapids',
        'rst' =>'rest',
        'rvr' =>'river',
        'shl' =>'shoal',
        'shls' =>'shoals',
        'shoar' =>'shore',
        'shoars' =>'shores',
        'shr' =>'shore',
        'shrs' =>'shores',
        'smt' =>'summit',
        'spg' =>'spring',
        'spgs' =>'springs',
        'spng' =>'spring',
        'spngs' =>'springs',
        'sprng' =>'spring',
        'sprngs' =>'springs',
        'sq' =>'square',
        'sqr' =>'square',
        'sqre' =>'square',
        'sqrs' =>'squares',
        'squ' =>'square',
        'st' =>'street',
        'sta' =>'station',
        'statn' =>'station',
        'stn' =>'station',
        'str' =>'street',
        'stra' =>'stravenue',
        'strav' =>'stravenue',
        'strave' =>'stravenue',
        'straven' =>'stravenue',
        'stravn' =>'stravenue',
        'streme' =>'stream',
        'strm' =>'stream',
        'strt' =>'street',
        'strvn' =>'stravenue',
        'strvnue' =>'stravenue',
        'sumit' =>'summit',
        'sumitt' =>'summit',
        'ter' =>'terrace',
        'terr' =>'terrace',
        'tpk' =>'turnpike',
        'tpke' =>'turnpike',
        'tr' =>'trail',
        'traces' =>'trace',
        'tracks' =>'track',
        'trails' =>'trail',
        'trak' =>'track',
        'trce' =>'trace',
        'trfy' =>'trafficway',
        'trk' =>'track',
        'trks' =>'track',
        'trl' =>'trail',
        'trls' =>'trail',
        'trnpk' =>'turnpike',
        'trpk' =>'turnpike',
        'tunel' =>'tunnel',
        'tunl' =>'tunnel',
        'tunls' =>'tunnel',
        'tunnels' =>'tunnel',
        'tunnl' =>'tunnel',
        'turnpk' =>'turnpike',
        'un' =>'union',
        'vally' =>'valley',
        'vdct' =>'viaduct',
        'via' =>'viaduct',
        'viadct' =>'viaduct',
        'vill' =>'village',
        'villag' =>'village',
        'villg' =>'village',
        'villiage' =>'village',
        'vis' =>'vista',
        'vist' =>'vista',
        'vl' =>'ville',
        'vlg' =>'village',
        'vlgs' =>'villages',
        'vlly' =>'valley',
        'vly' =>'valley',
        'vlys' =>'valleys',
        'vst' =>'vista',
        'vsta' =>'vista',
        'vw' =>'view',
        'vws' =>'views',
        'wls' =>'wells',
        'wy' =>'way',
        'xing' =>'crossing'
    ];

    /**
     * An array of secondary unit names indexed by abbreviation
     *
     * @see  https://www.usps.com/send/official-abbreviations.htm  a list of USPS
     *     secondary unit abbreviations ("Secondary Units" tab)
     */
    private const UNITS = [
        'apt' => 'apartment',
        'bldg' => 'building',
        'bsmt' => 'basement',
        'dept' => 'department',
        'fl' => 'floor',
        'frnt' => 'front',
        'hngr' => 'hangar',
        'lbby' => 'lobby',
        'lowr' => 'lower',
        'ofc' => 'office',
        'ph' => 'penthouse',
        'rm' => 'room',
        'spc' => 'space',
        'ste' => 'suite',
        'trlr' => 'trailer',
        'uppr' => 'upper'
    ];

    /**
     * Called when the service is treated as a function
     *
     * @param  AddressInterface  $address  the address to normalized
     * @return  Address  the normalized address
     */
    public function __invoke(AddressInterface $address): Address
    {
        $norm = new Address();

        if ($address->hasStreet1()) {
            $norm->setStreet1($this->normalizeStreet($address->getStreet1()));
        }

        if ($address->hasStreet2()) {
            $norm->setStreet2($this->normalizeStreet($address->getStreet2()));
        }

        if ($address->hasCity()) {
            $norm->setCity($this->normalizeCity($address->getCity()));
        }

        if ($address->hasState()) {
            $norm->setState($this->normalizeState($address->getState()));
        }

        if ($address->hasZip()) {
            $norm->setZip($this->normalizeZip($address->getZip()));
        }

        return $norm;
    }

    /**
     * Normalizes a city name to its down-cased, trimmed version
     *
     * For example:
     *
     *     $this->normalizeCity("Baton Rouge");   // returns "baton rouge"
     *     $this->normalizeCity("baton rouge");   // returns "baton rouge"
     *     $this->normalizeCity("baton rouge ");  // returns "baton rouge"
     *
     * @param  string  $city  the city to normalize
     * @return  string  the normalized city
     */
    private function normalizeCity(string $city): string
    {
        return $this->reduce($city);
    }

    /**
     * Normalizes a state name to its down-cased, trimmed, unabbreviated version
     *
     * For example:
     *
     *     $this->normalizeState("LA");         // returns "louisiana"
     *     $this->normalizeState("la.");        // returns "louisiana"
     *     $this->normalizeState("Louisiana");  // returns "louisiana"
     *
     * @param  string  $state  the state to normalize
     * @return  string  the normalized state
     */
    public function normalizeState(string $state): string
    {
        return $this->unabbreviate($this->reduce($state), self::STATES);
    }

    /**
     * Normalizes a street address
     *
     * There is a lot that goes into a street address. There are compass directions,
     * secondary unit abbreviations, street suffixes, numbers (e.g., "101"), ordinal
     * numbers (e.g., "101st"), and cardinal numbers (e.g., "one hundred and first").
     *
     * I'll try to normalize all of that to the same string.
     *
     * For example:
     *
     *     normalizeStreet("123 101 st");                    // returns "123 101 street"
     *     normalizeStreet("123 101st st");                  // returns "123 101 street"
     *     normalizeStreet("123 one hundred and first st");  // returns "123 101 street"
     *
     * @param  string  $street  the street address to normalize
     * @return  string  the normalized street address
     */
    private function normalizeStreet(string $street): string
    {
        $street = $this->reduce($street);

        // number the street accordingly
        // e.g., "123 n. one hundred and first st, ste 123" -> "123 n. 101 st, ste 123"
        $street = $this->number($street);

        // un-abbreviate compass directions
        // e.g. (cont), "123 n. 101 st, ste 123" -> "123 north 101 st, ste 123"
        $street = $this->unabbreviate($street, self::DIRECTIONS);

        // un-abbreviate street suffixes
        // e.g. (cont), "123 north 101 st, ste 123" -> "123 north 101 street, ste 123"
        $street = $this->unabbreviate($street, self::SUFFIXES);

        // un-abbreviate secondary units
        // e.g. (cont), "123 north 101 street, ste 123" -> "123 north 101 street, suite 123"
        $street = $this->unabbreviate($street, self::UNITS);

        return $street;
    }

    /**
     * Normalizes a zip code to its first five digits
     *
     * For example:
     *
     *     $this->normalizeZip("12345");        // returns "12345"
     *     $this->normalizeZip("12345-67890");  // returns "12345"
     *
     * @param  string  $zip  the zip code to normalize
     * @return  string  the normalized zip code
     */
    private function normalizeZip(string $zip): string
    {
        return substr($zip, 0, 5);
    }

    /**
     * "Reduces" a string to its trimmed, lower-cased version
     *
     * @param  string  $string  the string to reduce
     * @return  string  the reduced string
     */
    private function reduce(string $string): string
    {
        return strtolower(trim($string));
    }

    /**
     * Replaces abbreviations in $string (with or without a trailing period)
     * with their corresponding $replacements
     *
     * For example:
     *
     *     $this->unabbreviate('a b c', ['a' => 'aaa']);  // returns "aaa b c"
     *     $this->unabbreviate('a b. c', ['b' => 'bbb']);  // returns "a bbb c"
     *
     * @param  string    $string        the string to translate
     * @param  string[]  $replacements  an array of abbreviations and replacements
     *     in the form of ['abbreviation' => 'replacement', ...]
     * @return  string
     */
    private function unabbreviate(string $string, array $replacements): string
    {
        $words = explode(' ', $string);

        foreach ($words as &$word) {
            foreach ($replacements as $search => $replace) {
                if ($word == $search || $word == $search.'.') {
                    $word = $replace;
                }
            }
        }

        return implode(' ', $words);
    }

    /**
     * Numbers a street address accordingly
     *
     * A street address contains a numeric street address in addition to,
     * potentially, a numeric street name (e.g., "123 101st st"). The street
     * name can be a number ("101"), an ordinal (e.g., "101st"), or a
     * cardinal (e.g., "one hundred and first"). Ultimately, all of those must
     * resolve to the same norm.
     *
     * For example:
     *
     *     $this->number("123 101 st");                    // returns "123 101 st"
     *     $this->number("123 101st st");                  // returns "123 101 st"
     *     $this->number("123 one hundred first st");      // returns "123 101 st"
     *     $this->number("123 one hundred and first st");  // returns "123 101 st"
     *
     * @param  string  $street  the street address to number
     * @return  string  the numbered street address
     */
    private function number(string $street): string
    {
        $words = explode(' ', $street);

        // get the numeric value of each word (or zero if the word is NaN)
        // e.g., ["123", "one", "hundred", "and", "first", "st"] ->
        //   [123, 1, 100, 0, 1, 0]
        $numbers = array_map(function ($v) {
            return Num::val($v);
        }, $words);

        // if the street address doesn't have numeric words, short-circuit
        // e.g., ["123", "101", "st"] has zero; ["123", "one", "hundred", "and",
        //   first", "st"] has three
        $hasNumerics = count(array_diff(array_filter($numbers), $words));
        if (!$hasNumerics) {
            return $street;
        }

        // otherwise, we need to replace the numeric words with their value...
        // e.g. ["123", "one", "hundred", "and", "first", "st"] -> ["123", "101", "st"]
        $newWords = [];

        // loop through the words and determine exactly ones need replacing (a
        // word needs replacing if the word's numeric value is not zero and it
        // isn't already a number in the address)
        $numerics = [];
        foreach ($words as $k => $word) {
            $numerics[] = ($numbers[$k] !== 0 && $numbers[$k] != $word);
        }

        // loop through the words (again)
        $number = [];
        foreach ($words as $k => $word) {
            // if the word is a "number word", add it to the current number
            // otherwise, if the word is "and", the number isn't empty, and the
            //    next word is a number word, add it to the number
            // finally, the word is not a number word and the current number is
            //   finished
            if ($numerics[$k]) {
                $number[] = $word;
            } elseif ($word === 'and'
                && !empty($number)
                && array_key_exists($k + 1, $numerics)
                && $numerics[$k+1]
            ) {
                $number[] = $word;
            } else {
                // if a number exists, it's complete
                // get the number's value, append it to new words, and reset the
                //   current number
                if (!empty($number)) {
                    $number     = implode(' ', $number);
                    $newWords[] = Num::val($number);
                    $number     = [];
                }
                $newWords[] = $word;
            }
        }

        return implode(' ', $newWords);
    }
}
