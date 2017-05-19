<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$app = JFactory::getApplication();

if ($app->isClient('site')) {
    JSession::checkToken('get') or die(JText::_('JINVALID_TOKEN'));
}

JHtml::_('behavior.core');
JHtml::_('bootstrap.tooltip', '.hasTooltip', array('placement' => 'bottom'));
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.polyfill', array('event'), 'lt IE 9');
JHtml::_('script', 'com_musicband/admin-contract-modal.js', array('version' => 'auto', 'relative' => true));
// Special case for the search field tooltip.
//$searchFilterDesc = $this->filterForm->getFieldAttribute('search', 'description', null, 'filter');
//JHtml::_('bootstrap.tooltip', '#filter_search', array('title' => JText::_($searchFilterDesc), 'placement' => 'bottom'));

$function = $app->input->getCmd('function', 'jSelectContract');
$editor = $app->input->getCmd('editor', '');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$onclick = $this->escape($function);

if (!empty($editor)) {
    // This view is used also in com_menus. Load the xtd script only if the editor is set!
    JFactory::getDocument()->addScriptOptions('xtd-contracts', array('editor' => $editor));
    $onclick = "jSelectContract";
}
?>
<div class="container-popup">

    <form action="<?php echo JRoute::_('index.php?option=com_musicband&view=contract&layout=modal&tmpl=component&function=' . $function . '&' . JSession::getFormToken() . '=1'); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
        <?php if (empty($this->contracts)) : ?>
            <div class="alert alert-no-items">
                <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
        <?php else : ?>

            <fieldset id="filter-bar">

                <div class="filter-search fltlt">
                    <label for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
                    <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')) ?>"/>
                    <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
                    <button type="button" onclick="document.id('filter_search').value = '';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
                </div>

            </fieldset>

            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th width="1%" class="nowrap">
                            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                        </th>



                        <th class="nowrap title">
                            <?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'title', $listDirn, $listOrder); ?>
                        </th>

                    </tr>
                </thead>
                <!--tfoot>
                    <tr>
                        <td colspan="2">
                <?php //echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                </tfoot-->
                <tbody>
                    <?php foreach ($this->contracts as $i => $item) : ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td align="center">
                                <?php echo (int) $item->id; ?>
                            </td>
                            <td>
                                <a class="select-link" href="javascript:void(0)" data-function="<?php echo $this->escape($onclick); ?>" data-id="<?php echo $item->id; ?>" data-title="<?php echo $this->escape(addslashes($item->title)); ?>" data-uri="index.php?option=com_musicband&view=contract&id=<?php echo $item->id; ?>" >
                                    <?php echo $this->escape($item->title); ?>
                                </a>
                                <?php echo $this->escape($item->title); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <input type="hidden" name="filter_order" value="<?php echo $listOrder ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDir ?>" />
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </form>
</div>
