<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'article_categories' => 'c,r,u,d',
            'plan_categories' => 'c,r,u,d',
            'articles' => 'c,r,u,d',
            'workouts' => 'c,r,u,d',
            'plans' => 'c,r,u,d',
            'clients' => 'c,r,u,d',
        ],

        'admin' => [],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
