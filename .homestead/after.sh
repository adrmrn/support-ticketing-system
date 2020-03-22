#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.

# If you're not quite ready for Node 12.x
# Uncomment these lines to roll back to
# v11.x or v10.x

# Remove Node.js v12.x:
#sudo apt-get -y purge nodejs
#sudo rm -rf /usr/lib/node_modules/npm/lib
#sudo rm -rf //etc/apt/sources.list.d/nodesource.list

# Install Node.js v11.x
#curl -sL https://deb.nodesource.com/setup_11.x | sudo -E bash -
#sudo apt-get install -y nodejs

# Install Node.js v10.x
#curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
#sudo apt-get install -y nodejs

# MongoDB
sudo apt-get install php7.4-mongodb

# Migrations
php /home/vagrant/support-ticketing-system/auth/artisan migrate
php /home/vagrant/support-ticketing-system/user/artisan migrate
php /home/vagrant/support-ticketing-system/ticket/bin/console doctrine:migrations:migrate

# Composer
composer install -d /home/vagrant/support-ticketing-system/auth
composer install -d /home/vagrant/support-ticketing-system/user
composer install -d /home/vagrant/support-ticketing-system/ticket

# Add the laravel service to supervisord
if sudo [ ! -f /etc/supervisor/conf.d/auth-worker.conf ]; then
  auth_worker="[program:domain-events-consumer]
process_name=%(program_name)s_%(process_num)02d
command=php /home/vagrant/support-ticketing-system/auth/artisan messaging:consume domain.events
autostart=true
autorestart=true
user=vagrant
numprocs=1
redirect_stderr=true
stdout_logfile=/home/vagrant/support-ticketing-system/auth/storage/logs/supervisor/domain-events-consumer.log"

  sudo sh -c "echo '$auth_worker' > '/etc/supervisor/conf.d/auth-worker.conf'"
  sudo supervisorctl reread
  sudo supervisorctl update
fi

# Cron
sudo touch /etc/cron.d/support-ticketing-system
sudo sh -c 'echo "*/1 * * * * php /home/vagrant/support-ticketing-system/user/artisan messaging:publish domain.events > /home/vagrant/support-ticketing-system/user/storage/logs/cron/domain-events-publisher.log 2>&1" > /etc/cron.d/support-ticketing-system'
crontab /etc/cron.d/support-ticketing-system