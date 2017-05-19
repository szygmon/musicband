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
        <form action="<?php echo JRoute::_('index.php?option=com_musicband'); ?>" method="post" name="adminForm" id="adminForm">   
            <table id="musicband-list" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 1%; text-align: center"><?php echo JHtml::_('grid.checkall'); ?></th>
                        <th rowspan="2" style="width: 34%"><?php echo JText::_('COM_MUSICBAND_TITLE'); ?></th>
                        <th rowspan="2" style="width: 20%"><?php echo JText::_('COM_MUSICBAND_ARTIST'); ?></th>
                        <th rowspan="2" style="width: 5%"><?php echo JText::_('COM_MUSICBAND_LANGUAGE'); ?></th>
                        <th rowspan="2" style="width: 15%"><?php echo JText::_('COM_MUSICBAND_CATEGORY'); ?></th>
                        <th colspan="2" class="center"><?php echo JText::_('COM_MUSICBAND_DEMO'); ?></th>
                    </tr>
                    <tr>
                        <th class="center" style="width: 20%"><?php echo JText::_('COM_MUSICBAND_DEMO_AUDIO'); ?></th>
                        <th class="center" style="width: 5%"><?php echo JText::_('COM_MUSICBAND_DEMO_VIDEO'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->rows as $i => $row) :
                        $link = JRoute::_('index.php?option=com_musicband&task=song.edit&id=' . $row->id);
                        ?>
                        <tr>
                            <td class="nowrap center hidden-phone"><?php echo JHtml::_('grid.id', $i, $row->id); ?></td>
                            <td><a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MUSICBAND_EDIT'); ?>"><?php echo $row->title; ?></a></td>
                            <td><a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MUSICBAND_EDIT'); ?>"><?php echo $row->artist; ?></a></td>
                            <td><a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MUSICBAND_EDIT'); ?>"><?php echo $row->language; ?></a></td>
                            <td><a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MUSICBAND_EDIT'); ?>"><?php echo $row->category; ?></a></td>
                            <td>
                                <?php if ($row->demo_audio): ?>
                                    <object type="application/x-shockwave-flash" data="../plugins/content/josdewplayer/dewplayer.swf" width="200" height="20" id="dewplayer" name="dewplayer">
                                        <param name="wmode" value="transparent">
                                        <param name="movie" value="../plugins/content/josdewplayer/dewplayer.swf">
                                        <param name="flashvars" value="mp3=../images/demomp3/<?php echo $row->demo_audio; ?>&amp;autostart=0&amp;autoreplay=0&amp;showtime=1">
                                    </object>
                                <?php endif ?>
                            </td>
                            <td class="center" style="padding: 7px;">
                                <?php if ($row->demo_video): ?>
                                    <a href="<?php echo $row->demo_video; ?>" target="_blank"><img src="../media/com_musicband/images/yt.png" alt="<?php echo JText::_('COM_MUSICBAND_DEMO_VIDEO'); ?>" /></a>
                                <?php endif ?>
                            </td>
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
        table.fnSort([[1, 'asc']]); // sortowanie wg tytułu
    </script>
