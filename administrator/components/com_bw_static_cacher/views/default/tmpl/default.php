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
function isBlank(selector, message) {
    if ( jQuery(selector).val().trim() ) {
        return true;
    }
    alert(message);
    return false;
}
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
    <form action="<?php echo JRoute::_('index.php?option=com_bw_static_cacher'); ?>" method="post" name="adminForm" id="adminForm">
        <div id="filter-bar" class="btn-toolbar">
            <div class="btn-group pull-left">
                <input type="text" id="url" class="hasTooltip" name="url" placeholder="http://my.domain.com/contacts" value="" title="" data-original-title="URL-адрес страницы, кэш которой нужно очистить">
            </div>
            <div class="btn-group pull-left">
                <button type="submit" name="clear_url" class="btn hasTooltip" title="" data-original-title="Очистить кэш указанной страницы" onclick="return isBlank('#url', 'Сначала введите URL-адрес страницы')"><i class="icon-trash"></i> Очистить кэш страницы</button>
            </div>
            <button type="submit" name="clear_all" class="btn hasTooltip btn-danger" data-original-title="Очистка всего кэша может привести к большой нагрузке на сервер, пока кэш не будет заново сформировнан. Рекомендуется выполнять полную очистку ближе к расписанию начала формирования нового кэша и в период с наименьшей нагрузкой на сервер" onclick="return confirm('Вы действительно хотите очистить весь кэш?')"><i class="icon-trash"></i> Очистить весь кэш</button>
        </div>
    </form>
    <div class="clearfix"> </div>
	<div>
		<a class="btn hasTooltip btn-success btn-large" href="http://<?php print $_SERVER['HTTP_HOST'] . str_replace('/administrator/', '/', JRoute::_('index.php?option=com_bw_static_cacher')) ?>" target="_blank"  data-original-title="Запуск одного цикла генерации кеша вне очереди">
			<i class="icon-play"></i> Запустить вручную генерацию кэша
		</a>
	</div>
</div>