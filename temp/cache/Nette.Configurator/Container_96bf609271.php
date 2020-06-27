<?php
// source: /home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/config/config.neon 
// source: /home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/config/config.local.neon 

class Container_96bf609271 extends Nette\DI\Container
{
	protected $meta = [
		'types' => [
			'Nette\Application\Application' => [1 => ['application.application']],
			'Nette\Application\IPresenterFactory' => [1 => ['application.presenterFactory']],
			'Nette\Application\LinkGenerator' => [1 => ['application.linkGenerator']],
			'Nette\Caching\Storages\IJournal' => [1 => ['cache.journal']],
			'Nette\Caching\IStorage' => [1 => ['cache.storage']],
			'Nette\Database\Connection' => [1 => ['database.default.connection']],
			'Nette\Database\IStructure' => [1 => ['database.default.structure']],
			'Nette\Database\Structure' => [1 => ['database.default.structure']],
			'Nette\Database\IConventions' => [1 => ['database.default.conventions']],
			'Nette\Database\Conventions\DiscoveredConventions' => [1 => ['database.default.conventions']],
			'Nette\Database\Context' => [1 => ['database.default.context']],
			'Nette\Http\RequestFactory' => [1 => ['http.requestFactory']],
			'Nette\Http\IRequest' => [1 => ['http.request']],
			'Nette\Http\Request' => [1 => ['http.request']],
			'Nette\Http\IResponse' => [1 => ['http.response']],
			'Nette\Http\Response' => [1 => ['http.response']],
			'Nette\Http\Context' => [1 => ['http.context']],
			'Nette\Bridges\ApplicationLatte\ILatteFactory' => [1 => ['latte.latteFactory']],
			'Nette\Application\UI\ITemplateFactory' => [1 => ['latte.templateFactory']],
			'Nette\Mail\IMailer' => [1 => ['mail.mailer']],
			'Nette\Application\IRouter' => [1 => ['routing.router']],
			'Nette\Security\IUserStorage' => [1 => ['security.userStorage']],
			'Nette\Security\User' => [1 => ['security.user']],
			'Nette\Http\Session' => [1 => ['session.session']],
			'Tracy\ILogger' => [1 => ['tracy.logger']],
			'Tracy\BlueScreen' => [1 => ['tracy.blueScreen']],
			'Tracy\Bar' => [1 => ['tracy.bar']],
			'Kdyby\Facebook\Configuration' => [1 => ['facebook.config']],
			'Kdyby\Facebook\SessionStorage' => [1 => ['facebook.session']],
			'Kdyby\Facebook\ApiClient' => [1 => ['facebook.apiClient']],
			'Kdyby\Facebook\Facebook' => [1 => ['facebook.client']],
			'App\Forms\FormFactory' => [1 => ['28_App_Forms_FormFactory']],
			'App\Model\BooksModel' => [1 => ['29_App_Model_BooksModel']],
			'App\Model\GenresModel' => [1 => ['30_App_Model_GenresModel']],
			'Nette\Security\IAuthenticator' => [1 => ['31_App_Model_UsersModel']],
			'App\Model\UsersModel' => [1 => ['31_App_Model_UsersModel']],
			'PDO' => [1 => ['pdo']],
			'App\Presenters\BasePresenter' => [1 => ['application.1', 'application.4']],
			'Nette\Application\UI\Presenter' => [['application.1', 'application.3', 'application.4']],
			'Nette\Application\UI\Control' => [['application.1', 'application.3', 'application.4']],
			'Nette\Application\UI\Component' => [['application.1', 'application.3', 'application.4']],
			'Nette\ComponentModel\Container' => [['application.1', 'application.3', 'application.4']],
			'Nette\ComponentModel\Component' => [['application.1', 'application.3', 'application.4']],
			'Nette\Application\UI\IRenderable' => [['application.1', 'application.3', 'application.4']],
			'Nette\ComponentModel\IContainer' => [['application.1', 'application.3', 'application.4']],
			'Nette\ComponentModel\IComponent' => [['application.1', 'application.3', 'application.4']],
			'Nette\Application\UI\ISignalReceiver' => [['application.1', 'application.3', 'application.4']],
			'Nette\Application\UI\IStatePersistent' => [['application.1', 'application.3', 'application.4']],
			'ArrayAccess' => [['application.1', 'application.3', 'application.4']],
			'Nette\Application\IPresenter' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
				],
			],
			'App\Presenters\UserPresenter' => [1 => ['application.1']],
			'App\Presenters\ErrorPresenter' => [1 => ['application.2']],
			'App\Presenters\BookPresenter' => [1 => ['application.3']],
			'App\Presenters\Error4xxPresenter' => [1 => ['application.4']],
			'NetteModule\ErrorPresenter' => [1 => ['application.5']],
			'NetteModule\MicroPresenter' => [1 => ['application.6']],
			'Nette\DI\Container' => [1 => ['container']],
		],
		'services' => [
			'28_App_Forms_FormFactory' => 'App\Forms\FormFactory',
			'29_App_Model_BooksModel' => 'App\Model\BooksModel',
			'30_App_Model_GenresModel' => 'App\Model\GenresModel',
			'31_App_Model_UsersModel' => 'App\Model\UsersModel',
			'application.1' => 'App\Presenters\UserPresenter',
			'application.2' => 'App\Presenters\ErrorPresenter',
			'application.3' => 'App\Presenters\BookPresenter',
			'application.4' => 'App\Presenters\Error4xxPresenter',
			'application.5' => 'NetteModule\ErrorPresenter',
			'application.6' => 'NetteModule\MicroPresenter',
			'application.application' => 'Nette\Application\Application',
			'application.linkGenerator' => 'Nette\Application\LinkGenerator',
			'application.presenterFactory' => 'Nette\Application\IPresenterFactory',
			'cache.journal' => 'Nette\Caching\Storages\IJournal',
			'cache.storage' => 'Nette\Caching\IStorage',
			'container' => 'Nette\DI\Container',
			'database.default.connection' => 'Nette\Database\Connection',
			'database.default.context' => 'Nette\Database\Context',
			'database.default.conventions' => 'Nette\Database\Conventions\DiscoveredConventions',
			'database.default.structure' => 'Nette\Database\Structure',
			'facebook.apiClient' => 'Kdyby\Facebook\ApiClient',
			'facebook.client' => 'Kdyby\Facebook\Facebook',
			'facebook.config' => 'Kdyby\Facebook\Configuration',
			'facebook.session' => 'Kdyby\Facebook\SessionStorage',
			'http.context' => 'Nette\Http\Context',
			'http.request' => 'Nette\Http\Request',
			'http.requestFactory' => 'Nette\Http\RequestFactory',
			'http.response' => 'Nette\Http\Response',
			'latte.latteFactory' => 'Latte\Engine',
			'latte.templateFactory' => 'Nette\Application\UI\ITemplateFactory',
			'mail.mailer' => 'Nette\Mail\IMailer',
			'pdo' => 'PDO',
			'routing.router' => 'Nette\Application\IRouter',
			'security.user' => 'Nette\Security\User',
			'security.userStorage' => 'Nette\Security\IUserStorage',
			'session.session' => 'Nette\Http\Session',
			'tracy.bar' => 'Tracy\Bar',
			'tracy.blueScreen' => 'Tracy\BlueScreen',
			'tracy.logger' => 'Tracy\ILogger',
		],
		'tags' => [
			'inject' => [
				'application.1' => true,
				'application.2' => true,
				'application.3' => true,
				'application.4' => true,
				'application.5' => true,
				'application.6' => true,
				'facebook.apiClient' => false,
				'facebook.client' => false,
				'facebook.config' => false,
				'facebook.session' => false,
			],
			'nette.presenter' => [
				'application.1' => 'App\Presenters\UserPresenter',
				'application.2' => 'App\Presenters\ErrorPresenter',
				'application.3' => 'App\Presenters\BookPresenter',
				'application.4' => 'App\Presenters\Error4xxPresenter',
				'application.5' => 'NetteModule\ErrorPresenter',
				'application.6' => 'NetteModule\MicroPresenter',
			],
		],
		'aliases' => [
			'application' => 'application.application',
			'cacheStorage' => 'cache.storage',
			'database.default' => 'database.default.connection',
			'httpRequest' => 'http.request',
			'httpResponse' => 'http.response',
			'nette.cacheJournal' => 'cache.journal',
			'nette.database.default' => 'database.default',
			'nette.database.default.context' => 'database.default.context',
			'nette.httpContext' => 'http.context',
			'nette.httpRequestFactory' => 'http.requestFactory',
			'nette.latteFactory' => 'latte.latteFactory',
			'nette.mailer' => 'mail.mailer',
			'nette.presenterFactory' => 'application.presenterFactory',
			'nette.templateFactory' => 'latte.templateFactory',
			'nette.userStorage' => 'security.userStorage',
			'router' => 'routing.router',
			'session' => 'session.session',
			'user' => 'security.user',
		],
	];


	public function __construct(array $params = [])
	{
		$this->parameters = $params;
		$this->parameters += [
			'appDir' => '/home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app',
			'wwwDir' => '/home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/www',
			'debugMode' => false,
			'productionMode' => true,
			'consoleMode' => false,
			'tempDir' => '/home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/../temp',
			'dsn' => 'mysql:host=sql109.epizy.com;dbname=epiz_25959449_bookhero',
			'user' => 'sql109.epizy.com',
			'password' => 'eA2eFAm5DX6',
		];
	}


	public function createService__28_App_Forms_FormFactory(): App\Forms\FormFactory
	{
		$service = new App\Forms\FormFactory;
		return $service;
	}


	public function createService__29_App_Model_BooksModel(): App\Model\BooksModel
	{
		$service = new App\Model\BooksModel($this->getService('pdo'));
		return $service;
	}


	public function createService__30_App_Model_GenresModel(): App\Model\GenresModel
	{
		$service = new App\Model\GenresModel($this->getService('pdo'));
		return $service;
	}


	public function createService__31_App_Model_UsersModel(): App\Model\UsersModel
	{
		$service = new App\Model\UsersModel($this->getService('pdo'));
		return $service;
	}


	public function createServiceApplication__1(): App\Presenters\UserPresenter
	{
		$service = new App\Presenters\UserPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->injectFacebook($this->getService('facebook.client'));
		$service->injectUsersModel($this->getService('31_App_Model_UsersModel'));
		$service->invalidLinkMode = 1;
		return $service;
	}


	public function createServiceApplication__2(): App\Presenters\ErrorPresenter
	{
		$service = new App\Presenters\ErrorPresenter($this->getService('tracy.logger'));
		return $service;
	}


	public function createServiceApplication__3(): App\Presenters\BookPresenter
	{
		$service = new App\Presenters\BookPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->injectBooksModel($this->getService('29_App_Model_BooksModel'));
		$service->injectGenresModel($this->getService('30_App_Model_GenresModel'));
		$service->invalidLinkMode = 1;
		return $service;
	}


	public function createServiceApplication__4(): App\Presenters\Error4xxPresenter
	{
		$service = new App\Presenters\Error4xxPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 1;
		return $service;
	}


	public function createServiceApplication__5(): NetteModule\ErrorPresenter
	{
		$service = new NetteModule\ErrorPresenter($this->getService('tracy.logger'));
		return $service;
	}


	public function createServiceApplication__6(): NetteModule\MicroPresenter
	{
		$service = new NetteModule\MicroPresenter($this, $this->getService('http.request'), $this->getService('routing.router'));
		return $service;
	}


	public function createServiceApplication__application(): Nette\Application\Application
	{
		$service = new Nette\Application\Application(
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response')
		);
		$service->catchExceptions = true;
		$service->errorPresenter = 'Error';
		Nette\Bridges\ApplicationTracy\RoutingPanel::initializePanel($service);
		return $service;
	}


	public function createServiceApplication__linkGenerator(): Nette\Application\LinkGenerator
	{
		$service = new Nette\Application\LinkGenerator(
			$this->getService('routing.router'),
			$this->getService('http.request')->getUrl(),
			$this->getService('application.presenterFactory')
		);
		return $service;
	}


	public function createServiceApplication__presenterFactory(): Nette\Application\IPresenterFactory
	{
		$service = new Nette\Application\PresenterFactory(new Nette\Bridges\ApplicationDI\PresenterFactoryCallback($this, 1, null));
		$service->setMapping(['*' => 'App\*Module\Presenters\*Presenter']);
		return $service;
	}


	public function createServiceCache__journal(): Nette\Caching\Storages\IJournal
	{
		$service = new Nette\Caching\Storages\SQLiteJournal('/home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/../temp/cache/journal.s3db');
		return $service;
	}


	public function createServiceCache__storage(): Nette\Caching\IStorage
	{
		$service = new Nette\Caching\Storages\FileStorage(
			'/home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/../temp/cache',
			$this->getService('cache.journal')
		);
		return $service;
	}


	public function createServiceContainer(): Nette\DI\Container
	{
		return $this;
	}


	public function createServiceDatabase__default__connection(): Nette\Database\Connection
	{
		$service = new Nette\Database\Connection('mysql:host=sql109.epizy.com;dbname=epiz.25959449_bookhero', 'epiz_25959449', 'eA2eFAm5DX6', null);
		$this->getService('tracy.blueScreen')->addPanel('Nette\Bridges\DatabaseTracy\ConnectionPanel::renderException');
		return $service;
	}


	public function createServiceDatabase__default__context(): Nette\Database\Context
	{
		$service = new Nette\Database\Context(
			$this->getService('database.default.connection'),
			$this->getService('database.default.structure'),
			$this->getService('database.default.conventions'),
			$this->getService('cache.storage')
		);
		return $service;
	}


	public function createServiceDatabase__default__conventions(): Nette\Database\Conventions\DiscoveredConventions
	{
		$service = new Nette\Database\Conventions\DiscoveredConventions($this->getService('database.default.structure'));
		return $service;
	}


	public function createServiceDatabase__default__structure(): Nette\Database\Structure
	{
		$service = new Nette\Database\Structure($this->getService('database.default.connection'), $this->getService('cache.storage'));
		return $service;
	}


	public function createServiceFacebook__apiClient(): Kdyby\Facebook\ApiClient
	{
		$service = new Kdyby\Facebook\Api\CurlClient;
		$service->curlOptions = [
			78 => 10,
			13 => 60,
			10023 => ['User-Agent: kdyby-facebook-1.1'],
			2 => true,
			42 => true,
			19913 => true,
		];;
		return $service;
	}


	public function createServiceFacebook__client(): Kdyby\Facebook\Facebook
	{
		$service = new Kdyby\Facebook\Facebook(
			$this->getService('facebook.config'),
			$this->getService('facebook.session'),
			$this->getService('facebook.apiClient'),
			$this->getService('http.request'),
			$this->getService('http.response')
		);
		return $service;
	}


	public function createServiceFacebook__config(): Kdyby\Facebook\Configuration
	{
		$service = new Kdyby\Facebook\Configuration('664082147256882', '7b1594aeaf0ec1f79ed63b4e9a6062d7');
		$service->verifyApiCalls = true;
		$service->fileUploadSupport = false;
		$service->trustForwarded = false;
		$service->permissions = ['public_profile', 'email'];
		$service->canvasBaseUrl = null;
		$service->graphVersion = 'v2.3';
		return $service;
	}


	public function createServiceFacebook__session(): Kdyby\Facebook\SessionStorage
	{
		$service = new Kdyby\Facebook\SessionStorage($this->getService('session.session'), $this->getService('facebook.config'));
		return $service;
	}


	public function createServiceHttp__context(): Nette\Http\Context
	{
		$service = new Nette\Http\Context($this->getService('http.request'), $this->getService('http.response'));
		trigger_error('Service http.context is deprecated.', 16384);
		return $service;
	}


	public function createServiceHttp__request(): Nette\Http\Request
	{
		$service = $this->getService('http.requestFactory')->createHttpRequest();
		return $service;
	}


	public function createServiceHttp__requestFactory(): Nette\Http\RequestFactory
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy([]);
		return $service;
	}


	public function createServiceHttp__response(): Nette\Http\Response
	{
		$service = new Nette\Http\Response;
		return $service;
	}


	public function createServiceLatte__latteFactory(): Nette\Bridges\ApplicationLatte\ILatteFactory
	{
		return new class ($this) implements Nette\Bridges\ApplicationLatte\ILatteFactory {
			private $container;


			public function __construct(Container_96bf609271 $container)
			{
				$this->container = $container;
			}


			public function create(): Latte\Engine
			{
				$service = new Latte\Engine;
				$service->setTempDirectory('/home/vol4_1/epizy.com/epiz_25959449/htdocs/bookhero/app/../temp/cache/latte');
				$service->setAutoRefresh(false);
				$service->setContentType('html');
				Nette\Utils\Html::$xhtml = false;
				return $service;
			}
		};
	}


	public function createServiceLatte__templateFactory(): Nette\Application\UI\ITemplateFactory
	{
		$service = new Nette\Bridges\ApplicationLatte\TemplateFactory(
			$this->getService('latte.latteFactory'),
			$this->getService('http.request'),
			$this->getService('security.user'),
			$this->getService('cache.storage'),
			null
		);
		return $service;
	}


	public function createServiceMail__mailer(): Nette\Mail\IMailer
	{
		$service = new Nette\Mail\SendmailMailer;
		return $service;
	}


	public function createServicePdo(): PDO
	{
		$service = new PDO('mysql:host=sql109.epizy.com;dbname=epiz_25959449_bookhero', 'epiz_25959449', 'eA2eFAm5DX6');
		return $service;
	}


	public function createServiceRouting__router(): Nette\Application\IRouter
	{
		$service = App\RouterFactory::createRouter();
		return $service;
	}


	public function createServiceSecurity__user(): Nette\Security\User
	{
		$service = new Nette\Security\User($this->getService('security.userStorage'), $this->getService('31_App_Model_UsersModel'));
		$sl = $this; $service->onLoggedOut[] = function () use ($sl) { $sl->getService('facebook.session')->clearAll(); };
		return $service;
	}


	public function createServiceSecurity__userStorage(): Nette\Security\IUserStorage
	{
		$service = new Nette\Http\UserStorage($this->getService('session.session'));
		return $service;
	}


	public function createServiceSession__session(): Nette\Http\Session
	{
		$service = new Nette\Http\Session($this->getService('http.request'), $this->getService('http.response'));
		$service->setExpiration('14 days');
		return $service;
	}


	public function createServiceTracy__bar(): Tracy\Bar
	{
		$service = Tracy\Debugger::getBar();
		return $service;
	}


	public function createServiceTracy__blueScreen(): Tracy\BlueScreen
	{
		$service = Tracy\Debugger::getBlueScreen();
		return $service;
	}


	public function createServiceTracy__logger(): Tracy\ILogger
	{
		$service = Tracy\Debugger::getLogger();
		return $service;
	}


	public function initialize()
	{
		date_default_timezone_set('Europe/Prague');
		$this->getService('http.response')->setHeader('X-Powered-By', 'Nette Framework');
		$this->getService('http.response')->setHeader('Content-Type', 'text/html; charset=utf-8');
		$this->getService('http.response')->setHeader('X-Frame-Options', 'SAMEORIGIN');
		$this->getService('session.session')->exists() && $this->getService('session.session')->start();
		Tracy\Debugger::$editorMapping = [];
		Tracy\Debugger::setLogger($this->getService('tracy.logger'));
	}
}
