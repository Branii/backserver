# Modern PHP Exception

Display PHP errors and exceptions in a modern and intuitive way!

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1651412244/modern-php-exception-2_ftm2yq.png">

## Installing via Composer

Use the command below:

```
composer require brenno-duarte/modern-php-exception
```

## How to use

You only need to call a single method as shown below.

```php
use ModernPHPException\ModernPHPException;

$exc = new ModernPHPException();
$exc->start();
```

From there, all errors and exceptions that are triggered will be displayed through the ModernPHPException component.

You can change the return, title and theme settings in the class constructor as shown in the items below.

## Return in JSON

To return an exception in JSON, use the `setFromJson()` method.

```php
$exc = new ModernPHPException();
$exc->setFromJson();
$exc->start();
```

Or, use an array in the class's constructor.

```php
$exc = new ModernPHPException([
    'type' => 'json'
]);
$exc->start();
```

## Return in Text

To return an exception in text, use the `setFromText()` method.

```php
$exc = new ModernPHPException();
$exc->setFromText();
$exc->start();
```

Or, use an array in the class's constructor.

```php
$exc = new ModernPHPException([
    'type' => 'text'
]);
$exc->start();
```

## Changing the title

You can change the page title using `setTitle`.

```php
# ...
$exc->setTitle("My title");
# ...
```

Or, use an array in the class's constructor.

```php
$exc = new ModernPHPException([
    'title' => 'My title'
]);
$exc->start();
```

## Dark mode

To change the whole theme, use `useDarkTheme`.

```php
#...
$exc->useDarkTheme();
#...
```

Or, use an array in the class's constructor.

```php
$exc = new ModernPHPException([
    'dark_mode' => true
]);
$exc->start();
```

# Production mode

When a project made in PHP is in production, it's not good to have technical errors. Therefore, you can display a screen for these cases.

```php
$exc = new ModernPHPException([
    'production_mode' => true
]);
$exc->start();
```

To change the default message that will be displayed, you can use the `productionModeMessage()` method:

```php
$exc = new ModernPHPException([
    'production_mode' => true
]);
$exc->productionModeMessage("Server error");
$exc->start();
```

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1651412180/production-mode_zajewg.png">

# Using try/catch

To display an exception inside a try/catch block, use the `exceptionHandler()` method:

```php
#...

function divide($x, $y) {
    if ($y == 0) {
        throw new \Exception('is a division by zero.');
    }
    $result = $x / $y;
    return $result;
};

try {
    echo divide(5,0);
} catch (\Exception $e) {
    $exc->exceptionHandler($e);
}
``` 

If necessary, you can also use the `errorHandler()` method.

# Creating a solution for an exception

If you are creating a custom exception class, you can add a solution to resolve this exception.

For that, use the static `getSolution` method implementing the `SolutionInterface` interface:

```php
<?php

namespace Test;

use ModernPHPException\Solution;
use ModernPHPException\Interface\SolutionInterface;

class CustomException extends \Exception implements SolutionInterface
{
    public function getSolution(): Solution
    {
        return Solution::createSolution('My Solution')
            ->setDescription('description')
            ->setDocs('https://google.com');
    }

    #...
```

``createSolution:`` Name of solution to fix exception

``setDescription:`` Detailed description of exception solution

``setDocs:`` If a documentation exists, this method will display a button for a documentation. By default, the name of the button will be `Read More`, but you can change the name by changing the second parameter of the method

You can test using a new class:

```php
public static function staticCall()
{
    throw new CustomException("Error Processing Request");
}
```

## Test

If you want to test the component, use the `UserTest` class inside the `test/` folder or use the code below in your `index.php`.

```php
<?php

require 'vendor/autoload.php';

use ModernPHPException\ModernPHPException;
use Test\UserTest;

$exc = new ModernPHPException();
$exc->start();

#throw new Exception("Error Test", 1);

$user = new UserTest();
$user->secondCall();
```

## License

MIT
