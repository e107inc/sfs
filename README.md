# Stop Forum Spam #

**THIS PLUGIN IS CURRENTLY BEING REWRITTEN FOR E107 V2. PLEASE AWAIT FURTHER UPDATES BEFORE USING THIS PLUGIN FOR NOW.**

## Features
Prevents spambots from signing up on your e107 website by checking their IP and/or email address against the database on stopforumspam.com

## Installation
You will need to create a folder called 'sfs' in your e107_plugins folder, and then place the contents of the github zip inside. 
Then go to the plugins-manager in admin, and install "Stop Forum Spam". 

## Configuration
In the admin area there are two preferences that can be set for this plugin. The first checkbox enables/disables the plugin. 
When the first checkbox is unchecked, the plugin will be disabled and the signup requests will not be checked. 

By default, all signups that have been refused (ie. all spambots that have tried to sign up) will be logged in a file called sfs.log. This file is located in the plugin folder (e107_plugins/sfs)
The second checkbox in the admin area allows for logging ALL signups (this includes all legitimate signups as well). 

## Issues and Feature requests
In case of any issues, questions or feature requests. Please use the issue tracker here: https://github.com/e107inc/sfs/issues
