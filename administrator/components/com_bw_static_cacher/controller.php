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

defined('_JEXEC') or die;

/**
 * Component Controller
 */
class BwStaticCacherController extends JControllerLegacy
{
    
    protected $default_view = 'default';

    
    /**
    * constructor (registers additional tasks to methods)
    * @return void
    */
   public function __construct($config = array())
   {
       parent::__construct($config);
   }

    /**
     * Method to display a view.
     *
     * @param   boolean			If true, the view output will be cached
     * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController		This object to support chaining.
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ( isset($_POST['clear_all']) ) {
                // Очистка всего кеша
                $status = BwStaticCacher::getInstance()->clearAllCache();
                if ($status) {
                    JFactory::getDbo()->setQuery("TRUNCATE TABLE `#__bw_static_cacher_links`")
                            ->execute();
                    JFactory::getApplication()->enqueueMessage('Весь кеш успешно очищен', 'message');
                } else {
                    JFactory::getApplication()->enqueueMessage('Не удалось очистить весь кеш. Возможно, кеш уже был очищен ранее.', 'error');
                }
                //die('clear_all');
            } elseif ( isset($_POST['clear_url']) ) {
                // Очистка кеша конкретной страницы
                if ( preg_match('/https?:\/\/'. str_replace('.', '\.', $_SERVER['HTTP_HOST']) .'(.*)/i', $_POST['url'], $matches) ) {
                    $status = BwStaticCacher::getInstance()->init($matches[1])->clearUrlCache();
                    if ($status) {
                        JFactory::getDbo()->setQuery("UPDATE #__bw_static_cacher_links SET cached = 0 "
                                    . "WHERE request_uri = '". $matches[1] ."' ")
                                ->execute();
                        JFactory::getApplication()->enqueueMessage('Кеш страницы по адресу <a href="http://'. $_SERVER['HTTP_HOST'] . $matches[1] .'" target="_blank">http://'. $_SERVER['HTTP_HOST'] . $matches[1] .'</a> успешно очищен', 'message');
                    } else {
                        JFactory::getApplication()->enqueueMessage('Не удалось очистить кеш страницы по адресу <a href="http://'. $_SERVER['HTTP_HOST'] . $matches[1] .'" target="_blank">http://'. $_SERVER['HTTP_HOST'] . $matches[1] .'</a>. Возможно, кеш еще не создан или уже был очищен ранее.', 'error');
                    }
                } else {
                    JFactory::getApplication()->enqueueMessage('Нельзя очистить кеш. Неправильный адрес страницы', 'error');
                }
                //die('clear_url');
            }
            
            JFactory::getApplication()->redirect($_SERVER['REQUEST_URI']);
        }
        
        parent::display();

        return $this;
    }
}
