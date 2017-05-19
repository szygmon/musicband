<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h2> <?php echo $this->escape($this->params->get('page_title')); ?> </h2>
    <?php
endif;
?>
<form action="<?php echo JRoute::_('index.php?option=com_musicband&view=contract&layout=pdf&id=' . (int) $this->item->id); ?>" method="post" name="Form">

    <div class="control-group">
        <div class="control-label">
            <label id="jform_name-lbl" class="hasPopover" title="Nazwa imprezy">Nazwa imprezy*</label>
        </div>
        <div class="controls">
            <input type="text" name="name" value="" size="50" />
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label id="jform_name-lbl" class="hasPopover" title="Data imprezy">Data imprezy*</label>
        </div>
        <div class="controls">
            <input type="text" name="date" value="" placeholder="rok-miesiąc-dzień" size="50" />
        </div>
    </div>

    <?php
    foreach ($this->fields as $field) {
//        var_dump($field);
        ?>
        <div class="control-group">
            <div class="control-label">
                <label id="jform_name-lbl" class="hasPopover" title="<?php echo $field->label; ?>">
                    <?php echo $field->label; ?></label>
            </div>
            <div class="controls">
                <input type="text" name="<?php echo $field->name; ?>" value="" size="50" />
            </div>
        </div>
    <?php }
    ?>

    <div class="control-group">
        <div class="controls">
            <input type="submit" name="send" value="Generuj umowę" />
        </div>
    </div>
</form>

