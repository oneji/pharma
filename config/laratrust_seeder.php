<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'price-lists' => 'c,r,u,d',
            'reports' => 'c,r,u,d',
            'requests' => 'c,r,u,d',
            'brands' => 'c,r,u,d',
            'medicines' => 'c,r,u,d'
        ],
        'director' => [
            'reports' => 'c,r,u,d',
        ],
        'head_manager' => [
            'requests' => 'r,u'
        ],
        'manager' => [
            'requests' => 'r,u'
        ],
        'cashier' => [
            'requests' => 'r,u'
        ],
        'logist' => [
            'requests' => 'r,u'
        ],
        'client' => [
            'price-lists' => 'c,r,u,d',
            'requests' => 'c,r,u,d'
        ],
    ],
    'permission_structure' => [
        
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
