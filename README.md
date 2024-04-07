<p align="center"><img src="src/icon.svg" width="100" height="100" alt="Auto Translator icon"></p>
<h1 align="center">Auto Translator for Craft CMS</h1>
<h3 align="center">By Little Miss Robot</h3>

## Roadmap v1.0.0

| Milestone            | Description                                                                                                                                                                                       |
|----------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Plugin branding      | Provide the plugin with a beautiful icon and branding: add a powerful descriptive baseline and potentially a new catchy name.                                                                     |
| CP Settings          | Build an easy-to-use interface for every setting available in the plugin.                                                                                                                         |
| Logic overhaul       | Confirm the logic of the automatic translations is as desired: when to translate? Check for changes in content? When to update? Add Strategy interface? Does this add new settings to the plugin? |
| SOLID overhaul       | Some of the logic can be divided into multiple building blocks, to allow for easy extensibility and better maintenance.                                                                           |
| Queue worker / Jobs  | Add the option to do translations through the queue worker.                                                                                                                                       |
| Google Cloud service | Confirm that the Google Cloud Translations are working as expected.                                                                                                                               |
| ChatGPT service      | Implement a ChatGPT service for translations.                                                                                                                                                     |
| Advanced field types | Provide a better interface for field types. Expectation is that the current one doesn't suffice. Confirm this with custom fields!                                                                 |

## Requirements

This plugin requires Craft CMS 4.8.0 or later, and PHP 8.0.2 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “craft-auto-translator”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require little-miss-robot/craft-auto-translator

# tell Craft to install the plugin
./craft plugin/install auto-translator
```
