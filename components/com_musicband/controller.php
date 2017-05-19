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
 * Musicband Component Controller
 */
class MusicbandController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached.
     * @param   boolean  $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController  This object to support chaining.
     *
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = false) {
        
        // Zabezpieczenie przed niepowołanym dostępem - sesja
        if ($this->input->get('layout', 'default') == 'mylist') {
            $getSession = JFactory::getSession();
            $session = $getSession->get('musicband_for_event');

            if (empty($session) || $session == 0 || $session != JRequest::getVar('id')) {
                $getSession->clear('musicband_for_event');
                $this->setRedirect('index.php?option=com_musicband&view=events', JText::_('COM_MUSICBAND_EVENTS_SESSION_ERROR'), 'error');
            }
        }

        parent::display();

        return $this;
    }
}
