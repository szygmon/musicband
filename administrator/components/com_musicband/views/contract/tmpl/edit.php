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
        <form action="<?php echo JRoute::_('index.php?option=com_musicband&view=contract&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">   
            <div class="span10">
                <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
            </div>
            <div class="span2">
                <?php echo JText::_('COM_MUSICBAND_CONTRACT_FIELDS'); ?><br />
                <?php foreach ($this->fields as $field) : ?>
                    <?php echo $field->label; ?> - {<?php echo $field->name; ?>}<br />

                <?php endforeach;
                ?>
            </div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
