[![Build Status](https://travis-ci.org/Milantex/milantex-tpc.svg?branch=master)](https://travis-ci.org/Milantex/milantex-tpc)
[![codecov](https://codecov.io/gh/Milantex/milantex-tpc/branch/master/graph/badge.svg)](https://codecov.io/gh/Milantex/milantex-tpc)
[![Code Climate](https://codeclimate.com/github/Milantex/milantex-tpc/badges/gpa.svg)](https://codeclimate.com/github/Milantex/milantex-tpc)
[![Latest Stable Version](https://poser.pugx.org/milantex/tpc/v/stable)](https://packagist.org/packages/milantex/tpc)
[![Total Downloads](https://poser.pugx.org/milantex/tpc/downloads)](https://packagist.org/packages/milantex/tpc)
[![License](https://poser.pugx.org/milantex/tpc/license)](https://packagist.org/packages/milantex/tpc)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4d51d53a-f7bb-4be6-bc6a-af4ecbba9903/mini.png)](https://insight.sensiolabs.com/projects/4d51d53a-f7bb-4be6-bc6a-af4ecbba9903)

# What are Milantex Typed Property Classes?
This project provides a mechanism to specify types for class properties. Also, property types have additional parameters, such as the regular expression pattern for strings, minimum and maximum value for integers etc. The special setter method handles type checking and will set the given value only if it is valid for the given type and its additional parameters. Check the documentation for an example.

## Installation
#### Using composer in the command line
You can use composer to install the package using the following command from within your project's source directory:

`composer require milantex/tpc`

Make sure to update your autoloader if needed:

`composer dump-autoload -o`

#### Requiring the package as a dependency in composer.json
Add the following code to your composer.json. Here is an example of a composer.json file with the milantex/tpc package required:

```javascript
{
    "name": "your-name/your-project",
    "description": "Your project's description",
    "type": "project",
    "license": "MIT",
    "authors": [
        {
            "name": "Your Name",
            "email": "your@mail.tld"
        }
    ],
    "require": {
        "milantex/tpc": "*"
    }
}
```

Make sure to run the composer command to install dependencies:

`composer install`

## Using it in your project

Make sure that you require the vendor autoload file first.
```php
require_once 'vendor/autoload.php';
```

After that, to create a class with typed properties, it must extend the Milantex\TPC\TypedPropertyClass.

Class properties must be marked as protected (not private) and should never be left as public.

To define the type and add any additional type specific parameters, use the annotation comment.

The type class should be specified using the fully-qualified path, including the namespace and should be set for the @type tag.

Different types provide different parameters. Each parameter should be specified as a tag in the annotation comment.

To create setter methods, use the inherited setProperty method.

Look at the following example of a Student class with a couple of properties with different types, each specifying additional parameters and setter methods for each of the properties.

```php
<?php
    namespace Milantex\SampleApp;

    require_once '../../vendor/autoload.php';
    
    use Milantex\TPC\TypedPropertyClass;

    class Student extends TypedPropertyClass {
        /**
         * @type Milantex\TPC\Types\StringType
         * @pattern /^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/
         */
        protected $forename;
        
        /**
         * @type Milantex\TPC\Types\StringType
         * @pattern /^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/
         */
        protected $surname;
        
        /**
         * @type Milantex\TPC\Types\DateType
         * @min 1900-01-01
         */
        protected $birthDay;
        
        /**
         * @type Milantex\TPC\Types\IntType
         * @min 2005000000
         */
        protected $index;
        
        /**
         * @type Milantex\TPC\Types\IntType
         * @min 2005
         */
        protected $yearOfEnrollment;

        public function setForename(string $forename) : Student {
            return $this->setProperty('forename', $forename);
        }

        public function setSurname(string $surname) : Student {
            return $this->setProperty('surname', $surname);
        }

        public function setBirthDay(string $birthDay) : Student {
            return $this->setProperty('birthDay', $birthDay);
        }

        public function setIndex(int $index) : Student {
            return $this->setProperty('index', $index);
        }

        public function setYearOfEnrollment(int $yearOfEnrollment) : Student {
            return $this->setProperty('yearOfEnrollment', $yearOfEnrollment);
        }
    }
```

Now, in another file, create an instance of this class and attempt to set valid and invalid values for each property).
```php
<?php
    namespace Milantex\SampleApp;

    require_once './Student.php';

    $s = new Student();
    $s->setForename('Milan')
      ->setSurname('Tair')
      ->setBirthDay('1988-03-24')
      ->setYearOfEnrollment(2008)
      ->setIndex(2008213514);

    echo '<pre>' . print_r($s, true) . '</pre>';
```

**Output:**
```html
<pre>
  Milantex\SampleApp\Student Object
  (
      [forename:protected] => Milan
      [surname:protected] => Tair
      [birthDay:protected] => 1988-03-24
      [index:protected] => 2008213514
      [yearOfEnrollment:protected] => 2008
  )
</pre>
```

As you see, the valid values (currently all set using appropriate setters) were assigned to the properties of the $s object.

Now, see what happens when we try to set the forename to a value which is not valid (does not match the pattern defined for this property):
```php
    # See the definition of the $forename property in the Student class (regex)
    # Since the text above is not a valid forename format, it will not be set
    $s->setForename('Not a valid name');    # This value is not valid

    echo '<pre>' . print_r($s, true) . '</pre>';
```
**Output:**
```html
<pre>
  Milantex\SampleApp\Student Object
  (
      [forename:protected] => Milan
      [surname:protected] => Tair
      [birthDay:protected] => 1988-03-24
      [index:protected] => 2008213514
      [yearOfEnrollment:protected] => 2008
  )
</pre>
```
Note that the forename **did not** change to "Not a valid name". Instead, it remained "Milan", which was the latest valid value assigned to this property.

Now, some values will be valid and some will not (index and the year of enrolment). The original values will remain unchanged.
```php
    # Almost all data that follow is valid (forename, surname and birthday),
    # but the year and the index are not. These will not be set to new values.
    $s->setForename('Pera')
      ->setSurname('Peric')
      ->setBirthDay('1991-04-30')
      ->setYearOfEnrollment(208)   # This value is not valid
      ->setIndex(2083321);         # This value is not valid

    echo '<pre>' . print_r($s, true) . '</pre>';
```
**Output:**
```html
<pre>
  Milantex\SampleApp\Student Object
  (
      [forename:protected] => Pera
      [surname:protected] => Peric
      [birthDay:protected] => 1991-04-30
      [index:protected] => 2008213514
      [yearOfEnrollment:protected] => 2008
  )
</pre>
```

Finally, the DateType class does not just check the format of the date, but also checks if the date is a valid date. Look at the example below:
```php
    # Tthis time the date will not be set, because it is impossible (May 31st).
    $s->setBirthDay('1991-04-31');   # There is no April 31st in the calendar

    echo '<pre>' . print_r($s, true) . '</pre>';
```
**Output:**
```html
<pre>
  Milantex\SampleApp\Student Object
  (
      [forename:protected] => Pera
      [surname:protected] => Peric
      [birthDay:protected] => 1991-04-30
      [index:protected] => 2008213514
      [yearOfEnrollment:protected] => 2008
  )
</pre>
```
As you can see, the previous valid date (April 30th) was unchanged, because the intended date was not a valid date, even though it was in the correct format.

## Supported types

Currently, there are only four type classes in the Milantex\TPC\Types namespace. These are:

### Milantex\TPC\Types\DateType

The DateType type class is used for properties of type date. The required format is YYYY-MM-DD.

#### Parameters:
##### @min

This parameter is used to specify the smallest date that can be set for this property. If not defined, the smallest date is 0000-00-00 at 00:00:00.

##### @max

This parameter is used to specify the biggest date that can be set for this property. If not defined, the biggest date is 9999-12-31 at 23:59:59.

### Milantex\TPC\Types\StringType

The StringType type class is used for properties of type string. Its main feature is the ability to define value validation using regular expressions.

#### Parameters:
##### @pattern

This parameter is used to specify the regular expression used to match the intended value for this property. If not defined, the default pattern is /^.*$/. The pattern is defined without quotes just like it would be in preg_* functions.

### Milantex\TPC\Types\IntType

The IntType type class is used for properties of type integer (or long).

#### Parameters:
##### @min

This parameter is used to specify the smallest value that can be set for this property. If not defined, the smallest value is \PHP_INT_MIN.

##### @max

This parameter is used to specify the biggest value that can be set for this property. If not defined, the biggest value is \PHP_INT_MAX.

### Milantex\TPC\Types\FloatType

The FloatType type class is used for properties of type float (or double).

#### Parameters:
##### @min

This parameter is used to specify the smallest value that can be set for this property. If not defined, the smallest value is \PHP_FLOAT_MIN.

##### @max

This parameter is used to specify the biggest value that can be set for this property. If not defined, the biggest value is \PHP_FLOAT_MAX.


## Creating custom types

You can create custom type classes. The type class must implement the Milantex\TPC\TypeInterface.

Look at the code for the FloatType type class for an example on how to create your own custom type classes.

```php
<?php
    namespace Milantex\TPC\Types;
    
    use Milantex\TPC\TypeInterface;

    class FloatType implements TypeInterface {
        private $min = \PHP_INT_MIN; # PHP_FLOAT_MIN will be available 7.2+
        private $max = \PHP_INT_MAX; # PHP_FLOAT_MAX will be available 7.2+

        public function __construct(\stdClass $tags) {
            if (\property_exists($tags, 'min') && \is_double($tags->min)) {
                $this->min = $tags->min;
            }

            if (\property_exists($tags, 'max') && \is_double($tags->max)) {
                $this->max = $tags->max;
            }
        }

        public function isValid($value) : bool {
            if (!\is_double($value)) {
                return false;
            }

            return $this->min <= $value && $value <= $this->max;
        }
    }
```
