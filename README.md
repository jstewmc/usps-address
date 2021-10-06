# USPS Address

A library for normalizing and comparing United States Postal Service (USPS) addresses in PHP.

Comparing addresses is tricky. There are many different ways to represent the same physical address. For example, "123 *First* St" is the same address as "123 *1st* St". However, to a computer, those are two different things.

This library attempts to normalize addresses so that different forms of the same physical address can be compared. For example, "17 First Street" and "17 1st st" will be considered equal.

There are a few caveats:

1. A normalized address should not be displayed to users. It's formatted to help a computer compare addresses for equality, and it's not "pretty".
2. A normalized address should not be saved over the original address. The normalized version of an address may change as this library's algorithm improves, but once you overwrite the original address, it's gone forever.
3. A normalized address should not be considered _authentic_. This library will normalize and compare whatever address you give it, regardless of whether or not it actually exists. If you don't mind using a web service, there are APIs available that can normalize, validate, and authenticate addresses for you.

## Installation

This library requires [PHP 7.4+](https://secure.php.net).

It is multi-platform, and we strive to make it run equally well on Windows, Linux, and OSX.

It should be installed via [Composer](https://getcomposer.org). To do so, add the following line to the `require` section of your `composer.json` file, and run `composer update`:

```javascript
{
   "require": {
       "jstewmc/usps-address": "^0.2"
   }
}
```

## Usage

This library defines an interface for USPS addresses, `AddressInterface`, which supports a two-line street address, a city, a state, and a zip code, for example:

```
123 Foo St
Apt 456
Baton Rouge, LA 12345
```

All components are optional to support partial data.

This library provides an implementation of the interface, `Address`, as well as a `trait`, `Addressable`, which you can use in your own classes to implement the interface.

### Using your implementation

When using your implementation of `AddressInterface` (let's call it `MyAddress`), you can use this library's `Compare` service to compare addresses:

```php
use Jstewmc\UspsAddress\Compare;

// instantiate the compare service (ideally, from your service manager)
$compare = new Compare();

// instantiate your address
$address1 = (new MyAddress())
  ->setStreet1('Thirty-one Spooner Street')
	->setCity('Quahog')
	->setState('Rhode Island')
	->setZip('12345');

// instantiate a same-but-different address
$address2 = (new MyAddress())
  ->setStreet1('31 Spooner St')
	->setCity('Quahog')
	->setState('RI')
	->setZip('12345');

$compare($address1, $address2);  // returns true
```

If you'd like to access a lower-level normalized address, you can use the `Normalize` service to do so. Keep in mind, this service will accept any implementation of the `AddressInterface`, and it will return an instance of our own implementation, `Address`:

```php
use Jstewmc\UspsAddress\Normalize;

// instantiate the normalize service (ideally, from your service manager)
$normalize = new Normalize();

// create an instance of your implementation
$address = (new MyAddress())
  ->setStreet1('Thirty-one Spooner Street')
	->setCity('Quahog')
	->setState('Rhode Island')
	->setZip('12345');

$norm = $normalize($address);

$norm->getStreet1();  // returns "31 spooner st"
$norm->getCity();     // returns "quahog"
$norm->getState();    // returns "rhode island"
$norm->getZip();      // returns "12345"

$norm instanceof \Jstewmc\UspsAddress\Address;  // returns true
```

If you're using both services, you can inject your instance of the `Normalize` service into your instance of the `Compare` service. Otherwise, the `Compare` service will instantiate its own copy of the `Normalize` service:

```php
use Jstewmc\UspsAddress\{Compare, Normalize};

$normalize = new Normalize();

$compare = new Compare($normalize);
```

### Using our implementation

Our implementation of `AddressInterface`, `Address`, provides two methods - `equals()` and `normalize()` - for convenience. These methods are reasonable shortcuts to managing the services if you aren't processing a large number of addresses. With large enough datasets, the methods' instantiating and discarding single-use objects may affect memory and performance.

```php
use Jstewmc\UspsAddress\Address;

// create an address using our implementation
$address1 = (new Address())
  ->setStreet1('Thirty-one Spooner Street')
	->setCity('Quahog')
	->setState('Rhode Island')
	->setZip('12345');

// create a same-but-different address
$address2 = (new Address())
  ->setStreet1('31 Spooner St')
	->setCity('Quahog')
	->setState('RI')
	->setZip('12345');

$address1->equals($address2);  // returns true

$norm = $address1->normalize();

$norm->getStreet1();  // returns "31 spooner st"
$norm->getCity();     // returns "quahog"
$norm->getState();    // returns "rhode island"
$norm->getZip();      // returns "12345"
```

Our implementation also allows you to instantiate an address using the constructor alone:

```php
use Jstewmc\UspsAddress\Address;

// Like an address, the arguments, in order, are: street 1, street 2, city, state, and zip
new Address('31 Spooner St', null, 'Quahog', 'RI', '12345');
```

## Migrating from `0.1`

This library changed substantially from `0.1` to `0.2`:

1. We moved previously `public static` properties to private constants to better encapsulate them.
1. We moved previously `public static` methods to a service for a service-friendly, easier-to-test solution.
1. We programmed to an interface, not an implementation, and provided a trait to make the library easier to use with your own code.
1. We removed the `Usps` prefix from class names, because it didn't add information not already obvious from the library's name.

As a result, migrating from `0.1` to `0.2` involves a number of breaking changes. Although painful, we believe it will make the library easier to use and maintain in the future.

## Contributing

Contributions are welcome!

```bash
# Clone the repository (assuming you have Git installed).
~/path/to $ git clone git@github.com:jstewmc/usps-address.git

# Install dependencies (assuming you are using Composer locally).
~/path/to/usps-address $ php composer.phar install

# Run the tests.
~/path/to/usps-address $ ./vendor/bin/phpunit

# Create and checkout a new branch.
~/path/to/usps-address $ git branch -c YOUR_BRANCH_NAME

# Make your changes...

# Run the tests again.
~/path/to/usps-address $ ./vendor/bin/phpunit

# Lint your changes.
~/path/to/usps-address $ ./vendor/bin/phpcs .

# Push your changes to Github and create a pull request.
~/path/to/usps-address $ git push origin YOUR_BRANCH_NAME
```

## License

This library is released under the [MIT License](LICENSE).
