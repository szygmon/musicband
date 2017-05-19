<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted Access');

$document = JFactory::getDocument();
$document->addStyleSheet('../media/com_musicband/css/jquery.dataTables.css');
$document->addScript('../media/com_musicband/js/jquery-1.10.2.min.js');
$document->addScript('../media/com_musicband/js/jquery.dataTables.js');

if (!empty($this->sidebar)) :
    ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php else : ?>
        <div id="j-main-container">
        <?php endif; ?>

        <h2><?php echo $this->event_info->date . ': ' . $this->event_info->name; ?></h2>
        <form action="<?php echo JRoute::_('index.php?option=com_musicband&view=events'); ?>" method="post" name="adminForm" id="adminForm">   
            <div class="row-fluid">
                <table id="musicband-list" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th style="width: 1%"><?php echo JText::_('COM_MUSICBAND_COUNT'); ?></th>
                            <th style="width: 44%"><?php echo JText::_('COM_MUSICBAND_TITLE'); ?></th>
                            <th style="width: 30%"><?php echo JText::_('COM_MUSICBAND_ARTIST'); ?></th>
                            <th style="width: 5%"><?php echo JText::_('COM_MUSICBAND_LANGUAGE'); ?></th>
                            <th style="width: 20%"><?php echo JText::_('COM_MUSICBAND_CATEGORY'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->rows as $row) :
                            $link = JRoute::_('index.php?option=com_musicband&task=song.edit&id=' . $row->id);
                            ?>
                            <tr>
                                <td><?php echo $row->count; ?></td>
                                <td><?php echo $row->title; ?></td>
                                <td><?php echo $row->artist; ?></td>
                                <td><?php echo $row->language; ?></td>
                                <td><?php echo $row->category; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>" />
            <?php echo JHtml::_('form.token'); ?>
            <?php if ($this->info): ?>
                <h2><?php echo JText::_('COM_MUSICBAND_ADDITIONAL_INFO'); ?></h2>
                <div class="row-fluid">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><?php echo JText::_('COM_MUSICBAND_ID'); ?></td>
                                <td><?php echo JText::_('COM_MUSICBAND_INFO_CONTENT'); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; count($this->info) > $i; $i++): ?>
                                <tr>
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo nl2br($this->info[$i][0]); ?></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script type="text/javascript">
        var table = $('#musicband-list').dataTable({
            "bPaginate": false, 
            "bLengthChange": false, 
            "bFilter": <?php echo $this->print ? 'false' : 'true'; ?>,
            "bSort": true,
            "bInfo": <?php echo $this->print ? 'false' : 'true'; ?>,
            "bAutoWidth": false
        });
        table.fnSort([[0, 'desc']]); // sortowanie wg tytułu
    </script>