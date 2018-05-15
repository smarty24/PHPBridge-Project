<?php

return [
    'default' => '/topic/list',
    'errors' => '/error/:code',
    'routes' => [
        '/topic(/:action(/:id))' => [
            'controller' => '\Suggestotron\Controller\Topics',
            'action' => 'list',
        ],
        '/error(/:action(/:code))' => [
            'controller' => '\Suggestotron\Controller\Errors',
            'action' => 'index',
        ],
        '/vote(/:action(/:id))' => [
            'controller' => '\Suggestotron\Controller\Votes',
        ],
        '/:controller(/:action)' => [
            'controller' => '\Suggestotron\Controller\:controller',
            'action' => 'index',
        ],
    ]
];