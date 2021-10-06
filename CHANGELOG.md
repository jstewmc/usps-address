# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.2.0] - 2021-10-05

Version `0.2.0` includes a number of breaking changes, intended to make the library easier to use and maintain.

### Removed

- Removed `UspsAddressNorm`, because the class had way too many responsibilities.

### Changed

- Renamed `UspsAddress` to `Address`, because the prefix didn't add new information.
- Renamed the `getNorm()` method to `normalize()`.

### Added

- Added `Normalize` and `Compare` services for service-oriented architectures.
- Added `AddressInterface` so you don't have to use our `Address` implementation.
- Added `Addressable` trait so you can use it in your own classes to implement the interface.
- Added [slevomat/coding-standard](https://github.com/slevomat/coding-standard) to enforce coding standards.
- Added [roave/security-advisories](https://github.com/Roave/SecurityAdvisories) to exclude dependencies with known vulnerabilities.
- Added continuous integration with [CircleCI](https://circleci.com/gh/jstewmc/usps-address).
- Added code coverage analysis with [CodeCov](https://codecov.io/gh/jstewmc/usps-address).

## [0.1.0] - 2014-10-18

The initial release.
