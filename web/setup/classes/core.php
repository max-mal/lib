<?php


class CoreSetup
{

    public $requiredModules = [
        'curl',
        'dom',
        'gd',
        'iconv',
        'imagick',
        'intl',
        'json',
        'libxml',
        'mbstring',
        'mysqli',
        'mysqlnd',
        'openssl',
        'pcre',
        'PDO',
        'pdo_mysql',
        'xdebug',
        'xml',
        'zip',
    ];

    public $appDir = null;
    
    function __construct()
    {
        $this->appDir = realpath(__DIR__ . '/../../../');

        if (file_exists($this->appDir . '/configs/main-local.php')) {
            return $this->render('error', new Exception("Приложение уже установлено"));
        }

        try {
            if (!isset($_GET['start'])) {
                return $this->render('start');
            }

            $this->checkModules();
            // $this->checkComposer();
            
            if (empty($_POST)) {
                return $this->render('install');
            }
                                    
            $this->installConfiguration();

            $this->runMigrations();

            $this->render('complete');
        } catch (Exception $e) {
            $this->render('error', $e);
        }
    }

    public function render($view, $data = null)
    {
        include $this->appDir . '/web/setup/views/layout.php';
    }

    public function checkModules()
    {
        foreach ($this->requiredModules as $module) {
            if (!extension_loaded($module)) {
                throw new Exception("Требуемый модуль $module не найден");
            }
        }
    }

    public function checkComposer()
    {
        $composerOutput = [];
        $composerExitCode = null;

        exec("bash -c 'cd $this->appDir; composer install'", $composerOutput, $composerExitCode);

        if ($composerExitCode !== 0) {
            throw new Exception("composer returned non 0 exit code: " . implode("\n", $composerOutput));
        }
    }

    public function installFiles()
    {
        shell_exec("cp -r $this->appDir/web/setup/files/* $this->appDir/");
    }

    public function installConfiguration()
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        $domain = $protocol . $_SERVER['HTTP_HOST'];
        $dbName = @$_POST['dbName'];
        $dbUser = @$_POST['dbUser'];
        $dbHost = @$_POST['dbHost'];
        $dbPassword = @$_POST['dbPassword'];
        $dbCharset = @$_POST['dbCharset'];

        if (!$dbHost) {
            $dbHost = 'localhost';
        }

        if (!$dbCharset) {
            $dbCharset = 'utf8mb4';
        }


        $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
             $pdo = new PDO($dsn, $dbUser, $dbPassword, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        $this->installFiles();


        $configFilename = $this->appDir . '/configs/main-local.php';
        
        $config = include $configFilename;

        $config['components']['db'] = [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . $dbHost . ';dbname=' . $dbName,
            'username' => $dbUser,
            'password' => $dbPassword,
            'charset' => $dbCharset,
            'enableSchemaCache' => false,
        ];

        $config['aliases'] = [
            '@frontendUrl' => $domain,
            '@backendUrl' => $domain . '/backend',
            '@staticUrl' => $domain . '/static',
        ];

        file_put_contents($configFilename, "<?php\nreturn " . var_export($config, true) . "\n?>");


        $configFilename = $this->appDir . '/configs/backend/main-local.php';
        $config = include $configFilename;

        $key = bin2hex(random_bytes(20));
        $config['components']['request']['cookieValidationKey'] = $key;
        file_put_contents($configFilename, "<?php\nreturn " . var_export($config, true) . "\n?>");


        $configFilename = $this->appDir . '/configs/frontend/main-local.php';
        $config = include $configFilename;

        $config['components']['request']['cookieValidationKey'] = $key;
        file_put_contents($configFilename, "<?php\nreturn " . var_export($config, true) . "\n?>");
    }

    public function runMigrations()
    {
        $migrationOutput = [];
        $migrationExitCode = null;

        exec("bash -c 'cd $this->appDir; bash ./migrations.sh'", $migrationOutput, $migrationExitCode);

        if ($migrationExitCode !== 0) {
            throw new Exception("migration returned non 0 exit code: " . implode("\n", $migrationOutput));
        }
    }
}
