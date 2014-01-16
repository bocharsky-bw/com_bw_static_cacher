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
    <h2><i class="icon-chart"></i>&nbsp;&nbsp;Статистика</h2>
    <p><i class="icon-link" style="color: #A3AA00;"></i> Всего ссылок известных кэшеру: <big class="hasTooltip" title="" data-original-title="Общее количество найденных парсером ссылок, которые необходимо кэшировать" style="border-bottom: 1px dashed #AAA; font-weight: bold;"><?php print $this->countAll ?></big></p>
    <p><i class="icon-checkmark-circle" style="color: green;"></i> Всего страниц с действующим кэшем: <big class="hasTooltip" title="" data-original-title="Общее количество уже закэшированных страниц с действующим кэшем" style="border-bottom: 1px dashed #AAA; font-weight: bold;"><?php print $this->countCached ?></big></p>
    <p><i class="icon-cancel" style="color: red;"></i> Всего страниц которые нужно закэшировать:</span> <big class="hasTooltip" title="" data-original-title="Общее количество страниц, которые находятся в очереди на кэширование" style="border-bottom: 1px dashed #AAA; font-weight: bold;"><?php print $this->countAll - $this->countCached ?></big></p>
    <p><i class="icon-play-circle" style="color: blue;"></i> Всего страниц, которые были пропущены:</span> <big class="hasTooltip" title="" data-original-title="Общее количество страниц, которые были пропущены и не будут кэшироваться. Ничего страшного, скорее всего в парсер случайно попала недействительная ссылка." style="border-bottom: 1px dashed #AAA; font-weight: bold;"><?php print $this->countSkipped ?></big></p>
</div>