<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2015 Szymon Michalewicz. All rights reserved.
 */

// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

/**
 * Widok dla wybiarania utworów na imprezę przez gości
 */
class MusicbandViewEvents extends JViewLegacy {

    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise a Error object.
     */
    public function display($tpl = null) {
        if ($this->getLayout() == "mylist") 
            $this->rows = $this->get('Musicband');

        $app = JFactory::getApplication();
        $this->params = $app->getParams();

        if ($app->input->get('layout', 'default') == 'default') {
            if ($this->params->get('pass_text', NULL))
                $passInfo = $this->params->get('pass_text');
            else
                $passInfo = JText::_('COM_MUSICBAND_EVENTS_INFO');
            $app->enqueueMessage($passInfo, 'notice');
        } else {
            $this->event = $this->get('Event');
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

        parent::display($tpl);
    }
}
