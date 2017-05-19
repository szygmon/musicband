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
 * Model dla ustalania repertuaru dla wydarzeń przez gości
 */
class MusicbandModelEvents extends JModelItem {

    /**
     * Metoda pobiera repertuar muzyczny zespołu
     * 
     * @return  array   Lista obiektów tabeli #__musicband
     * oraz pole category zaiwrające nazwę kategorii utworu
     */
    function getMusicband() {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
                ->select('#__musicband.*, #__categories.title as category')
                ->leftJoin('#__categories on catid=#__categories.id')
                ->from($db->quoteName('#__musicband'));

        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
    }

    /**
     * Metoda sprawdzająca poprawność formularza dla wyboru wydarzenia przez klienta
     * 
     * @param   date    $date   Data wydarzenia w formacie Y-m-d
     * @param   text    $pass   Hasło dla wydarzenia - opcjonalnie
     * 
     * @return  int     ID wydarzenia
     */
    function check($date, $pass = '') {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
                ->select('id')
                ->from($db->quoteName('#__musicband_events'))
                ->where('date = "' . $date . '" AND (pass = "' . $pass . '" OR pass = "NULL")');

        $db->setQuery($query);
        $result = $db->loadObject();

        return $result->id;
    }

    /**
     * Metoda pobierająca dane na temat wydarzenia
     * 
     * @return  Object  Obiekt zawierający pola tabeli #__musicband_events dla wybranego wydarzenia
     */
    function getEvent() {
        $id = JRequest::getVar('id', 0, '', 'INT');
        
        if ($id) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                    ->select('*')
                    ->from($db->quoteName('#__musicband_events'))
                    ->where('id = ' . $id);

            $db->setQuery($query);
            $result = $db->loadObject();

            return $result;
        }
        return NULL;
    }

    /**
     * Metoda dodająca utwór do tabeli #__musicband_songs_events w BD
     * 
     * @param   int     $songid     ID utworu
     * @param   int     $eventid    ID wydarzenia
     */
    function addSong($songid, $eventid) {
        $row = new stdClass();
        $row->songid = $songid;
        $row->eventid = $eventid;

        JFactory::getDbo()->insertObject('#__musicband_songs_events', $row);
    }

    /**
     * Metoda dodająca informacje/dedykazje/życzenia do tabeli #__musicband_info w BD
     * 
     * @param   int     $eventid    ID wydarzenia
     * @param   int     $info       Treść życzenia, dedykacji
     */
    function addInfo($eventid, $info) {
        $row = new stdClass();
        $row->eventid = $eventid;
        $row->info = $info;

        JFactory::getDbo()->insertObject('#__musicband_info', $row);
    }
}
