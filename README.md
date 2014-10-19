# USPS Address
A simple class for a (normalized) United States Postal Service (USPS) address.

On a project in Fall 2014, I needed to compare United States Postal Service (USPS) addresses. 

Comparing addresses is tricky. There are many different ways to represent the same physical address. For example, "123 First St" is the same address as "123 1st Street". However, to a computer, those are two different strings. 

Of course, these days there are several API's that normalize, validate, and authenticate USPS addresses. However, I needed to compare thousands of USPS addresses at a time. I didn't want to rely on a web service (most of which require you to use their system to use their API). I probably couldn't afford it, and they probably wouldn't like me banging away at their servers all day.

So, I wrote my own elementary USPS address class (and USPS normalized address).

[API documentation](https://jstewmc.github.io/usps-address/api/0.1.0), [report an issue](https://github.com/jstewmc/usps-address/issues), [contribute](https://github.com/jstewmc/usps-address/blob/master/contributing.md), or [ask a question](mailto:clayjs0@gmail.com)

```php
// create two USPS addresses
$a = new UspsAddress();
$a->setStreet1('Thirty-one Spooner Street')  // note "Thirty-one" and "Street"
	->setCity('Quahog')
	->setState('Rhode Island')       // note "rhode island"
	->setZip('12345');

$b = new UspsAddress();
$b->setStreet1('31 Spooner St')  // note "31" and "St"
	->setCity('Quahog')
	->setState('RI')             // note "RI"
	->setZip('12345');

// I've used setters here you can also set properties at instantiation:
//     new UspsAddress($street1, $street2, $city, $state, $zip);

$a->equals($b);  // returns true

// the UspsAddress class compares addresses using their normalized versions
// that is, it translates abbreviations, lower-cases, trims whitespace, 
//     converts numeric words to their numeric value, etc

// you can access the normalized version of an address directly if you'd like
$A = $a->getNorm();
$B = $b->getNorm();

// you can also get the address' md5 hash if you'd like to compare it yourself
$a->getHash();  // returns "dc9a67eeb699f3d04ae4ee64b7cf014e"
$b->getHash();  // returns "d8b16c02b495d0b657e44d28e8810ce5"
$A->getHash();  // returns "a8262953aa90b4082d53081701034a56"
$B->getHash();  // returns "a8262953aa90b4082d53081701034a56"

## Tests

I've written tests with about 90% coverage. I'm still getting used to writing unit tests, so let me know if I made a mistake somewhere. 

## Contributing

Feel free to contribute your own improvements:

1. Fork
2. Clone
3. PHPUnit
4. Branch
5. PHPUnit
6. Code
7. PHPUnit
8. Commit
9. Push
10. Pull request
11. Relax and eat a Paleo muffin

See [contributing.md](https://github.com/jstewmc/usps-address/blob/master/contributing.md) for details.

## Author

Jack Clayton - [clayjs0@gmail.com](mailto:clayjs0@gmail.com).

## License

The UspsAddress library is released under the MIT License. See the [LICENSE](https://github.com/jstewmc/usps-address/blob/master/LICENSE) file for details.

## History

You can view the (short) history of the UspsAddress project in the [changelog.md](https://github.com/jstewmc/usps-address/blob/master/changelog.md) file.
