# Constance

*PHP constants as enumerations.*

[![Build status]][Latest build]
[![Test coverage]][Test coverage report]
[![Uses semantic versioning]][SemVer]

## Installation and documentation

* Available as [Composer] package [eloquent/constance].
* [API documentation] available.

## What is Constance?

*Constance* is a library for representing PHP constants as an [enumerated type].
*Constance* supports both class-level and global constants, and is built upon
a powerful [enumeration library] to provide a rich feature set.

Amongst other uses, *Constance* allows a developer to:

- Type hint for a valid value as defined in a pre-existing set of constants.
  Examples include [PHP error levels], or [PDO attributes].
- Retrieve information about a constant from its value, such as its name (useful
  for logging and debugging).
- Perform simple operations on sets of constants with [bitwise] values,
  including retrieving members by bit-mask, or composing a bit-mask from an
  array of members.

*Constance* is most useful for dealing with pre-defined constants that the
developer has no control over. If it is within the developer's control to
implement a first-class enumeration, then the recommended approach is to use
an [enumeration library] directly.

## Implementing a *Constance* enumeration

*Constance* does not provide any concrete classes, but instead provides abstract
base classes to make implementation of constant enumerations extremely
simple. There are two abstract base classes - `AbstractClassConstant` for
class-level constants, and `AbstractGlobalConstant` for global constants.

### Class-level constants

This example demonstrates how to define an enumeration of [PDO attributes]:

```php
use Eloquent\Constance\AbstractClassConstant;

final class PdoAttribute extends AbstractClassConstant
{
    /**
     * The class to inspect for constants.
     */
    const CONSTANCE_CLASS = 'PDO';

    /**
     * The expression used to match constant names that should be included in
     * this enumeration.
     */
    const CONSTANCE_PATTERN = '{^ATTR_}';
}
```

As the example demonstrates, *Constance* enumerations are extremely simple to
implement. The constant `CONSTANCE_CLASS` tells *Constance* which class to
inspect for constants, and the optional constant `CONSTANCE_PATTERN` is a
regular expression used to limit which of the constants defined in
`CONSTANCE_CLASS` are defined as members of this enumeration. In this particular
case, the expression limits the members to constants starting with `ATTR_`.

This enumeration can now be used to retrieve information about a PDO attribute
constant when only its value is known at run-time:

```php
$attribute = PdoAttribute::memberByValue(PDO::ATTR_ERRMODE);

echo $attribute->name();          // outputs 'ATTR_ERRMODE'
echo $attribute->qualifiedName(); // outputs 'PDO::ATTR_ERRMODE'
```

`PdoAttribute` can also be used as a type hint that will only accept valid PDO
attributes. Note the special static call syntax for accessing members of an
enumeration:

```php
class MyConnection
{
    public function setAttribute(PdoAttribute $attribute, $value)
    {
        // ...
    }
}

$connection = new MyConnection;
$connection->setAttribute(PdoAttribute::ATTR_AUTOCOMMIT(), true);
$connection->setAttribute(PdoAttribute::ATTR_PERSISTENT(), false);
```

### Global constants

This example demonstrates how to define an enumeration of [PHP error levels]:

```php
use Eloquent\Constance\AbstractGlobalConstant;

final class ErrorLevel extends AbstractGlobalConstant
{
    /**
     * The expression used to match constant names that should be included in
     * this enumeration.
     */
    const CONSTANCE_PATTERN = '{^E_}';
}
```

Global constants are even simpler to implement than class-level constants.
The optional constant `CONSTANCE_PATTERN` is a regular expression used to limit
which globally defined constants are defined as members of this enumeration. In
this particular case, the expression limits the members to constants starting
with `E_`.

The above enumeration will contain members for all the defined PHP error level
constants, such as `E_NOTICE`, `E_WARNING`, `E_ERROR`, `E_ALL`, and `E_STRICT`.
Note that *Constance* provides some limited [bitwise] helper methods for dealing
with such sets of constants with bitwise values, which will be discussed in a
separate section.

## Bitwise logic

*Constance* provides some methods for dealing with sets of constants that have
[bitwise] values. The [PHP error levels] enumeration above serves as a good
example of such a set.

Assuming the `ErrorLevel` enumeration described above, the set of members
included in `E_ALL` can be determined like so:

```php
$members = ErrorLevel::membersByBitmask(E_ALL);
```

`$members` now contains an array of enumeration members representing all the
error levels included in `E_ALL` for the current run-time environment.
Conversely, the members that are *not* included can be determined just as
easily:

```php
$members = ErrorLevel::membersExcludedByBitmask(E_ALL);
```

A bit-mask can also be generated for an arbitrary set of enumeration members,
like so:

```php
$members = array(ErrorLevel::E_NOTICE(), ErrorLevel::E_DEPRECATED());
$bitmask = ErrorLevel::membersToBitmask($members);
```

`$bitmask` now contains a bit-mask that matches only `E_NOTICE` or
`E_DEPRECATED`.

Lastly, checking whether a given enumeration member matches a bit-mask is also
extremely simple:

```php
$isStrictByDefault = ErrorLevel::E_STRICT()->valueMatchesBitmask(E_ALL);
```

`$isStrictByDefault` will now contain a boolean value indicating whether `E_ALL`
includes strict standards warnings for the current run-time environment.

<!-- References -->

[bitwise]: http://en.wikipedia.org/wiki/Bitwise_operation
[enumerated type]: http://en.wikipedia.org/wiki/Enumerated_type
[enumeration library]: https://github.com/eloquent/enumeration
[PDO attributes]: http://www.php.net/manual/en/pdo.constants.php
[PHP error levels]: http://www.php.net/manual/en/errorfunc.constants.php

[API documentation]: http://lqnt.co/constance/artifacts/documentation/api/
[Build status]: https://api.travis-ci.org/eloquent/constance.png?branch=master
[Composer]: http://getcomposer.org/
[eloquent/constance]: https://packagist.org/packages/eloquent/constance
[Latest build]: https://travis-ci.org/eloquent/constance
[SemVer]: http://semver.org/
[Test coverage report]: https://coveralls.io/r/eloquent/constance
[Test coverage]: https://coveralls.io/repos/eloquent/constance/badge.png?branch=master
[Uses semantic versioning]: http://b.repl.ca/v1/semver-yes-brightgreen.png
