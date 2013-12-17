This is an example of processing callback from social networking + authorization and registration

cmd(bash)  
php artisan controller:make SocialistController

append line to file app/routes.php

```php
Route::any('socialist', ['as' => 'socialist', 'uses' => 'SocialistController@index']);
`

open edit file app/controllers/SocialistController.php
