Socialist
=========

Laravel Socialist Package





@Usage 

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


```php
// VKontakte
Socialist::factory('vk')->api('users.get',[
  'users_id' => '1,2,3,4,5',
  'access_token' => <access_token>,
]);
```

```php
// MailRu
Socialist::factory('mailru')->api('users.get',[
  'user_id' => '1,2,3,4,5',
]);
```

