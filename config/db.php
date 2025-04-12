<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=test3-mysql-1;port=3306;dbname=yii2basic',
//    'dsn' => 'mysql:host=localhost;port=3306;dbname=yii2basic',
    'username' => 'yii2basic',
    'password' => 'yii2basic',
    'charset' => 'utf8mb4',
    'tablePrefix' => 'tw3_',
    'enableSchemaCache' => true,
    'emulatePrepare' => true,
];
