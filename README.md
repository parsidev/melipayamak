laravelSms
==========

package for send sms with laravel5 (published for [smsazin.com](http://smsazin.com/sms)) this package only work for iranian mobile operator

installation
------------
For install this package Edit your project's ```composer.json``` file to require parsidev/azinsms

```php
"require": {
    "parsidev/azinsms": "dev-master"
},
```
Now, update Composer:
```
composer update
```
Once composer is finished, you need to add the service provider. Open ```config/app.php```, and add a new item to the providers array.
```
'Parsidev\Azinsms\AzinsmsServiceProvider',
```
Next, add a Facade for more convenient usage. In ```config/app.php``` add the following line to the aliases array:
```
'Azinsms' => 'Parsidev\Azinsms\Facades\Azinsms',
```
Publish config files:
```
php artisan vendor:publish
```
for change username, password and other configuration change ```config/azinsms.php```

Usage
-----
for use this package, please register on [smsazin.com](http://smsazin.com/sms)


### Send Message
```php
Azinsms::sendSMS('Recieptor number', 'text message'); // send normal message for a person

Azinsms::sendSMS(array('Recieptor number1', 'Recieptor number2'), 'text mesage'); // send normal message for persons

//---------------------------------------
$url   = 'www.google.com'; // Doesn't need http://
$title = 'Google Search Engine';
Azinsms::sendSMS('Recieptor number', "\n".$title."\n".$url, 'wap'); // send wap push message for a person

//---------------------------------------

Azinsms::sendSMS('Recieptor number', 'text message', 'flash'); // send flash message for a person
```

### Get Credit
```php
Azinsms::getCredit();
```

### Get Status
```php
Azinsms::getStatus('unique id'); // get status of sent message, you receive unique id from sendSMS function. 


$response = Azinsms::sendSMS('Recieptor number', 'text message');

$uniqeId = $response[0]->uid;

```