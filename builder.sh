#!/bin/bash
#tar -cvzf --exclude-vcs-ignores 'vendor.tar.gz' 'vendor'
tar -cvzf 'application.tar.gz' --exclude-vcs-ignores 'app' 'bootstrap' 'public' 'artisan' 'composer.json' 'composer.lock' 'phpunit.xml' 'readme.md' 'server.php'