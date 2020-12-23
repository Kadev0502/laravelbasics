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

```
Route ::get('/users/{username}', function($username) {

    return $username;
});
```

### Les groupes de routes

au lieu de répéter plusieurs routes qui ont un même préfixe, on peut les grouper :
```
Route ::group(['prefix'=>'/user'], function() {

    Route ::get('/login', function() {
        return 'Welcome';
    });

    Route ::get('/password', function() {
        return 'Password';
    });

    Route ::get('/logout', function() {
        return 'Bye Bye';
    });
});
```
> on peut y ajouter un namespace, un middleware

## Rendu d'une vue
Comme dit auparavant, on peut retourner une vue dans une route.

Dans ce cas il faut créer cette vue dans le dossier des vues, puis ajouter cette vue comme return de la route:
```
Route ::get('/', function() {
    return view('home');
});
```
> il faut juste mettre le nom de la vue(sans l'extension blade.php)

- on peut mettre les vues dans un dossier(**resources/views/posts**) pour les séparer en groupe, dans ce cas, le return doit index la vue voulue.
    ```
    Route ::get('/posts', function() {
        return view('posts.index');
    });
  ```
- pour afficher un élément d'un groupe d'éléments dans une vue :
    ```
    Route ::get('/posts/{id}', function($id) {
        return view('posts.show');
    });
  ```
- la route peut retourner un second argument qui sera un array contenant des valeurs qu'on veut passer dans la vue
    ```
  Route ::get('/posts/{id}', function($id) {
      return view('posts.show',[
           'userId' => $id
      ]);
  });
  ```
  > ici on passe comme valeur dans la vue la valeur de la variable id(celui saisi en troisième segment de l'url)

    - dans la vue, on utilisera la syntaxe de blade pour afficher la variable : 
        ```
         <body>
                {{ $userId }}
            </body>
      ```


