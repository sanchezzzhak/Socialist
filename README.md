Socialist
=========
Laravel Socialist Package

Installation
=======
You should install this package through Composer.

Edit your project's `composer.json` file to require `tutik/socialist`.

	"require": {
		"laravel/framework": "4.x",
		"tutik/socialist": "dev-master"
	},
	"minimum-stability" : "dev"

Next, update Composer from the Terminal:
    `composer update`

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

  `'Tutik\Socialist\SocialistServiceProvider',`


Usage 
=======
Create config file in base folder app

/app/config/api/socialist.php

```php
return [

    'vk' => [
        'app_id'       => '',
        'app_key'      => '',
        'redirect_url' => 'http://site/socialist',
    ],
    'mailru' => [
        'app_id'            => ,
        'app_key_private'   => '',
        'app_key'           => '',
        'redirect_url'      => 'http://site/socialist',
    ],

    'fb' => [
        'app_id'       => '',
        'app_key'      => '',
        'redirect_url' => 'http://site/socialist',
    ],
];
```


Create a controller and use

```php
<?php
use \Tutik\Socialist\Socialist;
```

```php
// VKontakte
$response = Socialist::factory('vk')->api('users.get',[
  'users_id' => '100500',   
  'access_token' => <access_token>,
]);
$response = array_shift($data['response']);
```

```php
// MailRu
$mail = Socialist::factory('mailru');
if ($uid  = $mail->isAuth()) {
    $response = $mail->api('users.getInfo', array('uids' => $uid));
    $response = array_shift($response);   // User Data
}
```

```php
// Facebook
$facebook = Socialist::factory('facebook'); // or alias fb
$user = $facebook->getUser();
if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    $user = null;
  }
}
```

```php
// @TODO Google+


```
