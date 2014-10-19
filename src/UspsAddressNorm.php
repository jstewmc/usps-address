<?php
/**
 * The file for the UspsAddressNorm class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2014 Jack Clayton
 * @license    MIT License <http://opensource.org/licenses/MIT>
 */

namespace Jstewmc\UspsAddress;

use Jstewmc\PhpHelpers\Num as Num;

/**
 * The United States Postal Service (USPS) address "norm" class
 *
  * Oftentimes, the same address can be written different ways. For example, both
 * "17 First Street" and "17 1st st" are the same physical address. However, to a
 * computer these different strings appear as different street addresses.
 *
 * This class attempts to normalize street addresses so that different forms of 
 * the same physical address appear as the same address. For example, "17 First 
 * Street" and "17 1st st" will both be normalized to "17 1 street".
 *
 * Keep in mind, normalized addresses are not pretty. They are not meant to be 
 * displayed to users. They are meant to help a computer compare two addresses for
 * for equality.
 *
 * Also, keep in mind, this class *does not* validate or authenticate addresses. 
 * That is, you can create an instance with a street address "abc 123 def", a city 
 * of "123", and a state of "xyz" (obviously, an invalid and inauthentic address). 
 * However, this class doesn't care.
 *
 * @since  0.1.0
 */
class UspsAddressNorm extends UspsAddress
{
	/* !Set methods */
	
	/** 
	 * (Normalizes) and sets the city
	 *
	 * @since  0.1.0
	 * @param  string  $string  the city
	 * @return  self
	 */
	public function setCity($city)
	{
		$this->city = self::normalizeCity($city);
		
		return $this;
	}
	
	/** 
	 * (Normalizes) and sets the state
	 *
	 * @since  0.1.0
	 * @param  string  $state  the state
	 * @return  self
	 */
	public function setState($state)
	{
		$this->state = self::normalizeState($state);
		
		return $this;
	}
	
	/**
	 * (Normalizes) and sets the first line of the street address
	 *
	 * @since  0.1.0
	 * @param  string  $street1  the first line of the street address
	 * @return  string
	 */
	public function setStreet1($street1)
	{
		$this->street1 = self::normalizeStreet($street1);
		
		return $this;
	}
	
	/**
	 * (Normalizes) and sets the second line of the street address
	 *
	 * @since  0.1.0
	 * @param  string  $street2  the second line of the street address
	 * @return  string
	 */
	public function setStreet2($street2)
	{
		$this->street2 = self::normalizeStreet($street2);
		
		return $this;
	}
	
	/** 
	 * (Normalizes) and sets the zip code
	 *
	 * @since  0.1.0
	 * @param  string|integer  $zip  the zip code
	 * @return  string
	 */
	public function setZip($zip)
	{
		$this->zip = self::normalizeZip($zip);
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs this object
	 *
	 * @param  string  $street1  the first line of the street address (optional; if 
	 *     omitted, defaults to null)
	 * @param  string  $street2  the second line of the street address (optional; if
	 *     omitted, defaults to null)
	 * @param  string  $city  the city (optional; if omitted, defaults to null)
	 * @param  string  $state  the state (optional; if omitted, defaults to null)
	 * @param  string  $zip  the zip (optional; if omitted, defaults to null)
	 * @return  UspsAddressNorm
	 */
	public function __construct($street1 = null, $street2 = null, $city = null, $state = null, $zip = null) 
	{
		if ($street1 !== null) {
			$this->setStreet1($street1);
		}
		
		if ($street2 !== null) {
			$this->setStreet2($street2);
		}
		
		if ($city !== null) {
			$this->setCity($city);
		}
		
		if ($state !== null) {
			$this->setState($state);
		}
		
		if ($zip !== null) {
			$this->setZip($zip);
		}
		
		return;
	}
	
	/* !Public methods */
	
	/**
	 * Normalizes a city name
	 *
	 * I'll lower-case and trim the city name.
	 *
	 * For example:
	 *
	 *     self::normalizeCity("Baton Rouge");   // returns "baton rouge"
	 *     self::normalizeCity("baton rouge");   // returns "baton rouge"
	 *     self::normalizeCity("baton rouge ");  // returns "baton rouge"
	 *
	 * @since  0.1.0
	 * @param  string  $city  the city name to normalize
	 * @return  string  the normalized city name
	 * @throws  InvalidArgumentException  if $city is not a string
	 */
	public static function normalizeCity($city)
	{
		if ($city !== null && is_string($city)) {
			$city = self::reduce($city);
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be a string city name"
			);
		}
		
		return $city;
	}
	
	/**
	 * Normalizes a state name
	 *
	 * I'll lower-case and trim the state name. Then, I'll replace USPS state 
	 * abbreviations (with or without a trailing period) with their full-word 
	 * equivalent.
	 * 
	 * For example:
	 *
	 *     self::normalizeState("LA");         // returns "louisiana"
	 *     self::normalizeState("la.");        // returns "louisiana"
	 *     self::normalizeState("Louisiana");  // returns "louisiana"
	 * 
	 * @since  0.1.0
	 * @param  string  $state  the state name to normalize
	 * @return  string  the normalized state name
	 * @throws  InvalidArgumentException  if $state is not a string
	 */
	public function normalizeState($state)
	{
		if ($state !== null && is_string($state)) {
			$state = self::unabbreviate(self::reduce($state), self::$states);
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be a string state name"
			);
		}
		
		return $state;
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
	 * @since  0.1.0
	 * @param  string  the street address to normalize
	 * @return  string  the normalized street address
	 * @throws  InvalidArgumentException  if $street is not a string
	 */
	public function normalizeStreet($street)
	{
		// validate $street
		if ($street === null || ! is_string($street)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be a string street address"
			);
		} 
		
		$street = self::reduce($street);
		
		// number the street accordingly
		// e.g., "123 101st st" -> "123 101 st"
		//
		$street = self::number($street);
		
		// un-abbreviate compass directions with or without trailing period
		// e.g., "n(.)" -> "north"
		//
		$street = self::unabbreviate($street, self::$directions);
		
		// un-abbreviate street suffixes with or without period
		// e.g. "st(.)" -> "street"
		//
		$street = self::unabbreviate($street, self::$suffixes);
		
		// un-abbreviate secondary units with or without trailing-period
		// e.g., "ste(.)" -> "suite"
		//
		$street = self::unabbreviate($street, self::$units);
		
		return $street;
	}
	
	/**
	 * Normalizes a zip code
	 *
	 * I'll return the zip code's first five digits. 
	 *
	 * For example:
	 *
	 *     self::normalizeZip("12345");        // returns "12345"
	 *     self::normalizeZip("12345-67890");  // returns "12345"
	 *
	 * @since  0.1.0
	 * @param  string|integer  $zip  the zip code to normalize
	 * @return  string  the normalized zip code
	 * @throws  InvalidArgumentException  if $zip is not a string or integer
	 */
	public function normalizeZip($zip)
	{
		if ($zip !== null && (is_int($zip) || is_string($zip))) {
			$zip = substr($zip, 0, 5);
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be a string or integer zip code"
			);
		}
		
		return $zip;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Returns a trimmed, lower-cased string
	 *
	 * Reducing a string removes two common causes of string difference - case and 
	 * trailing- or leading-whitespace.
	 *
	 * @since  0.1.0
	 * @param  string  $string  the string to clean
	 * @return  string  the "reduced" string
	 * @throws  InvalidArgumentException  if $string is not a string
	 */
	protected static function reduce($string)
	{	
		if ($string !== null && is_string($string)) {
			$string = strtolower(trim($string));	
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be a string"
			);
		}
		
		return $string;
	}
	
	/**
	 * Replaces abbreviations in $string with corresponding word in $replacements
	 *
	 * I'll replace all occurences of the abbreviation with or without a trailing period
	 * with its corresponding replacement. 
	 *
	 * For example:
	 *
	 *     self::unabbreviate('a b c', ['a' => 'alpha']);  // returns "alpha b c"
	 *     self::unabbreviate('a b. c', ['b' => 'beta']);  // returns "a beta c"
	 * 
	 * @since  0.1.0
	 * @param  string    $string        the string to translate
	 * @param  string[]  $replacements  an array of abbreviations and replacements 
	 *     in the form ['abbreviation' => 'replacement', ...]
	 * @return  string
	 */
	protected static function unabbreviate($string, $replacements) 
	{
		// if $string is not a string
		if ($string !== null && is_string($string)) {
			// if $replacements is an array
			if ($replacements !== null && is_array($replacements)) {
				// explode the string into words on space character
				$words = explode(' ', $string);
				// loop through the words
				foreach ($words as &$word) {
					// loop through the replacements
					foreach ($replacements as $search => $replace) {
						// if the word is the $search, replace it
						if ($word == $search || $word == $search.'.') {
							$word = $replace;
						}
					}
				}
				// glue it all back together
				$string = implode(' ', $words);
			} else {
				throw \InvalidArgumentException(
					__METHOD__."() expects parameter two, replacements, to be an array of "
						."replacements in the form ['from' => 'to', ...]"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, string, to be a string"
			);
		}
		
		return $string;
	}
	
	/** 
	 * Numbers a street address accordingly
	 *
	 * A street address contains a numeric street address in addition to, potentially,
	 * a numeric street name (e.g., "123 101st st"). The street name can be a number 
	 * ("101"), an ordinal (e.g., "101st"), or a cardinal (e.g., "one hundred and 
	 * first"). Ultimately, all of those should resolve to the same norm.
	 *
	 * For example:
	 * 
	 *     self::number("123 101 st");                    // returns "123 101 st"
	 *     self::number("123 101st st");                  // returns "123 101 st"
	 *     self::number("123 one hundred first st");      // returns "123 101 st"
	 *     self::number("123 one hundred and first st");  // returns "123 101 st"
	 *
	 * @since  0.1.0
	 * @param  string  $street  the street address to number
	 * @return  string
	 */
	protected static function number($street)
	{
		// validate street
		if ($street === null || ! is_string($street)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be a string street address"
			);
		}
	
		// break $street into words
		$words = explode(' ', $street);
		
		// get the numeric value of each word (or zero if the word is not a number)
		// for example, ["123", "one", "hundred", "and", "first", "st"] will become
		//     [123, 1, 100, 0, 1, 0]
		//
		$numbers = array_map(function ($v) {
			return \Jstewmc\PhpHelpers\Num::val($v);
		}, $words);	
		
		// if the street address has numeric words
		// for example, in the example above, there are three "number words" ("one", 
		//     "hundred", and "first")
		// 
		$hasNumerics = count(array_diff(array_filter($numbers), $words));
		if ($hasNumerics > 0) {
			// we're going to replace the numeric words with their value
			// for example, ["123", "one", "hundred", "and", "first", "st"] becomes 
			//     ["123", "101", "st"]
			//
			$newWords = array();
			
			// loop through the words and determine exactly which words need replacing
			// a word needs replacing if the word's numeric value is not zero and it isn't 
			//     already a number in the address, it needs to be replaced
			//
			$numerics = array();
			foreach ($words as $k => $word) {
				$numerics[] = ($numbers[$k] !== 0 && $numbers[$k] != $word);
			}
			
			// loop through the words (again)
			$number = array();
			foreach ($words as $k => $word) {
				// if the word is a "number word", add it to the number
				// otherwise, if the word is "and", the number isn't empty, and the next word 
				//    is a number word, add it to the number
				// finally, the word is not a number word and the number is finished
				//
				if ($numerics[$k]) {
					$number[] = $word;
				} elseif (
					$word === 'and' 
					&& ! empty($number) 
					&& array_key_exists($k + 1, $numerics) 
					&& $numerics[$k+1]
				) {
					$number[] = $word;
				} else {
					// if a number exists it's complete
					// get the number's value, append it to new words, and reset the number
					//
					if ( ! empty($number)) {
						$number     = implode(' ', $number);
						$newWords[] = \Jstewmc\PhpHelpers\Num::val($number);
						$number     = array();
					}
					$newWords[] = $word;
				}
			}
			// glue the street address back together again
			$street = implode(' ', $newWords);
		}		
		
		return $street;	
	}
}	
	