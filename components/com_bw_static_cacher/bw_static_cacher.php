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

// Protect from unauthorized access
defined('_JEXEC') or die();

// Регистрация плагина в системе
//JLoader::register('BwStaticCacherHelper', __DIR__ . '/helpers/bw_static_cacher_helper.php');

//$controller = JControllerLegacy::getInstance('BwStaticCacher');
//$controller->execute(JFactory::getApplication()->input->get('task'));
//$controller->redirect();

// Set up the data to be sent in the response.
$param  = JComponentHelper::getParams('com_bw_static_cacher');

$skipped = 2; // Порог пропускания - Количество попыток закешировать ссылку после которых она пропускается системой
$limit = $param->get('links_limit'); // Количество обрабатываемых и кэшируемых ссылок за один проход
$limit = $limit ? $limit : 1; // Как минимум одна ссылка должна обрабатываться
        
$db = JFactory::getDbo();

require_once __DIR__ .'/BwStaticCacher.php';

$count = $db->setQuery("SELECT "
            . "COUNT(id) "
            . "FROM #__bw_static_cacher_links ")
        ->loadResult();
if ($count == 0) {
    // добавляем в БД ссылку на главную страницу
    $db->setQuery("INSERT INTO #__bw_static_cacher_links "
                . "(request_uri, deep) VALUES ('". str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ."', 0) ")
            ->execute();
}

$links = $db->setQuery("SELECT "
            . "* "
            . "FROM #__bw_static_cacher_links "
            . "WHERE 1=1 "
            . "AND cached = 0 "
            . "AND skipped < $skipped "
            . "ORDER BY deep ASC, id ASC "
            . "LIMIT $limit ")
        ->loadAssocList();
if ( count($links) == 0 ) {
    // Все известные страницы были закешированы.
    // Снимаем флаг cached и перегенерируем кеш.
    $db->setQuery("UPDATE #__bw_static_cacher_links SET "
                . "cached = 0 ")
            ->execute();
} else {
    foreach ($links as $link) {
        $cacher = BwStaticCacher::getInstance()->init($link['request_uri']);
        $cacher->clearUrlCache(); // Удаление старого кэша страницы перед перегенерацией
        if ( $cacher->cache() ) { // Если страница успешно закеширована
            $cacher->parse(); // парсим страницу для поиска новых ссылок
            
            // Сохранение новых ссылок в БД
            foreach ($cacher->getLinks() as $requestUri) {
                $requestUri = htmlspecialchars_decode($requestUri); // Очищаем от закодированных спец. символов
                $count = $db->setQuery("SELECT "
                        . "COUNT(id) "
                        . "FROM #__bw_static_cacher_links "
                        . "WHERE 1=1 "
                        . "AND request_uri = '". $requestUri ."' ")
                    ->loadResult();
                if ( (int)$count == 0 ) {
                    $db->setQuery("INSERT INTO #__bw_static_cacher_links "
                            . "(request_uri, deep) VALUES ('". $requestUri ."', '". substr_count($requestUri, '/') ."') ")
                        ->execute();
                }
            }

            // Подымаем флаг что страница успешно закеширована и пропарсена
            $db->setQuery("UPDATE #__bw_static_cacher_links SET "
                    . "cached = 1 "
                    . "WHERE 1=1 "
                    . "AND id = ". $link['id'] ." ")
                ->execute();
        } else {
			// Увеличиваем порог на 1 для пропуска ссылки
			$db->setQuery("UPDATE #__bw_static_cacher_links SET "
                    . "skipped = skipped + 1 "
                    . "WHERE 1=1 "
                    . "AND id = ". $link['id'] ." ")
                ->execute();
		}
    }
}
die('Finished');
