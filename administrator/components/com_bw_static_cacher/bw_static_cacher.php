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

//JHtml::_('behavior.tabstate');
//if (!JFactory::getUser()->authorise('core.manage', 'com_contact')) {
//    
//    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
//}

require_once __DIR__ .'/../../../components/com_bw_static_cacher/BwStaticCacher.php';

// Регистрация плагина в системе
JLoader::register('BwStaticCacherHelper', __DIR__ .'/helpers/bw_static_cacher_helper.php');

$controller = JControllerLegacy::getInstance('BwStaticCacher');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
