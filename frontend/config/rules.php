<?php

return [
    '/' => '/site/index',
    [
        'pattern' => 'swagger',
        'route' => 'site/swagger-yaml',
        'suffix' => '.yaml'
    ],
    '<module>' => '<module>/default/index',
    '<module>/<action>' => '<module>/default/<action>',
    '<module>/<action>/<id:[a-zA-Z0-9-]+>' => '<module>/default/<action>',
    '<module>/<controller>/<action>' => '<module>/<controller>/<action>',
    '<module>/<controller>/<action>/<id:[a-zA-z0-9-]+>' => '<module>/<controller>/<action>',
    /*['class' => 'yii\rest\UrlRule', 'controller' => '<module>/<controller>/<action>'],*/
];
