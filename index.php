<?php

use Pagekit\Application as App;

/*
 * This array is the module definition.
 * It's used by Pagekit to load your extension and register all things
 * that your extension provides (routes, menu items, php classes etc)
 */
return [

    /*
     * Unique extension name
     */
    'name' => 'spotify-track-suggester',

    /*
     * Define the type of this module.
     * Has to be 'extension' here. Can be 'theme' for a theme.
     */
    'type' => 'extension',

    /*
     * Main entry point. Called when your extension is both installed and activated.
     * Either assign an closure or a string that points to a PHP class.
     * Example: 'main' => 'Crwgregory\\SpotifyTrackSuggester\\HelloWorldExtension'
     */
    'main' => function (App $app) {

    },

    /*
     * Register all namespaces to be loaded.
     * Map from namespace to folder where the classes are located.
     * Remember to escape backslashes with a second backslash.
     */
    'autoload' => [
        'Crwgregory\\SpotifyTrackSuggester\\' => 'src'
    ],

    /*
     * Define nodes. A node is similar to a route with the difference
     * that it can be placed anywhere in the menu structure. The
     * resulting route is therefore determined on runtime.
     */
    'nodes' => [

        'spotify-track-suggester' => [

            // The name of the node route
            'name' => '@spotify-track-suggester',

            // Label to display in the backend
            'label' => 'Spotify Track Suggester',

            // The controller for this node. Each controller action will be mounted
            'controller' => 'Crwgregory\\SpotifyTrackSuggester\\Controller\\SpotifyTrackSuggesterController',

            // Optional: Prevent node from being removed. Will end up in "not linked" menu instead
            'protected' => true,

            'frontpage' => true
        ]

    ],

    /*
     * Define resources.
     * Register prefixes to be used as shorter versions when working with paths.
     */
    'resources' => [
        'spotify-track-suggester:' => ''
    ],

    /*
     * Define routes.
     */
    'routes' => [
        '@spotify-track-suggester' => [
            'path' => '/spotify-track-suggester',
            'controller' => 'Crwgregory\\SpotifyTrackSuggester\\Controller\\SpotifyTrackSuggesterController'
        ],
        '@api/suggest' => [
            'path' => '/api/suggest',
            'controller' => 'Crwgregory\\SpotifyTrackSuggester\\Controller\\ApiController'
        ]
    ],

    /*
     * Define permissions.
     * Will be listed in backend and can then be assigned to certain roles.
     */
    'permissions' => [
        // Unique name.
        // Convention: extension name and speaking name of this permission (spaces allowed)
        'spotify-track-suggester: manage settings' => [
            'title' => 'Manage settings'
        ],
    ],

    /*
     * Define menu items for the backend.
     */
    'menu' => [

        // name, can be used for menu hierarchy
        'spotify-track-suggester' => [

            // Label to display
            'label'  => 'Spotify Track Suggester',

            // Icon to display
            'icon'   => 'app/system/assets/images/placeholder-icon.svg',

            // URL this menu item links to
            'url'    => '@spotify-track-suggester/admin',

            // Set the order this item is placed in the menu
            'priority' => 110

            // Optional: Expression to check if menu item is active on current url
            // 'active' => '@spotify-track-suggester*'

            // Optional: Limit access to roles which have specific permission assigned
            // 'access' => 'spotify-track-suggester: manage index'
        ],

        'spotify-track-suggester: panel' => [

            // Parent menu item, makes this appear on 2nd level
            'parent' => 'spotify-track-suggester',

            // See above
            'label' => 'Spotify Track Suggester',
            'url' => '@spotify-track-suggester/admin'
            // 'access' => ': manage hellos'
        ],

        'spotify-track-suggester: settings' => [
            'parent' => 'spotify-track-suggester',
            'label' => 'Spotify Track Suggester Settings',
            'url' => '@spotify-track-suggester/settings',
            'access' => 'system: manage settings'
        ]
    ],

    /*
     * Link to a settings screen from the extensions listing.
     */
    'settings' => '@spotify-track-suggester/admin/settings',

    /*
     * Default module configuration.
     * Can be overwritten by changed config during runtime.
     */
    'config' => [
        'default_settings' => [
            'groups' => 3,
            'attribute_buffer' => 0.1
        ]
    ],

    /*
     * Listen to events.
     * https://pagekit.com/docs/developer/events
     */
    'events' => [
        'boot' => function($event, $app) {
            // The boot phase of the Pagekit application has started.
        }
    ]
];
