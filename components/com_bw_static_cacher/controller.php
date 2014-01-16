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
        
        parent::display();

        return $this;
    }
}
