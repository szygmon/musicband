<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted Access');

$document = JFactory::getDocument();
$document->addStyleSheet('../media/com_musicband/css/jquery.dataTables.css');
$document->addScript('../media/com_musicband/js/jquery-1.10.2.min.js');
$document->addScript('../media/com_musicband/js/jquery.dataTables.js');

JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

if (!empty($this->sidebar)) :
    ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php else : ?>
        <div id="j-main-container">
        <?php endif; ?>
        <form action="<?php echo JRoute::_('index.php?option=com_musicband&view=contract'); ?>" method="post" name="adminForm" id="adminForm">   
            <table id="musicband-list" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th style="width: 1%; align: center"><?php echo JHtml::_('grid.checkall'); ?></th>
                        <th style="width: 50%;"><?php echo JText::_('COM_MUSICBAND_CONTRACT_TITLE'); ?></th>
                        <th style="width: 49%;"><?php echo JText::_('COM_MUSICBAND_CONTRACT_LINK'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->contracts as $i => $row) :
                        $link = JRoute::_('index.php?option=com_musicband&task=contract.edit&id=' . $row->id);
                        ?>
                        <tr>
                            <td class="nowrap center"><?php echo JHtml::_('grid.id', $i, $row->id); ?></td>
                            <td><a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MUSICBAND_EDIT'); ?>"><?php echo $row->title; ?></a></td>
                            <td><a href="<?php echo JURI::root().'index.php?option=com_musicband&amp;view=contract&amp;id='.$row->id; ?>"><?php echo JURI::root().'index.php?option=com_musicband&amp;view=contract&amp;id='.$row->id; ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>

    <script type="text/javascript">
        var table = $('#musicband-list').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0] // wyłączenie sortowania dla tych kolumn
                }]
        });
        table.fnSort([[1, 'asc']]); // sortowanie wg daty
        $('#toolbar button:eq(3)').attr('onClick', null).off('click');
        $('#toolbar button:eq(3)').click(function () {
            if (confirm('<?php echo JText::_('COM_MUSICBAND_CONFIRM_DELETE_OLD'); ?>')) {
                Joomla.submitbutton('events.deleteold');
            }
        })
    </script>