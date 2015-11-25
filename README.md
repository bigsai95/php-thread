#Forker

PHP 子程序

## Composer
    {
        "require": {
            "rde/adapter": "dev-master"
        }
    }

## Code Example
```php
require __DIR__.'/../vendor/autoload.php';

use Aban\Thread\Forker;

$p = new Forker();
$p->add(array(1));
$p->run(function(){$pid = getmypid(); echo "$pid payload\n";});
```