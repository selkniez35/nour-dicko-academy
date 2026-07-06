cache_clear :
	- php bin/console cache:clear
serve_start :
	- symfony serve
run_build :
	- npm run build
run_watch :
	- npm run watch
migrations :
	- php bin/console make:migration
	- php bin/console doctrine:migrations:migrate
db_update :
	- php bin/console doctrine:schema:update --force

