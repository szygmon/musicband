<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2015 Szymon Michalewicz. All rights reserved.
 */

// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

/**
 * The musicband controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 */
class MusicbandControllerSong extends JControllerForm {
    
    function __construct($config = array()) {
        parent::__construct($config);
        // Zmiana widoku po zapisie/edycji utworu
        $this->view_list = 'musicband'; 
    }

    // Obsługa ładowania/usuwania pliku MP3
    public function save($key = null, $urlVar = null) {
        $songid = JRequest::getVar('id');
        $jform = JFactory::getApplication()->input->get('jform', array(), 'array');
        $deletefile = $jform['removemp3'];
        
        // Wywołanie rodzica
        parent::save($key, $urlVar);
        
        $this->getModel()->saveSong($songid, $deletefile);
    }
}
