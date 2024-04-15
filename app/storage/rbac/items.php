<?php

return [
    [
        'name' => 'createPost',
        'type' => 'permission',
        'updated_at' => 1713167414,
        'created_at' => 1713167414,
    ],
    [
        'name' => 'updatePost',
        'rule_name' => 'App\\Console\\Commands\\Rbac\\Rules\\AdminOrOwnerRule',
        'type' => 'permission',
        'updated_at' => 1713167414,
        'created_at' => 1713167414,
    ],
    [
        'name' => 'deletePost',
        'rule_name' => 'App\\Console\\Commands\\Rbac\\Rules\\AdminOrOwnerRule',
        'type' => 'permission',
        'updated_at' => 1713167414,
        'created_at' => 1713167414,
    ],
    [
        'name' => 'author',
        'type' => 'role',
        'updated_at' => 1713167414,
        'created_at' => 1713167414,
        'children' => [
            'createPost',
            'updatePost',
            'deletePost',
        ],
    ],
    [
        'name' => 'admin',
        'type' => 'role',
        'updated_at' => 1713167414,
        'created_at' => 1713167414,
        'children' => [
            'author',
        ],
    ],
];
