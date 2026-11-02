<?php

return [
    [
        'name' => 'Facebook Feed',
        'flag' => 'facebook-feed.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'facebook-feed.create',
        'parent_flag' => 'facebook-feed.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'facebook-feed.edit',
        'parent_flag' => 'facebook-feed.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'facebook-feed.destroy',
        'parent_flag' => 'facebook-feed.index',
    ],
    [
        'name' => 'Settings',
        'flag' => 'facebook-feed.settings',
        'parent_flag' => 'facebook-feed.index',
    ],
];
