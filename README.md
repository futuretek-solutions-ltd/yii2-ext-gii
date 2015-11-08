Futuretek Yii2 Gii Templates
============================
Templates for yii2-gii

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist futuretek/yii2-gii-generators "*"
```

or add

```
"futuretek/yii2-gii-generators": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
'modules' => [
            'gii' => [
                'class' => 'yii\gii\Module',
                'allowedIPs' => ['127.0.0.1', '::1'],
                'generators' => [
                    'smartyCrud' => [
                        'class' => 'futuretek\gii\generators\smartyCrud\Generator',
                        'templates' => [
                            'futuretek' => '@app/vendor/futuretek/yii2-gii-generators/smartyCrud/default',
                        ]
                    ],
                    'model' => [
                        'class' => 'yii\gii\generators\model\Generator',
                        'templates' => [
                            'futuretek' => '@app/vendor/futuretek/yii2-gii-generators/model',
                        ]
                    ]
                ]
            ],
        ]     
```