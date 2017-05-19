<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h2> <?php echo $this->escape($this->params->get('page_title')); ?> </h2>
    <?php
endif;
?>
<form action="components/com_musicband/generate-pdf.php" method="post" name="adminForm" id="adminForm">    
    <input type="hidden" name="contract" value="<?php echo $this->contract; ?>" />
    <div class="control-group">
        <div class="controls">
            <input type="submit" name="send" value="Pobierz umowę" />
        </div>
    </div>
</form>

