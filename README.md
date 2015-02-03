## Package to add priority to Laravel routes

[![Latest Stable Version](https://poser.pugx.org/sleeping-owl/route-priority/v/stable.svg)](https://packagist.org/packages/sleeping-owl/route-priority)
[![License](https://poser.pugx.org/sleeping-owl/route-priority/license.svg)](https://packagist.org/packages/sleeping-owl/route-priority)

### Installation

Add `sleeping-owl/route-priority` to `composer.json`.

    "sleeping-owl/route-priority": "1.*"
    
Run `composer update` to pull down the latest version of the package. Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
        'SleepingOwl\RoutePriority\RoutePriorityServiceProvider'
    )

That's it. You now have some enhanced functionality available to your routes.

### Usage

Now you can change your routes priority:

```php
Route::get('my-route', ['uses' => 'MyController@myAction', 'as' => 'my-route'])->setPriority(100);
```

`Priority` is integer value.

### Default Priority

Default priority is `50 - already registered routes count`. So if you want higher priority - use values from 50 and above, lower priority - 10 and below.

### Example

```php
Route::get('/user/{wildcard}', …);
Route::get('/user/settings', …);
```

This code will register two routes. With default Laravel behaviour second route will not work. Just add priority to the first route to fix the error:

```php
Route::get('/user/{wildcard}', …)->setPriority(0);
Route::get('/user/settings', …);
```

Second route now has higher priority and will work.

## Support Library

You can donate in BTC: 13k36pym383rEmsBSLyWfT3TxCQMN2Lekd

## Copyright and License

Package was written by Sleeping Owl for the Laravel framework and is released under the MIT License. See the LICENSE file for details.
