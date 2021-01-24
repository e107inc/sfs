# Stop Forum Spam #

## Features
Prevents spambots from signing up on your e107 website by checking their IP and/or email address against the database on stopforumspam.com

### Features planned for future releases: 
* See [Issue tracker](https://github.com/e107inc/sfs/issues?q=is%3Aopen+is%3Aissue+label%3A%22status%3A+planned%22+label%3A%22type%3A+enhancement%22) 

## Installation
* You can install this plugin through the "Admin Area > Plugin Manager > Find Plugins" section. 
* You can also download this plugin manually by checking out the [releases page](https://github.com/e107inc/sfs/releases). 

### Note for e107 v1 users
* e107 v1.0.4 (or lower) is no longer supported. It is strongly recommended to update to e107 v2. 
& In case you wish to use this plugin on your e107 v1 installation, please use [version 1.0.0](https://github.com/e107inc/sfs/releases/tag/v1.0.0) of this plugin. Any newer version of this plugin will only work on e107 v2. 

## Configuration
In the admin area there are two preferences that can be set for this plugin:
1. *StopForumSpam Active*: determines whether new signups are checked against the stopforumspam.com database (default is 'on')
2. *SFS Debug Mode*: when enabled, all user signups are logged in the logfile. By default, only the registations which are found in the stopforumspam.com database are logged. (default is 'off')

*The log file is located in your logs folder (by default 'e107_system/(hash)/logs')*

## How to get help? ##
* First, **search the documentation** [here](#) - *documentation will be added asap*
* Then, if you cannot find the answer to your question, please submit a new issue in the issue tracker [here](https://github.com/e107inc/sfs/issues)

## Bugs &  feature requests ##
* Bug reports and feature requests are very welcome! 
* Use the [issue tracker](https://github.com/e107inc/sfs/issues)

## Translation ##
* In case you want to translate this plugin to your language, please [fork this Github repository](https://help.github.com/articles/fork-a-repo) and submit a [pull-request](https://help.github.com/articles/using-pull-requests).

## Changelog ##
See the **releases** section [here](https://github.com/e107inc/sfs/releases)