#! /bin/bash

git clone git@bitbucket.org:provenlogic/yelp.git yelp-vps
cd yelp-vps
composer install
cp ../database.php app/config/database.php
cp ../app.php app/config/app.php
cp ../paypal.php app/config/paypal.php
cp ../mail.php app/config/mail.php
cp ../services.php app/config/services.php
rm -rf .git
