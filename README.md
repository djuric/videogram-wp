# Videogram

WordPress plugin for managing videos. Main purpose of the plugin is to allow easy way to add, remove and customize the videos in WordPress admin panel and expose them via APIs like GraphQL or REST.

## Development of editor blocks

Code for the editor blocks is located in `block-editor/src` and compiled to `block-editor/dist`. It's enough to run `npm start` from plugin root directory to start development and watching files. Script used for blocks development is offical [wp-scripts](https://www.npmjs.com/package/@wordpress/scripts) setup with custom webpack config file.
