<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'price-lists' => 'c,r,u,d',
            'reports' => 'c,r,u,d',
            'requests' => 'c,r,u,d,s,w,p,pr,sh,ca',
            'brands' => 'c,r,u,d',
            'medicines' => 'c,r,u,d',
        ],
        'director' => [
            'reports' => 'c,r,u,d',
        ],
        'head_manager' => [
            'requests' => 'r,u,s'
        ],
        'manager' => [
            'requests' => 'c,r,u,d,s,ca'
        ],
        'cashier' => [
            'requests' => 'r,u,p'
        ],
        'logist' => [
            'requests' => 'r,u,w,pr,sh'
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
        'd' => 'delete',
        's' => 'send',
        'w' => 'write-out',
        'p' => 'pay',
        'pr' => 'prepare',
        'sh' => 'ship',
        'ca' => 'cancel'
    ]
];
