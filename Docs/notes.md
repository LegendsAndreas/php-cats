Database is in config/app_local.php.

If you install other dependencies with composer, and migrate the project to a different machine,
you need to install them as well, which you can do with the command: composer install

7zip is vital for CakePHP to work.

Download guide:
- Get xampp
- Get 7zip
- Get composer

Replace ToDo:
- Phinx.php:

        'development' => [
            'adapter' => 'mysql',
            'host' => '***',
            'name' => '***',
            'user' => '***',
            'pass' => '***',
            'port' => '3306',
            'charset' => 'utf8',
        ],

- app_local.php:


    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'nothing',
            'url' => env('DATABASE_URL', null),
        ],

    'Security' => [
        'salt' => env('SECURITY_SALT', 'your-secure-key-here'),
        'cookieKey' => 'your-secure-key-here', // Must be a strong random string
    ],

If you have a many-to-many relation, you can specify one of the relations to contain the other relation.
For example, if you have Cats and Contributors, with the table CatContributors, you can call all Contributors with their relevant cats:

    $contributors   = $this->Contributors->find()->Where(['deleted IS' => null])->contain(['Cats'])->toList();
