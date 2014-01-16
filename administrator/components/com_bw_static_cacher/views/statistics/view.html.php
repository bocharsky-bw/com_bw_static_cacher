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

class BwStaticCacherViewStatistics extends JViewLegacy
{
    /**
     * Display the view
     */
    public function display($tpl = null) {
        $db = JFactory::getDbo();
        $this->countAll = $db->setQuery("SELECT "
                    . "COUNT(id) "
                    . "FROM #__bw_static_cacher_links ")
                ->loadResult();
        $this->countCached = $db->setQuery("SELECT "
                    . "COUNT(id) "
                    . "FROM #__bw_static_cacher_links "
                    . "WHERE 1=1 "
                    . "AND cached = 1 ")
                ->loadResult();
		$this->countSkipped = $db->setQuery("SELECT "
                    . "COUNT(id) "
                    . "FROM #__bw_static_cacher_links "
                    . "WHERE 1=1 "
                    . "AND skipped >= 2 ")
                ->loadResult();
        
        BwStaticCacherHelper::generateToolbar();
        $this->sidebar = BwStaticCacherHelper::generateSidebar();
        parent::display($tpl);
    }
}