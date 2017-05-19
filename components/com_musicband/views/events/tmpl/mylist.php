<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleSheet('media/com_musicband/css/jquery.dataTables.css');
$document->addScript('media/com_musicband/js/jquery-1.10.2.min.js');
$document->addScript('media/com_musicband/js/jquery.dataTables.js');

$span = ($this->params->get('show_demo_audio', 1) && $this->params->get('show_demo_video', 1)) ? 'rowspan="2"' : '';
?>
<div class="row-fluid">
    <div class="span4"><h2><?php echo JText::_('COM_MUSICBAND_EVENT_NAME'); ?></h2></div>
    <div class="span8"><h2><?php echo $this->event->name; ?></h2></div>
</div>
<div class="row-fluid">
    <div class="span4"><h3><?php echo JText::_('COM_MUSICBAND_EVENT_DATE'); ?></h3></div>
    <div class="span8"><h3><?php echo $this->event->date; ?></h3></div>
</div>
<div class="row-fluid center"><h4>Dostępny repertuar</h4></div>
<form action="<?php echo JRoute::_('index.php?option=com_musicband&view=events'); ?>" method="post" name="Form">
    <div class="row-fluid">
        <table id="musicband-list"  class="table table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th <?php echo $span; ?> ></th>
                    <th <?php echo $span; ?> ><?php echo JText::_('COM_MUSICBAND_TITLE'); ?></th>
                    <th <?php echo $span; ?> ><?php echo JText::_('COM_MUSICBAND_ARTIST'); ?></th>
                    <?php if ($this->params->get('show_language', 1)): ?>
                        <th <?php echo $span; ?> ><?php echo JText::_('COM_MUSICBAND_LANGUAGE'); ?></th>
                        <?php
                    endif;
                    if ($this->params->get('show_category', 1)):
                        ?>
                        <th <?php echo $span; ?> ><?php echo JText::_('COM_MUSICBAND_CATEGORY'); ?></th>
                        <?php
                    endif;
                    if ($this->params->get('show_demo_audio', 1) || $this->params->get('show_demo_video', 1)):
                        ?>
                        <th <?php if ($this->params->get('show_demo_audio', 1) && $this->params->get('show_demo_video', 1)): ?> colspan="2" <?php endif; ?> class="center"><?php echo JText::_('COM_MUSICBAND_DEMO'); ?></th>
                    <?php endif; ?>
                </tr>
                <?php if ($this->params->get('show_demo_audio', 1) && $this->params->get('show_demo_video', 1)): ?>
                    <tr>
                        <th class="center"><?php echo JText::_('COM_MUSICBAND_DEMO_AUDIO'); ?></th>
                        <th class="center"><?php echo JText::_('COM_MUSICBAND_DEMO_VIDEO'); ?></th>
                    </tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php
                foreach ($this->rows as $i => $row) :
                    $search = $row->title . '+' . $row->artist;
                    $ytlink = 'https://www.youtube.com/results?search_query=' . str_replace(' ', '+', $search);
                    ?>
                    <tr>
                        <td class="center"><?php echo JHtml::_('grid.id', $i, $row->id); ?></td>
                        <td>
                            <?php if ($this->params->get('show_news', 1) && date("Y-m-d", strtotime("-" . $this->params->get('news', 3) . " months")) < $row->date): ?>
                                <img src="media/com_musicband/images/new.png" alt="<?php echo JText::_('COM_MUSICBAND_NEW'); ?>" />
                            <?php endif; ?>
                            <a href="<?php echo $ytlink; ?>" target="_blank"><?php echo $row->title; ?></a>
                        </td>
                        <td><?php echo $row->artist; ?></td>
                        <?php if ($this->params->get('show_language', 1)): ?>
                            <td><?php echo $row->language; ?></td>
                            <?php
                        endif;
                        if ($this->params->get('show_category', 1)):
                            ?>
                            <td><?php echo $row->category; ?></td>
                            <?php
                        endif;
                        if ($this->params->get('show_demo_audio', 1) || $this->params->get('show_demo_video', 1)):
                            ?>
                            <?php if ($this->params->get('show_demo_audio', 1)): ?>
                                <td>
                                    <?php if ($row->demo_audio): ?>
                                        <object type="application/x-shockwave-flash" data="plugins/content/josdewplayer/dewplayer.swf" width="200" height="20" id="dewplayer" name="dewplayer">
                                            <param name="wmode" value="transparent">
                                            <param name="movie" value="plugins/content/josdewplayer/dewplayer.swf">
                                            <param name="flashvars" value="mp3=images/demomp3/<?php echo $row->demo_audio; ?>&amp;autostart=0&amp;autoreplay=0&amp;showtime=1">
                                        </object>
                                    <?php endif ?>
                                </td>
                            <?php endif; ?>
                            <?php if ($this->params->get('show_demo_video', 1)): ?>
                                <td class="center" style="padding: 7px;">
                                    <?php if ($row->demo_video): ?>
                                        <a href="<?php echo $row->demo_video; ?>" target="_blank"><img src="media/com_musicband/images/yt.png" alt="<?php echo JText::_('COM_MUSICBAND_DEMO_VIDEO'); ?>" /></a>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="height-10"></div>
    <div class="row-fluid center">
        <h4><?php echo JText::_('COM_MUSICBAND_ADDITIONAL_INFO'); ?></h4>
    </div>
    <div class="row-fluid">
        <textarea name="info" style="width: 100%; height: 100px;"></textarea>
    </div>
    <div class="height-10"></div>
    <div class="row-fluid">
        <input type="submit" name="save" id="send_musicband" value="<?php echo JText::_('COM_MUSICBAND_SEND_MUSICBAND'); ?>" class="btn btn-primary" />
        <input type="hidden" name="eventid" value="<?php echo JRequest::getVar('id'); ?>" />
        <input type="hidden" name="task" value="events.add" />
    </div>
</form>
<script type="text/javascript">
    var table = $('#musicband-list').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0] // wyłączenie sortowania dla tych kolumn
            }]
    });
    table.fnSort([[1, 'asc']]); // sortowanie wg tytułu

    // reset szukajki przy wysyłaniu - zapobiega błędom
    $('#send_musicband').click(function () {
        table.fnFilter('');
    });
</script>
