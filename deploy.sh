rsync -avhP ./ user@server:/var/www/projet

ssh user@server << EOF
    cd dossier
    git pull
    php composer.phar install
    php bin/console cache:clear
    php bin/console doctrine:migrations:migrate
EOF
