<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2015 Szymon Michalewicz. All rights reserved.
 */
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

class MusicbandViewContract extends JViewLegacy {

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise a Error object.
     */
    public function display($tpl = null) {
        $this->item = null;

        $app = JFactory::getApplication();
        $this->params = $app->getParams();

        $this->item = $this->get('Item');
        $this->fields = $this->get('Fields');
        //var_dump($this->fields);

        if (JFactory::getApplication()->input->get('layout', 'default') == 'pdf') {
            $this->contract = $this->getModel()->generatePdf();
        }

        // Tytuł strony + przyrostek witryny
        $title = $this->params->get('page_title');
        if (empty($title)) {
            $title = $app->get('sitename');
        } elseif ($app->get('sitename_pagetitles', 0) == 1 && $app->get('sitename') != $title) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } elseif ($app->get('sitename_pagetitles', 0) == 2 && $app->get('sitename') != $title) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        $this->document->setTitle($title);

        if ($app->input->get('layout', 'default') == 'default') {
            if ($this->params->get('personal_data_show', 0))
                $app->enqueueMessage($this->params->get('perdonal_data_text'), 'notice');
        }

        parent::display($tpl);
    }

}
