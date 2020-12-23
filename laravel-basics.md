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

C'est **routes/web.php** qu'on va créer les routes de notre projet.

il existe différentes typ de route(get, post, patch, delete).
- la route aura deux paramètres :
    - le chemin de l'url
    - la fonction de retour(un controller, une vue, ou un string et/ou une variable)
        ```
      Route ::get('/',function(){
          return 'Home';
      });
      ```
      > ici la route retourne juste le string dans la page d'accueil(/)
- lorsqu'on a bcp de route, on peut utiliser la console pour voir quelle type de route on a : `php artisan route:list`
    - on peut par exemple donner un nom à une route pour pouvoir utiliser ce nom dans le controller par exemple
        ```
        Route ::get('/about', function() {
            return 'About Page';
        }) -> name('about');
      ```

### Routes avec paramètres

on peut ajouter un paramètre à une route pour aller dans un segment de l'url(exemple : hello.com/users/1)

