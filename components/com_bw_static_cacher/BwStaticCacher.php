<?php
/**
 * @package     Joomla BW
 * @subpackage  com_bw_static_cacher
 *
 * @copyright   (C) 2013 BW - Bocharsky Victor. BrainForce Labs. All rights reserved.
 * @author      Bocharsky Victor <mail@brainforce.kiev.ua>
 * @link        http://brainforce.kiev.ua/ BrainForce Labs - Joomla CMS projects
 * @license     All right reserved by Bocharsky Victor
 */

class BwStaticCacher {
    
    protected static $instance;  // object instance
    
    private $httpHost;
    
    private $requestUri;

    private $cachePath;
    
    private $dir;
    
    private $filename;
    
    private $content;
    
    private $links = array();


    private function __construct() { }
    private function __clone()    { /* ... @return Singleton */ }  // Защищаем от создания через клонирование
    private function __wakeup()   { /* ... @return Singleton */ }  // Защищаем от создания через unserialize
    
    
    /**
     * Get instance of BwStaticCacher class
     * 
     * @return BwStaticCacher
     */
    public static function getInstance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function init($requestUri = NULL, $httpHost = NULL) {
        $this->setHttpHost($httpHost);
        $this->setRequestUri($requestUri);
        if ( ! preg_match('/^(.*\/)?([^\/]+)$/', $this->cachePath, $matches)) {
            //var_dump($this->cachePath);
            //var_dump($matches);
            die ('Ошибка! Не удалось получить имя файла и путь к директории');
        }
        $this->dir = __DIR__ .'/../../cache/_bw/'. $matches[1];
        $this->filename = $matches[2] .'.html';

        return $this;
    }
    
    /**
     * Поиск закешированной страницы и ее отображение только при GET методе
     */
    public function find() {
        if ( ! $this->isMethod('GET') || isset($_GET['--force']) ) {
            
            return NULL;
        }
		
        if (file_exists($this->dir . $this->filename)) {
			$expires = 3600;
			header('Expires: '. gmdate('D, d M Y H:i:s', time() + $expires) .' GMT');
			header('Cache-Control: public, max-age='. $expires .'');
			readfile($this->dir . $this->filename);
			exit;
		}
    }
    
    public function cache() {
		$opts = array('http' =>
			array(
				'method' => "GET",
				'timeout' => 25, // Время ожидания загрузки старницы
			)
		);
		$context = stream_context_create($opts);
		
        $this->content = file_get_contents('http://'. $this->httpHost . $this->requestUri, FALSE, $context);
        if ( ! $this->content) {
            return FALSE;
        }
        if ( ! is_dir($this->dir) ) {
            if ( ! mkdir($this->dir, 0755, TRUE)) {
                return FALSE;
            }
        }
        
        return (boolean) file_put_contents($this->dir . $this->filename, $this->content);
    }
    
    public function parse() {
        if (preg_match_all('/\<a[^\>]+href="(?!javascript|https?:\/\/)([^"\'#]+)"/i', $this->content, $matches)) {
            $this->links = array_unique($matches[1]);
        }
        
        return TRUE;
    }
    
    public function getLinks() {
        
        return $this->links;
    }
    
    private function isMethod($method) {
        
        return $_SERVER['REQUEST_METHOD'] == $method;
    }
    
    private function setHttpHost($httpHost) {
        $this->httpHost = $httpHost ? $httpHost : $_SERVER['HTTP_HOST'];
		
        return $this;
    }
    
    private function setRequestUri($requestUri) {
        $this->requestUri = $requestUri ? $requestUri : $_SERVER['REQUEST_URI'];
        
        $this->cachePath = $this->httpHost . $this->requestUri;
        $this->cachePath = preg_replace(
            array(
                '/index\.php\/?/i',
                '/\/$/', // сопровождающий слеш
                '/[^\/0-9A-Za-z_-]/', // спец. символы
            ),
            array(
                '',
                '-',
                '-',
            ),
            $this->cachePath
        );
        
        return $this;
    }
    
    public function clearUrlCache() {

        return unlink($this->dir . $this->filename);
    }
    
    public function clearAllCache() {
        
        return $this->rrmdir(__DIR__ .'/../../cache/_bw/');
    }
    
    /**
     * Recursively remove a directory
     * @param string $dir
     */
    private function rrmdir($dir) {
        $status = TRUE;
        
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                $status &= $this->rrmdir($file);
            else
                $status &= unlink($file);
        }
        
        $status &= rmdir($dir);
        
        return (boolean) $status;
    }
}
