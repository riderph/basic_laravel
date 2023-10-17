## About project

- Notification
    + refer: https://thietkewebfull.com/huong-dan-notification-to-slack-laravel


## Login with Laravel Passport

### 1. Install and setting
[Install Laravel Passport](https://laravel.com/docs/10.x/passport)

### 2. Some note when install and implement
#### - Hashing secret client ([Docs](https://laravel.com/docs/10.x/passport#client-secret-hashing))
* Default Laravel passport will save text secret after run command create client to DB. If you want to secure it, pls enable this code
```php
Passport::hashClientSecrets();
```
#### - Custom model ([Docs](https://laravel.com/docs/10.x/passport#customizing-the-username-field))
* If you use method ``Auth::attempt``, default passport will query by `email` and `password`. You can custom field to passport find user by define method `findForPassport` in model user.
* Custom validate password

#### - Purging Tokens
* Some information of access token be saved in table `oauth_access_tokens`, you must config schedule when tokens have been revoked or expired, you might want to purge them from the database [Link](https://laravel.com/docs/10.x/passport#purging-tokens).

## Login by google
[Get accesstoken google on postman](https://www.linkedin.com/pulse/access-google-drive-rest-apis-using-oauth2-postman-haris-saleem)
