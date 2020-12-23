# laravel basics

## comprendre les dossiers

- **public** : le dossier principal du projet

- **routes/web.php** : c'est ici qu'on définit les routes du projet(vers n controller ou une vue)

- **resources/views** : c'est ici qu'on va mettre les vues de notre projet

- **database/migrations** : c'est ici qu'on va créer les migrations(les tables de notre BDD)

- **database/factories** : c'est ici qu'on va définir les fake données(lors de nos tests)

- **database/seeders/DatabaseSeeder.php** : permet de créer les fake données

- **app/Http/Controllers** : c'est ici qu'on va définir les controllers de notre projet(manuellement ou à partir de la console php artisan)

- **app/Http/Controllers** : c'est ici qu'on va créer les models

Lors de l'utilisation de la console(artisan), on peut voir les commande disponible avec `--help`. 

Exemple : `php artisan make:controller --help`

## Les routs basiques

