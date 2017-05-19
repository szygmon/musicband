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
 * Model for musicband
 */
class MusicbandModelMusicband extends JModelList {
    
    /**
     * Metoda zwracająca listę utworów w repertuarze zespołu
     * 
     * @return  array   Tablica obiektów tabeli #__musicband
     * oraz pole category zawierającę nazwę kategorii utworu
     */
    public function getMusicband() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('#__musicband_repertoire.*, #__categories.title as category')
                ->leftJoin('#__categories on catid=#__categories.id')
                ->from($db->quoteName('#__musicband_repertoire'));
        
        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
    }
}
