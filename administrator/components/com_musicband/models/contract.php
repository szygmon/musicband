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
class MusicbandModelContract extends JModelAdmin {
       /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    The table name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable  A JTable object
     *
     * @since   1.6
     */
    public function getTable($type = 'Contract', $prefix = 'MusicbandTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  mixed    A JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm(
                'com_musicband.contract', 'contract', array(
            'control' => 'jform',
            'load_data' => $loadData
                )
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @since   1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState(
                'com_musicband.edit.contract.data', array()
        );

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }
    
    
    public function getContracts() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__musicband_contract'));
        
        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
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
