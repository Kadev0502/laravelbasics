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

## Les routes basiques

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

### les bases de Blade

pour comprendre comment fonctionne blade :
- on va créer une route contenant un array et qui retourne une vue et la variable 
    ```
    Route ::get('/posts',function () {
        $posts = [
            ['id'=>1, 'title'=>'Post One'],
            ['id'=>2, 'title'=>'Post Two'],
            ['id'=>3, 'title'=>'Post Three'],
            ['id'=>4, 'title'=>'Post Four'],
        ];
    
         return view('posts.index',[
                'posts' => $posts
            ]);
    });
    
  ```
- en utilisant la syntaxe de Blade :
    -  on va vérifier que des posts existe 
        ```
         <body>
               <h1> Liste des posts</h1>
        
               @if (count($posts))
                   Il existe des posts
                 @else
                    il n'y a pas de posts
               @endif
            </body>
       ```
    -  on va afficher tous les posts s'il y en y a:
        ```
         <body>
               <h1> Liste des posts</h1>
        
               @if (count($posts))
                @foreach ($posts as $post)
                    <div>
                        {{ $post['id'] }}  : {{ $post['title'] }}
                    </div>
                @endforeach
                @else
                   il n'y a pas de posts
               @endif
            </body>
       ```
       > on peut récupérer l'index de chaque valeur dans un tableau : ` @foreach ($posts as $index=> $post)`
    -  on va vérifier que des posts existe 
    -  on va vérifier que des posts existe 

### Gestion des layouts avec Blade

Pour comprendre comment fonctionne les templates avec blade :
- on va créer une route permettant d'afficher chaque post dans sa propre vue :
```
Route ::get('/posts/{id}', function($id) {
    
    return view('posts.show', [
        'id' => $id
    ]);
});
```
- on va ensuite créer cette vue :
    ```
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
        </head>
        <body>
            {{ $id }}
        </body>
    </html>

  ```
- avec blade, il est possible de définir une seule fois une page par éfaut pour notre projet et le réutiliser pour les autres vues sans avoir à écrire les meme choses:
    - on va créer un dossier(**resources/views/layouts**) contenant la vue par défaut
    - à l'intérieur, on va définir une vue par défaut(on peut en créer plusieurs, une pour la vue du site du projet, une pour le tableau de bord de l'admin, etc...) =>**resources/views/layouts/app.blade.php**
        ```
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Laravel Basics</title>
            </head>
            <body>
            
            </body>
        </html>
      ```
    - cette vue aura à l'intérieur une syntaxe blade permettant de définir un bloc qui contiendra des éléments selon la vue spécifier dans les routes :
        ```
         <body>
                @yield('content')
            </body>
      ```
      > ici on veut que les autres vues utilise ce template mais leur contenu sera dans le bloc body
    - dans les autres vues, on va extendre la vue par défaut puis mettre leur contenu dans une section blade qui aura le meme nom que le paramètre du _@yield_ du template par défaut
        ```
        @extends('layouts.app')
        
        @section('content')
            @if (count($posts))
                @foreach ($posts as $index=> $post)
                    <div>
                        {{ $post['id'] }} : {{ $post['title'] }} ({{ $index }})
                    </div>
                @endforeach
            @else
                il n'y a pas de posts
            @endif
        @endsection
      ```
   
    
- on peut créer un dossier dans le dossier **layouts** pour les partials du template
    - exemple on crée une vue(**resources/views/layouts/partials/_nav.blade.php**) pour la nav 
        ```
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/posts">Posts</a></li>
        </ul>
      ```
    - puis on l'inclut dans la vue par défaut
        ```
         <body>
                <div>
                @include('layouts.partials._nav')
                    
                @yield('content')
                </div>
            </body>
      ```
    > on peut faire des partials pour le head, le footer ,etc...

## Utilisation des controllers

Pour structurer notre projet et respecter le MVC, on va plutôt return dans une route un controller et c'est le controller qui sera chargé d'afficher la vue voulue.

Le controller va se charger de gérer les requêtes vers la BDD(le lien entre la vue et la BDD)

Pour créer un controller, on peut utiliser la console : `php artisan make:controller NomController`
> cela va créer le fichier **app/Http/Controllers/PostController.php**

- on va donc créer une route qui aura en deuxième argument un array composé du controller créé et de la method qu'on veut utiliser 
    ```
    Route ::get('/posts', [PostController::class,'index']);
  ```
  > il faut importer la class du controller : `use App\Http\Controllers\PostController;`

- dans le controller, on va donc définir cette method(_index_)
    ```
    public function index()
        {
            $posts = [
                ['id' => 1, 'title' => 'Post One'],
                ['id' => 2, 'title' => 'Post Two'],
                ['id' => 3, 'title' => 'Post Three'],
                ['id' => 4, 'title' => 'Post Four'],
            ];
    
            return view('posts.index', [
                'posts' => $posts
            ]);
        }
  ```
- on peut avoir un controller qui n'a pas de nom(pas de method) :
    - dans ce cas, le controller appelé ne sera pas dans un array : `Route ::get('/',HomeController::class);`
    - et la method sera une method spéciale (**__invoke**) :
        ```
        public function __invoke()
            {
                return view('home');
            }
      ```

## Gestion des formulaires

- on va créer une vue qui va afficher un formulaire d'ajout de post : `Route ::get('/posts/create',[PostController::class,'create'] );`
> mettre la route d'affichage du formulaire avant la route index pour qu'il soit prioritaire

- on va ensuite créer la method appelée dans la route dans le controller (elle va return juste une vue) :
    ```
    public function create()
        {
            return view('posts.create');
        }
  ```
- on va ensuite créer cette vue :
    ```
    @extends('layouts.app')
    
    @section('content')
        <form action="" method="post">
            
            <input type="text" name="title" id="title">
            
            <button type="submit">Post</button>
        </form>
    @endsection

  ```

- on va créer une route qui va soumettre ce formulaire : `Route ::post('/posts',[PostController::class,'store'] );`
> cette route sera de type post car elle va envoyer une requête vers la BDD
    
- on va referencer l'action du formulaire(dans l'attribut action de la balise form) : ` <form action="/posts" method="post">`

- on va protéger le formulaire grâce à une fonction spéciale de laravel(**@csrf**) qu'on mettra juste après la balise d'ouverture form :
    ```
      <form action="/posts" method="post">
            @csrf
            <input type="text" name="title" id="title">
    
            <button type="submit">Post</button>
        </form>
  ```
> cette fonction crée un token dans un form hidden(voir code source)

- on va maintenant créer la method de la route(store) :
    ```
     public function store(Request $request)
        {
            dd($request ->get('title'));
        }
  ```
  
Pour faire plus propre, on va nommer nos routes et pouvoir utiliser ces noms pour référencer nos routes :

Exemple : `Route ::post('/posts', [PostController::class, 'store'])->name('posts.store');`

On aura alors dans l'action du formulaire : `<form action="{{ route('posts.store') }}" method="post">`
> on utilise la fonction route de blade .

## Validation des formulaires

Pour éviter d'envoyer un formulaire vide ou des données non-valides, on va gérer la validité des informations saisies dans le formulaire :

On va gérer la validité des inputs du formulaire dans la method _store_ du controller :

Exemple pour le formulaire post, on veut un titre,avec max 20 caractères et min 4 caractères, sinon il redirige vers le formulaire pour signifier à l'utilisateur qu'il y a une erreur dans son formulaire :
```
 public function store(Request $request)
    {
        $this -> validate($request, [
            'title' => 'required|max:20|min:4'
        ]);
        
        dd($request -> get('title'));
    }
```

On peut afficher un message d'erreur en dessous de l'input pour indiquer le type d'erreur à l'utilisateur :
```
  <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <div style="margin-bottom: 10px">
            <label for="title">Title :</label>
            <input type="text" name="title" id="title"><br>
            @error('title')
           <p style="color: red">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit">Post</button>
    </form>
```

On peut changer le message par défaut que fourni laravel pour les erreurs de validité en ajoutant un second paramètre dans le request de validité(dans la method store) :
```
     $this -> validate($request, [
                'title' => 'required|max:20|min:4'
            ],[
               'title.required'=>'Veuillez ajouter un titre',
               'title.max'=>'Le titre doit pas avoir plus de 20 caractères',
               'title.min'=>'Le titre doit avoir au moins 4 caractères',
            ]);
```

On va éviter d'effacer toutes les saisies du formulaire juste parce qu'une donnée est invalide,
on va utiliser l'attribut **value** pour les différents inputs et il aura pour valeur l'input avec la fonction _old_ de blade :
```
     <form action="{{ route('posts.store') }}" method="post">
            @csrf
            <div style="margin-bottom: 10px">
                <label for="title">Title :</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"><br>
                @error('title')
               <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
    
            <div style="margin-bottom: 10px">
                <label for="body">Body :</label>
                <textarea  name="body" id="body">{{ old('body') }}</textarea><br>
                @error('body')
                <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
    
            <button type="submit">Post</button>
        </form>
```
> pour le textarea, il sera entre les deux balise et non dans un attribut _value_

on peut ajouter un style particulier a un input en cas d'erreur :
- on définit le style de la classe :
    ```
    <style>
        .red{
            border: 2px solid red;
        }
    </style>
  ```
- on assigne la classe dans la fonction _@error_ de blade :`<input class="@error('title') red @enderror" type="text" name="title" id="title" value="{{ old('title') }}"><br>`

### Redirection(après une action)

Après une requête( par exemple lors de l'envoi des données d'un formulaire dans la BDD), on peut définir la vue vers laquelle on veut diriger l'utilisateur .

Il se fera dans la method dans laquelle on exécute la requête (exemple ici la method store) : `return redirect('/posts');`
> on peut aussi défini un nom à la route pour pouvoir référencer celle-ci à partir du nom :
   ```
dans la route :
     Route ::get('/posts', [PostController::class, 'index'])->name('posts.index') :
 
dans la method :    
    return redirect() -> route('posts.index');
```

- Si on a le formulaire et la liste des éléments soumis dans la même page, on utilisera alors la fonction **back()** qui redirige vers la même page : `return back();`

- On peut aussi diriger l'utilisateur vers l'élément qu'il vient de créer(pas la liste)
    ```
     public function store(Request $request)
        {
            $this -> validate($request, [
                'title' => 'required|max:20|min:4',
                'body' => 'required|max:255|min:6',
            ], [
                'title.required' => 'Veuillez ajouter un titre',
                'title.max' => 'Le titre doit pas avoir plus de 20 caractères',
                'title.min' => 'Le titre doit avoir au moins 4 caractères',
            ]);
    
            $id = 1;
            return redirect('/posts/' . $id);
        }
  ```
En nommant la route on peut le faire encore plus propre avec le nom de la route et en mettant l'id en tant que deuxième argument : `return redirect()->route('posts.show',$id);`

### Messages flash

Lors de la redirection de l'utilisateur vers une vue après une requête(création de post, modification, suppression), on doit pouvoir afficher un message pour confirmer l'action de la requête

- on peut le faire en utiliser la fonction **session()**
    - dans la method :
        ```
         public function store(Request $request)
            {
                $this -> validate($request, [
                    'title' => 'required|max:20|min:4',
                    'body' => 'required|max:255|min:6',
                ], [
                    'title.required' => 'Veuillez ajouter un titre',
                    'title.max' => 'Le titre doit pas avoir plus de 20 caractères',
                    'title.min' => 'Le titre doit avoir au moins 4 caractères',
                ]);
        
                session()->flash('status','Votre post a été créé!');
        
                $id = 1;
                return redirect()->route('posts.show',$id);
            }
      ```
    
    - dans la vue :
        ```
         @if (session()->has('status'))
            <div>
                <p style="color: darkgreen">{{ session()->get('status') }}</p>
            </div>
         @endif
      ```
- on peut le faire directement dans le return lors du redirect avec la fonction **with()** :
    - dans la method :
        ```
         public function store(Request $request)
            {
                $this -> validate($request, [
                    'title' => 'required|max:20|min:4',
                    'body' => 'required|max:255|min:6',
                ], [
                    'title.required' => 'Veuillez ajouter un titre',
                    'title.max' => 'Le titre doit pas avoir plus de 20 caractères',
                    'title.min' => 'Le titre doit avoir au moins 4 caractères',
                ]);
                
                $id = 1;
                return redirect()
                    ->route('posts.show',$id)
                    ->with('status','Votre post a été créé!');
            }
      ```
    - dans la vue :
        ```
          @if (session('status'))
                <div>
                    <p style="color: darkgreen">{{ session('status') }}</p>
                </div>
            @endif
      ```

- on peut aussi gérer le flash message avec la method magic **withStatus** (ça peut être le mot qu'on veut=> withSuccess,withError, etc...:
    ```
     return redirect()
        ->route('posts.show',$id)
        ->withStatus('Votre post a été créé!');
        }
  ```
   
- on peut défini une section (dans la vue par défaut) pour afficher tous les flashs messages :
    ```
  dans la vue par défaut(**resources/views/layouts/app.blade.php**) :
  
    @include('layouts.partials._head')
            <div>
            @include('layouts.partials._nav')
    
                @if (session('status'))
                    <div>
                        <p style="color: darkgreen">{{ session('status') }}</p>
                    </div>
                @endif
    
                @yield('content')
            </div>
    @include('layouts.partials._footer')
  
  dans la method store :
      return redirect()
         ->route('posts.index')
         ->withStatus('Votre post a été créé!');
  ```

## les migrations

Avec Laravel, la gestion de la BDD sze fait à partir des fichiers migrations (**database/migrations**).

Avant toute chose:
- on va créer une BDD dans notre app Mysql ou via Mysql(à partir du terminal) 
- puis setter la BDD dans le fichier **.env**
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravelbasics
    DB_USERNAME=root
    DB_PASSWORD=root1234
  ```

Une fois la BDD créée, on va travailler avec la migration des utilisateurs (présent par défaut lors de l'installation du projet laravel).

Pour envoyer la migration vers la BDD, on fera la commande : `php artisan migrate`
> cela va créer deux tables dans la BDD(migrations et users)

-  en cas d'erreur si on veut reveir en arrière(supprimer la migration effectuée), on fera la commande : `php artisan migrate:rollback`
> cela va garder la table migrations dans la BDD mais pas la table users(celui-là même qu'on voulait retirer de la BDD)

- Pour créer une migration, on fera la commande : `php artisan make:migration create_nom-de-la-migration(s)_table`
    ```
  make:migration create_posts_table
  ```
> cela crée une table avec la colonne id et des timestamps déjà présentes.

- pour modifier les colonnes d'une table, on utilisera la commande : 
    - pour ajouter une colonne : `php artisan make:migration add_nom-de-la-colonne_to_users_table` 
        ```
      php artisan make:migration add_username_to_users_table
      ```
    - on définit à l'intérieur de la migration le nom de la colonne et ses propriétés (pour la création => method _up_) et 
    la suppression de cette colonne (pour la suppression => method _down_)
        ```
         public function up()
            {
                Schema ::table('users', function(Blueprint $table) {
                    $table -> string('username') -> unique();
                });
            }
        
            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema ::table('users', function(Blueprint $table) {
                    $table -> dropColumn('username');
                });
            }
      ```
      - envoyer ensuite la table et la colonne créée dans la base de donnée(`php artisan migrate`)

## Les models

Les models se trouve dans le dossier **app/Models**.

Il existe une commande avec laravel pour créer un model : `php artisan make:model NomDuModel`

Généralement, lors de la création d'un model, on crée en même temps la migration de celui-ci (le faire avec la commande de création du model suivi de **-m**)

- pour créer un model et une migration de gestion des posts, on fera la commande : `php artisan make:model Post -m`

- on va ensuite ajouter les colonnes dont on a besoin pour la création d'un post(title,body) :
    ```
    public function up()
        {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('body');
                $table->timestamps();
            });
        }
  ```
- envoyer la migration vers la BDD(`php artisan migrate`)
    - on va remplir la table _posts_ manuellement dans la BDD

## Travailler avec Eloquent de Laravel

Eloquent permet de gérer les requêtes vers la BDD ( c'est via le model que le controller pourra envoyer dynamiquement les données vers la vue)

### Les bases

- on utilisera la fonction **get()** pour récupérer les données de toutes les rangées d'une table :
    ```
    Route ::get('/example', function() {
        $posts = Post ::get();
        dd($posts);
    });
  ```
  > on utilise la classe du model(bien appeler la classe `use App\Models\Post;`) et la fonction via une variable
- la fonction **first()** permet de récupérer les données de la première rangée d'une table : `$posts = Post ::first();`
- la fonction **find(id)** permet de récupérer les données d'une rangée via son id : 
    ```
    Route ::get('/example/{id}', function($id) {
        $post = Post ::find($id);
        dd($post);
    });
  ```
- la fonction **where()** permet de spécifier les données d'une rangée, elle est généralement suivie d'une autre fonction :
    ```
  Recherche via le titre:
  
    Route ::get('/example/{id}', function($id) {
        $post = Post ::where('title' ,'=', 'Post One')->first();
        dd($post);
    });
  
  Recherche via le id :
    Route ::get('/example/{id}', function($id) {
        $post = Post ::where('id' ,'=', $id)->first();
        dd($post);
    });
  
  Recherche plusieurs éléments via le id :
    Route ::get('/example/{id}', function($id) {
            $post = Post ::where('id' ,'>', 1)->get();
            dd($post);
        });
  ```
> where étant une condition, une peut être suivi d'une autre condition(exemple une condition selon le title ...) 

- la fonction **create()** permet de créer une rangée dans une table(insérer une valeur)
    ```
    Route ::get('/example', function() {
        $post = Post ::create([
            'title'=>'New Post',
            'body'=>'New Post body',
        ]);
        dd($post);
    });
  ```
    > elle doit avoir comme arguments les valeurs des colonnes de la rangée

    - par sécurité, on doit ajouter les colonnes de la tables comme valeurs de la propriété _$fillable_ dans le model :`protected $fillable = ['title','body',];`
    
    Une fois fait, la rangée sera créée dans la table.

- pour modifier une rangée, on va d'abord indexer celle-ci puis la modifier :
    ```
    Route ::get('/example/{id}', function($id) {
    
        $post = Post ::find($id );
        $post -> update([
            'body'=>'New Post body updated again',
        ]);
    
        dd($post);
    });
  ```

- pour supprimer une rangée, on va d'abord indexer celle-ci puis la supprimer :
    ```
   Route ::get('/example/{id}', function($id) {
   
       $post = Post ::find($id );
       $post -> delete();
   
       dd($post);
   });

  ```
    > on peut utiliser la fonction **where()** pour supprimer plusieurs rangées.

    ```
    Route ::get('/example/', function() {
    
        $posts = Post ::where('id' ,'>',1);
        //number of posts deleted
    
        $posts -> delete();
        
    });
  ```

### Les relations entre els tables avec Eloquent

Des tables peuvent avoir une relation entre elles.

- on va créer une migration pour ajouter une colonne _user_id_ à la table **posts** :`php artisan make:migration add_user_id_to_posts_table --table=posts`
> --table=posts : permet de referencer à Schema la table.
- on va ajouter la colonne au deux method dans la migration
    ```
     public function up()
        {
            Schema::table('posts', function (Blueprint $table) {
                $table -> bigInteger('user_id') -> unsigned() -> index();
            });
        }
  
     public function down()
        {
            Schema::table('posts', function (Blueprint $table) {
                $table -> dropColumn('user_id');
            });
        }
  ```
- on va créer une relation entre le model **User** et le model **Post**
    - dans le model User, on va créer la relation entre les utilisateurs et le model post :
        ```
        
        public function posts()
        {
            return $this -> hasMany(Post ::class);
        }
      ```
      > la relation sera de type hasMany car un utilisateur peut avoir plusieurs posts

         - on va ajouter manuellement un utilisateur et des posts dns la BDD.
         - pour accéder aux posts d'un utilisateur, on aura juste à utiliser le model User et à indexer la table _posts_ comme propriété :
            ```
                Route ::get('/example/', function() {
                
                $user = User::find(1);
                dd($user->posts);
                });
            ```
    
    - dans le model Post, on va créer la relation entre les posts et le model User :
        ```
        
        public function user()
           {
               return $this -> belongsTo(User::class);
           }
      ```
      > la relation sera de type belongsTo car un post appartiendra à seulement un utilisateur
      - pour accéder à l'utilisateur d'un post, on aura juste à utiliser le model Post et à indexer la table _users_ comme propriété :
        ```
           Route ::get('/example/', function() {
           
           $post = Post::find(5);
           dd($post->user);
           });
        ```     
- on peut créer un post tout en assignant l'utilisateur à qui celui-ci appartiendra :
    ```
    Route ::get('/example/', function() {
    
        $user = User ::find(3);
    
        $user -> posts() -> create([
            'title' => 'Abc',
            'body' => 'Abc efG hij',
        ]);
    });
  ```

## Liaison entre les route et les models

Pour gérer les requêtes vers la BDD, on va utiliser le model pour accéder aux valeurs pour rendre le projet dynamique .

Pour rendre la connection entre la route et le model encore plus logique et dynamique :
- on va passer dans la route le model en troisième segment de l'url : `Route ::get('/posts/{post}', [PostController::class, 'show']) -> name('posts.show');`
> cela permettra au model d'être accessible dans le controller

> on peut ajouter devant le model la colonne via laquelle on veut afficher la rangée. exemple : `Route ::get('/posts/{post:title}', [PostController::class, 'show']) -> name('posts.show');`
- le model sera ensuite l'argument de la method dans le controller
    ```
      public function show(Post $post)
        {
            return view('posts.show', [
                'post' => $post
            ]);
        }
  ```

## Mettre les connaissances ensemble pour comprendre le MVC

- on va afficher dynamiquement(via la BDD) la liste des posts via la method **index** :
    ```
     public function index()
        {
            $posts = Post::get();
    
            return view('posts.index', [
                'posts' => $posts
            ]);
        }
  ```
    - dans la vue :
        ```
        @extends('layouts.app')
        
        @section('content')
            <div style="margin: 25px">
                <a href="{{ route('posts.create') }}">Create Post</a>
            </div>
            @if (count($posts))
                @foreach ($posts as $post)
                    <div>
                         <a href="{{ route('posts.show',$post) }}">{{ $post->title}}</a>
                    </div>
                @endforeach
            @else
                il n'y a pas de posts
            @endif
        @endsection
      ```
  > on peut gérer l'ordre d'affichage des post(selon le dernier post par exemple) avec la fonction **latest()** : ` $posts = Post ::latest()->get();`
- la method **create** permet d'afficher le formulaire de création de post

- on va rendre dynamique la création de post via la method **store** :
    ```
         public function store(Request $request)
            {
                $this -> validate($request, [
                    'title' => 'required|max:20|min:4',
                    'body' => 'required|max:255|min:6',
                ]);
        
                Post ::create([
                    'title'=>$request->title,
                    'body'=>$request->body,
                ]);
        
                return redirect()
                    -> route('posts.index')
                    -> withStatus('Votre post a été créé!');
            }
    ```
    - on peut le rendre encore plus simple en utilisant la fonction _only()_ à l'intérieur de l'argument _$request_ :
        ```
         public function store(Request $request)
            {
                $this -> validate($request, [
                    'title' => 'required|max:20|min:4',
                    'body' => 'required|max:255|min:6',
                ]);
        
                Post ::create($request->only('title','body'));
        
                return redirect()
                    -> route('posts.index')
                    -> withStatus('Votre post a été créé!');
            }
      ```
- on va afficher dynamiquement(via la BDD) un post via la method **show** :
    ```
    public function show(Post $post)
        {
            return view('posts.show', [
                'post' => $post
            ]);
        }
  ```
    - dans la vue :
        ```
        @extends('layouts.app')
        
        @section('content')
            <h1> {{ $post->title }}</h1>
        
           <p> {{ $post->body }}</p>
        
        
            <a href="{{ route('posts.index') }}">Back to list</a>
        @endsection

      ```

## Les paginations

Pour pouvoir voir comment fonctionne la pagination, on va créer des données fake avec **Factory** :

Les factory se trouve dans le dossier **database/factories**

- on va créer un factory pour le model _Post_ avec la commande : `php artisan make:factory PostFactory`

-  on va aller dans le fichier et définir le faker pour chaque colonne de la rangée de la table dans la method _definition_ :
    ```
      public function definition()
        {
            return [
                'title'=>$this->faker->sentence(10),
                'body'=>$this->faker->sentence(200),
            ];
        }
   ```
- pour envoyer notre fake données dans la BDD, on va utiliser **tinker** de laravel avec la commande : `php artisan tinker` .
    
    - une fois dans tinker, saisir la commande suivante pour envoyer le faker dans la BDD : `App\Models\Post::factory()->create();`
    - pour en créer plusieurs, on va utiliser la fonction _tiles()_ : `App\Models\Post::factory()->times(200)->create();`
    

Pour utiliser la pagination, on utilisera la fonction **paginate**(à la place de la method **get**) dans la method _index_ qui affiche la liste des posts :
```
     public function index()
        {
            $posts = Post ::latest()->paginate(10);
    
            return view('posts.index', [
                'posts' => $posts
            ]);
        }
```

- dans la vue, on va ajouter les liens de pagination :
    ```
    @extends('layouts.app')
    
    @section('content')
        <div style="margin: 25px">
            <a href="{{ route('posts.create') }}">Create Post</a>
        </div>
        @if ($posts->count())
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show',$post) }}">{{ $post->title}}</a>
                </div>
            @endforeach
            {{ $posts ->links() }}
        @else
            il n'y a pas de posts
        @endif
    @endsection
  ```
- 




















