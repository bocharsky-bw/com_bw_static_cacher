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

defined('_JEXEC') or die();

/**
 * A centralized place for GUI-related helper functions
 */
class BwStaticCacherHelper
{
    
    public static function generateToolbar() {
        
        JFactory::getApplication()->input->set('hidemainmenu', false);
        JToolbarHelper::title(JText::_('COM_BW_STATIC_CACHER'), 'flash');
    }
    
    public static function generateSidebar() {
        
        JHtmlSidebar::addEntry(
                JText::_('com_bw_static_cacher'),
                'index.php?option=com_bw_static_cacher',
                JFactory::getApplication()->input->get('view', '') == ''
        );
        JHtmlSidebar::addEntry(
                JText::_('Настройки'),
                'index.php?option=com_bw_static_cacher&view=config',
                JFactory::getApplication()->input->get('view', '') == 'config'
        );
        JHtmlSidebar::addEntry(
                JText::_('Статистика'),
                'index.php?option=com_bw_static_cacher&view=statistics',
                JFactory::getApplication()->input->get('view', '') == 'statistics'
        );
        
        return JHtmlSidebar::render();
    }
}