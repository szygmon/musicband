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
class MusicbandControllerEvent extends JControllerForm {

    // Przekierowanie do widoku do druku
    public function toprint() {
        $id = JRequest::getVar('id');
        $this->setRedirect('index.php?option=com_musicband&view=events&layout=list&tmpl=component&print=1&id='.$id);
    }
}
