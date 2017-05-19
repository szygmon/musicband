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
 * Model dla listy utworów
 */
class MusicbandModelRepertoire extends JModelItem {
    
    /**
     * Metoda pobiera repertuar muzyczny zespołu
     * 
     * @return  array   Lista obiektów tabeli #__musicband
     * oraz pole category zaiwrające nazwę kategorii utworu
     */
    function getRepertoire() {
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
