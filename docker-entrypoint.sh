#!/bin/bash

# Write deploy key from environment variable
if [ ! -z "$GIT_DEPLOY_KEY" ]; then
    echo "$GIT_DEPLOY_KEY" > /var/www/.ssh/id_ed25519
    chmod 600 /var/www/.ssh/id_ed25519
    chown www-data:www-data /var/www/.ssh/id_ed25519
fi

# Start Apache
apache2-foreground