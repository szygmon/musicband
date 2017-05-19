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
 * Model for editing songs
 */
class MusicbandModelSong extends JModelAdmin {

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
    public function getTable($type = 'Musicband', $prefix = 'MusicbandTable', $config = array()) {
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
                'com_musicband.song', 'song', array(
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
                'com_musicband.edit.song.data', array()
        );

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Metoda do zapisu piosenki w repertuarze
     * 
     * @param   int     $songid     ID utworu (0 dla nowo dodawanego)
     * @param   bool    $deletefile UWAGA! 1 - dla pozostawienia pliku, 0 - dla usunięcia pliku z serwera
     */
    public function saveSong($songid, $deletefile = 1) {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $jform = JFactory::getApplication()->input->files->get('jform');

        // Nazwa pliku - małe znaki, usuwanie polskich znaków i spacji, bezpieczna nazwa
        $filename = strtolower($jform['mp3']['name']);
        $filename = str_replace(
                array('ę', 'ó', 'ą', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń', ' '), array('e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n', ''), $filename);
        $filename = JFile::makeSafe($filename);

        $folder = JPATH_SITE . "/" . "images" . "/" . "demomp3";

        // Tworzenie katalogu jeśli nie istnieje
        if (!JFolder::exists($folder)) {
            JFolder::create($folder, 0777);
        }

        $src = $jform['mp3']['tmp_name'];
        $dest = $folder . "/" . $filename;

        $db = JFactory::getDbo();

        // Jeśli nie ma błędu przesyłania
        if ($jform['mp3']['error'] == 0) {
            JFile::upload($src, $dest);

            // Jeśli utwór jest nowy - szukanie ostatnio dodanego id utworu
            if ($songid == 0) {
                $query = $db->getQuery(true)
                        ->select('id')
                        ->from($db->quoteName('#__musicband_repertoire'))
                        ->order('id DESC')
                        ->setLimit(1);

                $db->setQuery($query);
                $result = $db->loadRow();

                $songid = $result[0];
            } else { 
                // Usuwanie poprzedniego utworu z serwera jeśli jest
                $query = $db->getQuery(true)
                    ->select('demo_audio')
                    ->from($db->quoteName('#__musicband_repertoire'))
                    ->where('id=' . $songid);

                $db->setQuery($query);
                $result = $db->loadRow();
                
                if ($result[0] != NULL) {
                    JFile::delete($folder . "/" . $result[0]);
                }
            }
            
            // Dodanie ścieżki do MP3 na serwerze
            $query = $db->getQuery(true)
                    ->update($db->quoteName('#__musicband_repertoire'))
                    ->set('demo_audio = "' . $filename . '"')
                    ->where('id=' . $songid);

            $db->setQuery($query);
            $db->execute();
        }
        
        // Usuwanie mp3 - UWAGA! Dla 0 usuwamy! Trik zastosowany dla kolorowania przycisku Usuń (Tak) na czerwono w Joomla
        if ($deletefile == 0) {
            $query = $db->getQuery(true)
                    ->select('demo_audio')
                    ->from($db->quoteName('#__musicband_repertoire'))
                    ->where('id=' . $songid)
                    ->setLimit(1);

            $db->setQuery($query);
            $result = $db->loadRow();

            // Usuwanie pliku z serwera
            JFile::delete($folder . "/" . $result[0]);

            // Usuwanie wpisu w BD
            $query = $db->getQuery(true)
                    ->update($db->quoteName('#__musicband_repertoire'))
                    ->set('demo_audio = NULL')
                    ->where('id=' . $songid);

            $db->setQuery($query);
            $db->execute();
        }
    }

    /**
     * Metoda usuwająca pliki usuwanych utworów z bazy danych
     * 
     * @param   array   $id     ID utworów do usunięcia
     */
    public function deleteSongs($id) {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $folder = JPATH_SITE . "/" . "images" . "/" . "demomp3";

        $idq = implode($id, ',');
        $db = JFactory::getDBO();

        // Tabela #__musicband
        $query = $db->getQuery(true)
                ->select('demo_audio')
                ->from($db->quoteName('#__musicband_repertoire'))
                ->where('id IN (' . $idq . ') AND demo_audio != ""');
        
        $db->setQuery($query);
        $result = $db->loadRowList();

        // Usuwanie plików z serwera
        foreach ($result as $row) {
            JFile::delete($folder . "/" . $row[0]);
        }

        // Tabela #__musicband_songs_events
        $query = $db->getQuery(true)
                ->delete($db->quoteName('#__musicband_songs_events'))
                ->where('songid IN (' . $idq . ')');
        
        $db->setQuery($query);
        $db->execute();
    }
}
