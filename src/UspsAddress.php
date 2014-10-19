<?php
/**
 * The file for the Address class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2014 Jack Clayton
 * @license    MIT License <http://opensource.org/licenses/MIT>
 */ 

namespace Jstewmc\UspsAddress;

/** 
 * The United States Postal Service (USPS) address class
 *
 * @since  0.1.0
 */
class UspsAddress
{
	/* !Public properties */
	
	/**
	 * @var  array  an array of compass directions indexed by abbreviation
	 */
	public static $directions = array(
		'n'  => 'north',
		'ne' => 'northeast',
		'e'  => 'east',
		'se' => 'southeast',
		's'  => 'south',
		'sw' => 'southwest',
		'w'  => 'west',
		'nw' => 'northwest'
	);
	
	/**
	 * @var  array  an array of US states indexed by abbreviation (includes military 
	 *     "states" but uses a custom state name for the ambigous "ae" abbreviation)
	 * @see  https://www.usps.com/send/official-abbreviations.htm  a list of USPS
	 *     state and military state abbreviations ("States" tab)
	 */ 
	public static $states = array(
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
	);
	
	/**
	 * @var  array  an array of street suffixes indexed by abbreviation or common
	 *     mis-spelling
	 * @see  https://www.usps.com/send/official-abbreviations.htm  a list of USPS street
	 *    abbreviations ("Street Suffixes" tab)
	 */
	public static $suffixes = array(
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
	);
	
	/**
	 * @var  array  an array of secondary unit names indexed by abbreviation
	 * @see  https://www.usps.com/send/official-abbreviations.htm  a list of USPS
	 *     secondary unit abbreviations ("Secondary Units" tab)
	 */
	public static $units = array(
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
	);
	
	
	/* !Protected properties */
	
	/**
	 * @var  string  the first line of the street address
	 */
	protected $street1;
	
	/** 
	 * @var  string  the second line of the street address
	 */
	protected $street2;
	
	/**
	 * @var  string  the city's name
	 */
	protected $city;
	
	/**
	 * @var  string  the state's name
	 */
	protected $state;
	
	/**
	 * @var  string  the zip code
	 */
	protected $zip;
	
	
	/* !Get methods */
	
	/** 
	 * Returns the city
	 * 
	 * @since  0.1.0
	 * @return  string|null
	 */
	public function getCity()
	{
		return $this->city;
	}
	
	/** 
	 * Returns the state
	 *
	 * @since  0.1.0
	 * @return  string|null
	 */
	public function getState()
	{
		return $this->state;
	}
	
	/**
	 * Returns the first line of the street address
	 *
	 * @since  0.1.0
	 * @return  string|null
	 */
	public function getStreet1()
	{
		return $this->street1;	
	}
	
	/** 
	 * Returns the second line of the street address
	 *
	 * @since  0.1.0
	 * @return  string|null
	 */
	public function getStreet2()
	{
		return $this->street2;
	}
	
	/**
	 * Returns the zip code
	 *
	 * @since  0.1.0
	 * @return  string|null
	 */
	public function getZip()
	{
		return $this->zip;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the city
	 * 
	 * @since  0.1.0
	 * @param  string  $city  the city
	 * @return  self
	 */
	public function setCity($city)
	{
		$this->city = $city;
		
		return $this;
	}
	
	/**
	 * Sets the state
	 * 
	 * @since  0.1.0
	 * @param  string  $state  the state
	 * @return  self
	 */
	public function setState($state)
	{
		$this->state = $state;
		
		return $this;
	}
	
	/**
	 * Sets the first line of the street address
	 *
	 * @since  0.1.0
	 * @param  string  $street1  the first line of the street address
	 * @return  self
	 */
	public function setStreet1($street1)
	{
		$this->street1 = $street1;
		
		return $this;
	}
	
	/**
	 * Sets the second line of the street address
	 *
	 * @since  0.1.0
	 * @param  string  $street2  the second line of the street address
	 * @return  self
	 */
	public function setStreet2($street2)
	{
		$this->street2 = $street2;
		
		return $this;
	}

	/**
	 * Sets the zip code
	 *
	 * @since  0.1.0
	 * @param  integer|string  $zip  the address zip code
	 * @return  self
	 */
	public function setZip($zip)
	{
		$this->zip = $zip;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/** 
	 * Constructs the object
	 *
	 * @param  string  $street1  the first line of the street address (optional; if 
	 *     omitted, defaults to null)
	 * @param  string  $street2  the second line of the street address (optional; if
	 *     omitted, defaults to null)
	 * @param  string  $city  the city (optional; if omitted, defaults to null)
	 * @param  string  $state  the state (optional; if omitted, defaults to null)
	 * @param  string  $zip  the zip (optional; if omitted, defaults to null)
	 * @return  UspsAddress
	 */
	public function __construct($street1 = null, $street2 = null, $city = null, $state = null, $zip = null)
	{
		$this->street1 = $street1;
		$this->street2 = $street2;
		$this->city    = $city;
		$this->state   = $state;
		$this->zip     = $zip;
		
		return;
	}
	
	
	/* !Public methods */
	
	/**
	 * Returns true if this address equals $address
	 *
	 * @param  Jstewmc\UspsAddress  $address  the address to compare for equality
	 * @return  bool
	 * @throws  InvalidArgumentException  if $address is not a UspsAddress
	 */
	public function equals($address)
	{
		if ( ! $address instanceof UspsAddress) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be an instance of a UspsAddress"
			);	
		}
		
		return $this->getNorm()->getHash() === $address->getNorm()->getHash();
	}
	
	/**
	 * Returns the MD5 hash of this address
	 *
	 * Comparing addresses for equality is a pain. You have to compare five different
	 * fields. Forget that. Just compare the hashes.
	 *
	 * @since  0.1.0
	 * @return  string
	 */
	public function getHash()
	{
		return md5(
			(string) $this->street1.
			(string) $this->street2.
			(string) $this->city.
			(string) $this->state.
			(string) $this->zip
		);
	}
	
	/**
	 * Returns the norm of this address
	 *
	 * The same physical address can usually be written several different ways.
	 * Normalizing the different addresses should remove the difference.
	 *
	 * @since  0.1.0
	 * @return  UspsAddressNorm
	 */
	public function getNorm()
	{
		return new UspsAddressNorm(
			$this->street1, 
			$this->street2, 
			$this->city, 
			$this->state, 
			$this->zip
		);
	}
}
