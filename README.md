# Plugin Boilerplate

A plugin boilerplate using namespaces and autoloading.

## About This Plugin

This is a plugin boilerplate that I like to use for building plugins.  Based off of [namespaces-and-autoloading-in-wordpress](https://github.com/tommcfarlin/namespaces-and-autoloading-in-wordpress).

In this example, once the plugin is installed and activated, it will add a custom post type `post-type`, a taxonomy `post-type-taxonomy`, some custom fields to the `post-type` and a custom API endpoint searchable by the `post-type-taxonomy` term.  

There's no other functionality than this as its meant purely for the purposes of practicing the use of namespaces and autoloading. 

## How It Works

1. Adds a custom post type `post-type` with a taxonomy `post-type-taxonomy`.
2. Adds some custom fields to the custom post type `post-type`.
3. Create a custom API endpoint based on the taxonomy term `wp-json/plugin-name/v2/post-type/post-type-taxonomy/$term`.

## Installation

### Using The WordPress Dashboard

1. Navigate to the 'Add New' Plugin Dashboard
2. Select `plugin-name.zip` from your computer
3. Upload
4. Activate the plugin on the WordPress Plugin Dashboard

### Using FTP

1. Extract `plugin-name.zip` to your computer
2. Upload the `plugin-name.zip` directory to your `wp-content/plugins` directory
3. Activate the plugin on the WordPress Plugins Dashboard

## Changes

For information about changes related to the project, be sure to review the [CHANGELOG](https://github.com/tommcfarlin/namespaces-and-autoloading-in-wordpress/blob/master/CHANGELOG.md).