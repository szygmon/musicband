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
class MusicbandModelContract extends JModelItem {

    /**
     * Metoda pobiera repertuar muzyczny zespołu
     * 
     * @return  array   Lista obiektów tabeli #__musicband
     * oraz pole category zaiwrające nazwę kategorii utworu
     */
    public function getItem() {
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->get('id');
        if (!isset($id) || $id == null || $id == 0)
            rerurn;

        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__musicband_contract'))
                ->where('id=' . $id);

        $db->setQuery($query);
        $result = $db->loadObject();

        return $result;
    }

    public function generatePdf() {
        $contract = $this->getItem();

        $jinput = JFactory::getApplication()->input;
        $form = $jinput->post->getArray();
        unset($form['send']);
        //var_dump($form);

        $event = $this->addEvent($form['name'], $form['date']);

        foreach ($form as $name => $value) {
            $contract->contract = str_replace('{' . $name . '}', $value, $contract->contract);
            //if ($field['required'] == 'true') {
              //  $f = new stdClass();
                //$f->name = 'nowe';
                //$f->date = '2017-01-01'; Dodanie pól do bazy

                //$result = JFactory::getDbo()->insertObject('#__musicband_events', $event);
            //}
        }




//var_dump($contract->contract); 
        return $contract->contract;
    }

    protected function addEvent($name, $date) {
        // Create and populate an object.
        $event = new stdClass();
        $event->name = $name;
        $event->date = $date;

        $result = JFactory::getDbo()->insertObject('#__musicband_events', $event);

        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('id')
                ->from($db->quoteName('#__musicband_events'))
                ->order($db->quoteName('id') . ' DESC');

        $db->setQuery($query);
        return $db->loadObject();
    }

    public function getFields() {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__musicband_fields'));

        $db->setQuery($query); 
        $result = $db->loadObjectList();

        return $result;
    }

}
