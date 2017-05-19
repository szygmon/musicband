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
 * Events class.
 */
class MusicbandControllerEvents extends JControllerForm {

    // Sprawdzanie poprawnego hasła i daty
    public function check() {
        $app = JFactory::getApplication();
        $postData = $app->input->post;

        $id = $this->getModel()->check($postData->get('date'), $postData->get('pass'));
        
        $session = JFactory::getSession();
        
        // Blokada kilkukrotnego wysyłania utworów
        $musicbandSended = $session->get('musicband_sended', array());
        //var_dump($musicbandSended); die();
        if (in_array($id, $musicbandSended)) {
            $this->setRedirect('index.php?option=com_musicband&view=events', JText::_('COM_MUSICBAND_EVENTS_CHECK_ERROR2'), 'error');
            return;
        }
        
        if ($id != NULL) {
            $session->set('musicband_for_event', $id);

            $this->setRedirect('index.php?option=com_musicband&view=events&layout=mylist&id=' . $id, JText::_('COM_MUSICBAND_EVENTS_YOUR_LIST'));
        } else {
            $this->setRedirect('index.php?option=com_musicband&view=events', JText::_('COM_MUSICBAND_EVENTS_CHECK_ERROR'), 'error');
        }
    }

    // Dodawanie utworów klienta do BD
    public function add() {
        $songs = JRequest::getVar('cid', array(), '', 'array');
        $session = JFactory::getSession();
        $event= $session->get('musicband_for_event');
        $info = JFactory::getApplication()->input->get('info', null, 'HTML');
        foreach ($songs as $song) {
            $this->getModel()->addSong($song, $event);
        }
        if ($info)
            $this->getModel()->addInfo($event, $info);

        // Dodanie blokady ponownego wybierania utworów
        $musicbandSended = $session->get('musicband_sended', array());
        $musicbandSended[] = $event;
        $session->set('musicband_sended', $musicbandSended);
        
        // Czyszczeie sesji po poprawnym dodaniu
        $session->clear('musicband_for_event');        

        $this->setRedirect('index.php?option=com_musicband', JText::_('COM_MUSICBAND_EVENTS_ADD_SUCCESS'));
    }
}
