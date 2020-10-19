<?php

return [
    'dashboard_layout' => 'dashboard::layout',
    'schema_driver' => 'config',
    'schema_config_key' => 'entities',
    'route_prefix' => 'dashboard/content',
    'route_name' => 'dashboard.content.',

    'dashboard_middleware' => 'littlegatekeeper'
];
