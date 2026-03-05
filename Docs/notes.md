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

phpcats.dk search engines
If i write phpcats.dk, or any other correct variations of it, it will almost always give me phpcats.dk as the first result.
However, for google, if i search for phpcats, it will assume that i meant pfp cats, and just ignore my actual search. If i click
"Søg i stedet efter phpcats", it will still give me the wrong answer, but at least why are a bit more coding related.
If i search for phpcats.dk, it will give me nearly ONLY pizzarias/grill related results.

[M1\Env\Exception\ParseException] Key can only contain alphanumeric and underscores and can not start with a number: ��DATABASE_HOST near ��DATABASE_HOST at line 1 in C:\Users\andreas\Desktop\code\php\php-cats\vendor\m1\env\src\Parser\KeyParser.php on line 48
[M1\Env\Exception\ParseException] Key can only contain alphanumeric and underscores and can not start with a number: ﻿DATABASE_HOST near ﻿DATABASE_HOST at line 1 in C:\Users\andreas\Desktop\code\php\php-cats\vendor\m1\env\src\Parser\KeyParser.php on line 48

I think the problem i have been having this whole time with invisible characters, is because of the encoding was wrong in the bottom right corner.
I believe it has to be UTF-8, no BOM

The PHP compiler is very fucking sensitive/shit and as such it will break if it sees a fucking BOM mark.

ssh -i C:\Users\andreas\Desktop\code\Hetzner\php-cats root@91.99.125.72

Cacheing can also be done on the server side of the project, like Cakephps own Cacheing does.


## Dotenv not loading correctly
Since the bootstrap uses the environment variables, you HAVE to load them before the application bootstraps.

    public function bootstrap(): void
    {
        $dotenv = new \josegonzalez\Dotenv\Loader(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
        $dotenv->parse()->putenv(true)->toEnv(true)->toServer(true);
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
            $this->addPlugin('Migrations');
        }
        $this->addPlugin('Authorization');
    }
