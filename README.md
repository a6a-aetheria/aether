# Aether
Trait to add get-, set- and similar methods that simulate real class properties at runtime for rapid development.

[![Latest Stable Version](https://poser.pugx.org/a6a/aether/v)](//packagist.org/packages/a6a/aether) [![Total Downloads](https://poser.pugx.org/a6a/aether/downloads)](//packagist.org/packages/a6a/aether) [![Latest Unstable Version](https://poser.pugx.org/a6a/aether/v/unstable)](//packagist.org/packages/a6a/aether) [![License](https://poser.pugx.org/a6a/aether/license)](//packagist.org/packages/a6a/aether)

## Installation
Install aether via composer:
```shell
composer require a6a/aether
```
## Usage
Use the trait in any class to add get-, set-, unset-, merge-, and is- methods for accessing properties, flags, and lists. Replace the - with any upper case camel string.
```php
require_once 'vendor/autoload.php';

class A
{
  use \A6A\Aether\Aether;
}

$a = new A();


$a->setNiceName('Cavendish Beach');
$a->isOpen(true);

// later, somewhere else in the project ...

if($a->isOpen() && $a->hasNiceName()){
    
    ?>
    <p>Vacation at <?= $a->getNiceName() ?> this season!</p>
    <?php
    
}
```
### Properties
Set or get a property with the set- and get- methods. Check if a property has been set with has-. Clean up with unset- or uns-.
```php
// Getting a property that hasn't been set will return null.
$a->hasFoo(); // false
$a->getFoo(); // null

$a->setFoo('foo');
$a->hasFoo(); // true
$a->getFoo(); // 'foo'

$a->unsetFoo();
$a->hasFoo(); // false

// shorthand unset-
$a->setFoo('foo');
$a->unsFoo();
$a->getFoo(); // null

// Chain multiple set- or unset- to do a few at once.
$a->setFoo('foo')->setBar('bar')->setBaz('baz');
$a->unsFoo()->unsBaz();

// Get the whole set of properties with get()
$a->setOne(1)->setTwo(2);
$a->get(); // array('one' => 1, 'two' => 2)

// Unset all properties with unset() or uns()
$a->setOne(1)->setTwo(2);
$a->uns();
$a->get(); // array()

```
### Flags
Set or check a boolean flag with the is- method.
```php
$a->isOpen(true);
if($a->isOpen()){
    $a->isClosed(false);
}

// Any truthy or falsey value will do for setting but only true or false come out.
$a->isOpen(20);
if(true === $a->isOpen()) ... // true

// Get the whole set of flags with is()
$a->isApple(true);
$a->isFruit(true);
$a->isTasty(true);
$this->is(); // array('apple' => true, 'fruit' => true, 'tasty' => true);
```
### Lists
Merge multiple values together into a list of values with merge-.
```php
$a->mergeMyList('point #1');
$a->mergeMyList('point #2');

$a->getMyList(); // array('point #1', 'point #2');

// A previously set property will be converted to an array if a merge- is done later.
$a->setSales(array('July 19' => 7));
$a->mergeSales(array('July 18' => 11));
$a->getWins(); // array(array('July 19' => 7), array('July 18' => 11));

// The merge- returns the full list after adding the new value
$a->setFormats('bold');
$formats = $a->mergeFormats('italic'); // array('bold', 'italic')
```
## Purpose
These methods provide a casual way to code to tests and implement functionality in the early stages of a project. Go from nothing to something fast! They are also handy for one-off coding to deadlines when delivering a single financial or operations report, and similar.

Each usage of these methods causes a few extra lookups and some unnecessary overhead in your code. Think carbon footprint. Before your code enters production at significant scale and after you have plenty of passing tests to make refactoring easy, replace these with concrete implementations and real properties to improve code quality and efficiency.
## Changelog
See the [CHANGELOG](CHANGELOG.md) file.
## License
See the [LICENSE](LICENSE) file for license rights and limitations (MIT).