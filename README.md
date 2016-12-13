# Yii2 Mailgun mailer

[![Latest version](https://poser.pugx.org/understeam/yii2-mailgun/version)](https://packagist.org/packages/understeam/yii2-mailgun)

Install through Composer:

```
composer require understeam/yii2-mailgun:^0.2 --prefer-dist
```

Configure:

```php
...
'mailer' => [
    'class' => 'understeam\mailgun\Mailer',
    'domain' => 'domain.com',
    'apiKey' => 'api-key',
],
...
```

Use:

```php
$message = Yii::$app->mailer->compose('@common/mail/signup', ['user' => $user]);
$message->send();
```

