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
class MusicbandControllerImport extends JControllerForm {
    
    // Import z Excela
    public function import() {
        $result = $this->getModel()->importSongs();

        // Przekierowanie z odpowiednią wiadomością
        if ($result) {
            $this->setRedirect('index.php?option=com_musicband', JText::_('COM_MUSICBAND_IMPORT_SUCCESS'));
        } else {
            $this->setRedirect('index.php?option=com_musicband&view=import', JText::_('COM_MUSICBAND_IMPORT_ERROR'), 'error');
        }
    }
}
