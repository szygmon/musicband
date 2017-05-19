<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');
?>
<form action="<?php echo JRoute::_('index.php?option=com_musicband&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!$this->item->demo_audio): ?>
                        <script type="text/javascript">
                            jQuery("div.control-group:eq(5)").hide();
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="song.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
