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
 * Model for events
 */
class MusicbandModelEvents extends JModelLegacy {

    /**
     * Metoda pobierająca imprezy z BD
     * 
     * @return  array   Tablica obiektów tabeli #__musicband i pole songs zawierające 
     * ilość utworów dla wydarzenia z tabeli #__musicband_songs_events 
     * oraz pole info zawierające ilość informacji od klientów z tabeli #__musicband_info
     */
    public function getEvents() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('#__musicband_events.*, COUNT(#__musicband_songs_events.songid) as songs, COUNT(#__musicband_events_info.eventid) as info')
                ->leftJoin('#__musicband_songs_events on id=#__musicband_songs_events.eventid')
                ->leftJoin('#__musicband_events_info on id=#__musicband_events_info.eventid')
                ->from($db->quoteName('#__musicband_events'))
                ->group('id');

        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
    }

    /**
     * Metoda pobierająca utwory dla danej imprezy
     * 
     * @param   int     $event      ID wydarzenia
     * 
     * @return  array   Tablica obiektów tabeli #__musicband oraz pole count, 
     * zawierające ilość wystąpienia danego utworu - popularność,
     * name - nazwę wydarzenia i date - datę wydarzenia
     */
    public function getSongs($event) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('#__musicband_repertoire.*, COUNT(#__musicband_songs_events.songid) as count, #__categories.title as category')
                ->leftJoin('#__musicband_songs_events on id=#__musicband_songs_events.songid')
                ->leftJoin('#__categories on catid=#__categories.id')
                ->from($db->quoteName('#__musicband_repertoire'))
                ->where('#__musicband_songs_events.eventid=' . $event)
                ->group('id')
                ->order('count DESC');

        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
    }

    /**
     * Metoda zwracająca informacje: datę i nazwę wydarzenia
     * 
     * @param   int     $id     ID wydarzenia
     * 
     * @return  object  Obekt tabeli #__musicband_events
     */
    public function getEventInfo($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('name, date')
                ->from($db->quoteName('#__musicband_events'))
                ->where('id=' . $id);

        $db->setQuery($query);
        $result = $db->loadObject();

        return $result;
    }

    /**
     * Metoda usuwająca utwory, wybrane przez klientów dla usuwanego wydarzenia
     * 
     * @param   array   $id     Tablica ID usuwanych imprez
     */
    public function deleteEvents($id) {
        $idq = implode($id, ',');
        $db = JFactory::getDBO();

        $query = $db->getQuery(true)
                ->delete($db->quoteName('#__musicband_songs_events'))
                ->where('eventid IN (' . $idq . ')');

        $db->setQuery($query);
        $db->execute();
    }

    /**
     * Metoda usuwająca z BD wydarzenia które już minęły i wszystkie powiązane wpisy
     */
    public function deleteOldEvents() {
        $db = JFactory::getDBO();

        // Wyszukiwanie starych wydarzeń
        $query = $db->getQuery(true)
                ->select('id')
                ->from($db->quoteName('#__musicband_events'))
                ->where('date < "' . date('Y-m-d') . '"');
        $db->setQuery($query);
        $result = $db->loadObjectList();

        $array = array();
        foreach ($result as $event) {
            $array[] = $event->id;
        }

        if ($array[0]) {
            $idq = implode($array, ',');

            // Usuwanie piosenek dla starych wydarzen
            $query = $db->getQuery(true)
                    ->delete($db->quoteName('#__musicband_songs_events'))
                    ->where('eventid IN (' . $idq . ')');

            $db->setQuery($query);
            $db->execute();

            // Usuwanie informacji/życzeń dla starych wydarzen
            $query = $db->getQuery(true)
                    ->delete($db->quoteName('#__musicband_events_info'))
                    ->where('eventid IN (' . $idq . ')');

            $db->setQuery($query);
            $db->execute();
        }

        // Usuwanie wydarzeń
        $query = $db->getQuery(true)
                ->delete($db->quoteName('#__musicband_events'))
                ->where('date < "' . date('Y-m-d') . '"');

        $db->setQuery($query);
        $db->execute();
    }

    /**
     * Metoda pobierająca informacje przesłane przez klientów dla wydarzenia
     * 
     * @param   int     $id     ID wydarzenia
     * 
     * @return  array   Tablica z informacjami od klientów
     */
    public function getInfo($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('info')
                ->from($db->quoteName('#__musicband_events_info'))
                ->where('eventid=' . $id);

        $db->setQuery($query);
        $result = $db->loadRowList();

        return $result;
    }

    public function publishCalendar($cid) {
        $db = JFactory::getDbo();
        $query1 = $db->getQuery(true)
                ->select('#__musicband_events.*')
                ->from($db->quoteName('#__musicband_events'))
                ->where('id=' . $cid);

        $db->setQuery($query1);
        $event = $db->loadObject();
        
        $query2 = $db->getQuery(true)
                ->select('#__musicband_fields.*, #__musicband_fields_values.*')
                ->leftJoin('#__musicband_fields_values on id=#__musicband_fields_values.field_id')
                ->from($db->quoteName('#__musicband_fields'))
                ->where('#__musicband_fields.published=1 AND #__musicband_fields_values.item_id=' . $cid);
        $db->setQuery($query2);
        $fields = $db->loadObjectList();
        
        $description = '';
        
        foreach ($fields as $field) {
            $description .= $field->label.': '.$field->value."\n";
        }
        
        $params = JComponentHelper::getParams('com_musicband');
        
        require_once JPATH_ROOT . '/media/com_musicband/google-calendar/vendor/autoload.php';
        $client = new Google_Client();
        $client->setClientId($params->get('gclientid'));
        $client->setClientSecret($params->get('gclientsecret')); 
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessToken(JFactory::getSession()->get('google_access_token'));
        $service = new Google_Service_Calendar($client);
        
        $gevent = new Google_Service_Calendar_Event(array(
            'summary' => $event->name,
            'location' => $event->location,
            'description' => $description,
            'start' => array(
                'date' => $event->date,
            ),
            'end' => array(
                'date' => $event->date,
            ),
        ));
        
        return $service->events->insert($params->get('gcalendarid'), $gevent);

        //return $result;
    }

}
