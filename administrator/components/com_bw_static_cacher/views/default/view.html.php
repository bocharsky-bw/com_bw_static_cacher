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

class BwStaticCacherViewDefault extends JViewLegacy
{
    /**
     * Display the view
     */
    public function display($tpl = null) {
        BwStaticCacherHelper::generateToolbar();
        $this->sidebar = BwStaticCacherHelper::generateSidebar();
        parent::display($tpl);
    }
}