# Lingo master
php init


composer install

php yii migrate --migrationPath=@yii/rbac/migrations/

yii migrate
