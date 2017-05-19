<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted Access');

if (!empty($this->sidebar)) :
    ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php else : ?>
        <div id="j-main-container">
        <?php endif; ?>
        <form action="<?php echo JRoute::_('index.php?option=com_musicband'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">   
            <div class="form-horizontal">
                <fieldset class="adminform">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <div class="control-label">
                                    <label id="jform_excel-lbl" for="jform_excel" class="hasTooltip" title="" data-original-title="<strong><?php echo JText::_('COM_MUSICBAND_EXCEL_FILE'); ?></strong><br /><?php echo JText::_('COM_MUSICBAND_EXCEL_FILE_INFO'); ?>"><?php echo JText::_('COM_MUSICBAND_EXCEL_FILE'); ?></label>
                                </div>
                                <div class="controls">
                                    <input type="file" name="jform[excel]" id="jform_excel" accept="application/vnd.ms-excel" size="102400" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div> 

            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
