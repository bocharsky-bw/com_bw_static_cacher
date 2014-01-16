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
?>
<script>
    jQuery(document).ready(function(){
        jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});
    });
</script>
<?php if (!empty( $this->sidebar)) : ?>
<ul>
<div id="j-sidebar-container" class="span2">
    <h3>Меню</h3>
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif;?>
    <h2><span class="icon-cogs"></span>&nbsp;&nbsp;Настройки</h2>
    <p><span class="icon-cog"></span>&nbsp;<a href="index.php?option=com_config&view=component&component=com_bw_static_cacher">Перейти к основным настройкам компонента</a></p>
    <p>
        <span class="icon-link"></span>&nbsp;Адрес скрипта для запуска кэшера планировщиком заданий (Cron Tab): <br>
        <input type="text" value="http://<?php print $_SERVER['HTTP_HOST'] . str_replace('/administrator/', '/', JRoute::_('index.php?option=com_bw_static_cacher')) ?>" style="width: 500px;"><br>
        <em>* для настройки автоматического выполнения скрипта обратитесь к техподдержке Вашего хостига для получения информации по настройке <b>Cron Tab</b> с использованием утилиты <b>wget</b>.</em>
    </p>
    <p>
        <span class="icon-copy"></span>&nbsp;Пример запуска скрипта ежеминутно для локального web-сервера <b>OpenServer</b>:
        <pre>*/1 * * * *   %progdir%\modules\wget\bin\wget.exe -q --no-cache http://<?php print $_SERVER['HTTP_HOST'] . str_replace('/administrator/', '/', JRoute::_('index.php?option=com_bw_static_cacher')) ?> -O %progdir%\userdata\temp\temp.txt</pre>
    </p>
</div>