<?php
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleSheet('/media/system/css/calendar-jos.css');
$document->addScript('/media/system/js/calendar.js');
$document->addScript('/media/system/js/calendar-setup.js');
JHtml::_('jquery.framework');

if ($this->params->get('show_page_heading', 1)) : ?>
    <h2> <?php echo $this->escape($this->params->get('page_title')); ?> </h2>
<?php endif; ?>
<form action="<?php echo JRoute::_('index.php?option=com_musicband&view=events&layout=mylist'); ?>" method="post" name="Form">

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_date-lbl" for="date" class="required" title="">
<?php echo JText::_('COM_MUSICBAND_EVENT_DATE'); ?></label>
                </div>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" title="" name="date" id="jform_date" value="<?php echo date('Y-m-d'); ?>" maxlength="45" class="required" aria-required="true">
                        <button type="button" class="btn" id="jform_date_img"><span class="icon-calendar"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <div class="control-label">
                    <label id="jform_pass-lbl" for="pass" title="">
<?php echo JText::_('JGLOBAL_PASSWORD'); ?>:</label>
                </div>
                <div class="controls">
                    <input type="text" name="pass" id="pass" value="" class="inputbox" size="50">
                </div>
            </div>
        </div>
    </div>


    <input type="submit" name="step2" value="<?php echo JText::_('COM_MUSICBAND_NEXT'); ?>" class="btn btn-primary" />
    <input type="hidden" name="task" value="events.check" />
</form>

<script type="text/javascript">
    Calendar._DN = ["Niedziela", "Poniedzia\u0142ek", "Wtorek", "\u015aroda", "Czwartek", "Pi\u0105tek", "Sobota", "Niedziela"];
    Calendar._SDN = ["N", "Pn", "Wt", "\u015ar", "Cz", "Pt", "So", "N"];
    Calendar._FD = 0;
    Calendar._MN = ["stycze\u0144", "luty", "marzec", "kwiecie\u0144", "maj", "czerwiec", "lipiec", "sierpie\u0144", "wrzesie\u0144", "pa\u017adziernik", "listopad", "grudzie\u0144"];
    Calendar._SMN = ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Pa\u017a", "Lis", "Gru"];
    Calendar._TT = {"INFO": "O kalendarzu", "ABOUT": "DHTML Date\/Time Selector\n(c) dynarch.com 2002-2005 \/ Author: Mihai Bazon\nFor latest version visit: http:\/\/www.dynarch.com\/projects\/calendar\/\nDistributed under GNU LGPL.  See http:\/\/gnu.org\/licenses\/lgpl.html for details.\n\nWyb\u00f3r daty:\n- U\u017cyj strza\u0142ek &#171; i &#187;, aby wybra\u0107 rok\n- U\u017cyj przycisk\u00f3w &lt; i &gt; aby wskaza\u0107 miesi\u0105c\n- Przytrzymaj przycisk myszki na dowolnym z powy\u017cszych przycisk\u00f3w, aby zaznaczy\u0107 szybciej.", "ABOUT_TIME": "\n\nTime selection:\n- Click on any of the time parts to increase it\n- or Shift-click to decrease it\n- or click and drag for faster selection.", "PREV_YEAR": "Przyci\u015bnij, by przej\u015b\u0107 do poprzedniego roku. Przyci\u015bnij i przytrzymaj, by przej\u015b\u0107 do listy lat.", "PREV_MONTH": "Przyci\u015bnij, by przej\u015b\u0107 do poprzedniego miesi\u0105ca. Przyci\u015bnij i przytrzymaj, by przej\u015b\u0107 do listy miesi\u0119cy.", "GO_TODAY": "Przejd\u017a do dzi\u015b", "NEXT_MONTH": "Przyci\u015bnij, by przej\u015b\u0107 do nast\u0119pnego miesi\u0105ca. Przyci\u015bnij i przytrzymaj, by przej\u015b\u0107 do listy miesi\u0119cy.", "SEL_DATE": "Wska\u017c dat\u0119.", "DRAG_TO_MOVE": "Przyci\u015bnij i przeci\u0105gnij, by przesun\u0105\u0107", "PART_TODAY": " Dzi\u015b ", "DAY_FIRST": "Najpierw %s", "WEEKEND": "0,6", "CLOSE": "Zamknij", "TODAY": "Dzi\u015b", "TIME_PART": "[Shift] + przyci\u015bnij lub przeci\u0105gnij, by zmieni\u0107 warto\u015b\u0107.", "DEF_DATE_FORMAT": "%Y-%m-%d", "TT_DATE_FORMAT": "%a, %b %e", "WK": "tydz.", "TIME": "Czas:"};
    jQuery(document).ready(function () {
        Calendar.setup({
            // Id of the input field
            inputField: "jform_date",
            // Format of the input field
            ifFormat: "%Y-%m-%d",
            // Trigger for the calendar (button ID)
            button: "jform_date_img",
            // Alignment (defaults to "Bl")
            align: "Bl",
            singleClick: true,
            firstDay: 1
        });
    });
</script>