<?php

return [
    'dashboard_layout' => 'dashboard::layout',
    'schema_driver' => 'config',
    'schema_config_key' => 'entities',
    'route_prefix' => 'dashboard/content',
    'route_name' => 'dashboard.content.',
    'dashboard_middleware' => ['web', 'littlegatekeeper'],
    'storage_disk' => 'public',
    'storage_directory' => 'content'
];
