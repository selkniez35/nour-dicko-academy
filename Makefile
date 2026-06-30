c_c :
	- php bin/console cache:clear
run_server :
	- symfony serve
run_build :
	- npm run build
run_watch :
	- npm run watch
migrations :
	- php bin/console make:migration
	- php bin/console doctrine:migrations:migrate
u:d
	- php bin/console doctrine:database:drop --force
	- php bin/console doctrine:database:create
	- php bin/console doctrine:migrations:migrate
	- php bin/console doctrine:fixtures:load
