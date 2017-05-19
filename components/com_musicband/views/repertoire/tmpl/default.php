<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleSheet('media/com_musicband/css/jquery.dataTables.css');
$document->addScript('media/com_musicband/js/jquery-1.10.2.min.js');
$document->addScript('media/com_musicband/js/jquery.dataTables.js');
$document->addScript('media/com_musicband/js/dataTables-pagination.js');

$span = ($this->params->get('show_demo_audio', 1) && $this->params->get('show_demo_video', 1)) ? 'rowspan="2"' : '';
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h2> <?php echo $this->escape($this->params->get('page_title')); ?> </h2>
    <?php
endif;
if ($this->params->get('pre_text', NULL))
    echo $this->params->get('pre_text');
?>
<table id="repertoire-list" class="table table-bordered table-hover dataTable">
    <thead>
        <tr>
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
        foreach ($this->rows as $row) :
            $search = $row->title . '+' . $row->artist;
            $ytlink = 'https://www.youtube.com/results?search_query=' . str_replace(' ', '+', $search);
            ?>
            <tr>
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
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->params->get('show_demo_video', 1)): ?>
                        <td class="center" style="padding: 7px;">
                            <?php if ($row->demo_video): ?>
                                <a href="<?php echo $row->demo_video; ?>" target="_blank"><img src="media/com_musicband/images/yt.png" alt="<?php echo JText::_('COM_MUSICBAND_DEMO_VIDEO'); ?>" /></a>
                            <?php endif ?>
                        </td>
                    <?php endif ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $('#repertoire-list').dataTable({
        "sPaginationType": "repertoire",
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "iDisplayLength": <?php echo $this->params->get('positions', 100); ?>
    });
</script>

<?php
if ($this->params->get('post_text', NULL))
    echo $this->params->get('post_text');?>