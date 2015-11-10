Futuretek Yii2 Gii Templates
============================
Templates and generators for yii2-gii

> Should be used only for development. `require-dev`

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require-dev futuretek/yii2-gii-generators "*"
```

or add to require-dev

```
"futuretek/yii2-gii-generators": "*"
```

to the require section of your `composer.json` file.


Usage
-----
It has automatic configuration. See `composer.json` - `extra:yii-config:web`


Or you can use your own configuration like this

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
            'ftsCrud' => [
                'class' => 'futuretek\gii\generators\crud\Generator',
                'templates' => [
                    'default' => '@app/vendor/futuretek/yii2-gii-generators/crud/default',
                    'purus' => '@app/vendor/futuretek/yii2-gii-generators/crud/purus',
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