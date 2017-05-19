<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2015 Szymon Michalewicz. All rights reserved.
 */

// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');
require_once 'components/com_musicband/excel_reader2.php';

/**
 * Model Musicband Import
 */
class MusicbandModelImport extends JModelLegacy {
    
    /**
     * Metoda do importu utworów z pliku Excel 97-2003
     * 
     * @return  bool    TRUE jeśli powodzenie, FALSE jeśli błąd
     */
    public function importSongs() {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        
        $jform = JFactory::getApplication()->input->files->get('jform');
        
        if ($jform['excel']['type'] != 'application/vnd.ms-excel') {
            return false;
        }
        
        $filename = strtolower($jform['excel']['name']);
        $filename = str_replace(
                array('ę', 'ó', 'ą', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń', ' '), array('e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n', ''), $filename);
        $filename = JFile::makeSafe($filename);
        
        $folder = JPATH_SITE . "/" . "images" . "/" . "demomp3";

        // Tworzenie folderu jeśli nie istnieje
        if (!JFolder::exists($folder)) {
            JFolder::create($folder, 0777);
        }

        $src = $jform['excel']['tmp_name'];
        $dest = $folder . "/" . $filename;

        $db = JFactory::getDbo();

        // Jeśli nie ma błędu przesłania pliku
        if ($jform['excel']['error'] == 0) {
            // Pobieranie kategorii
            $qc = $db->getQuery(true)
                    ->select('id, title')
                    ->from($db->quoteName('#__categories'))
                    ->where('extension="com_musicband"');
            $db->setQuery($qc);
            $categories = $db->loadObjectList();
                    
            JFile::upload($src, $dest);

            $data = new Spreadsheet_Excel_Reader($dest);

            // Czytanie pliku i wpisywanie do BD
            if (count($data->sheets[0][cells]) > 0) { // Sprawdzanie czy arkusz nie jest pusty
                for ($j = 1; $j <= count($data->sheets[0][cells]); $j++) {
                    // Create and populate an object.
                    $song = new stdClass();
                    $song->title = $data->sheets[0][cells][$j][1];
                    $song->artist = $data->sheets[0][cells][$j][2];
                    $song->language = $data->sheets[0][cells][$j][3];
                    foreach ($categories as $cat) {
                        if ($data->sheets[0][cells][$j][4] == $cat->title) {
                            $song->catid = $cat->id;
                            break;
                        }
                    }
                    $song->demo_video = $data->sheets[0][cells][$j][5];

                    $result = JFactory::getDbo()->insertObject('#__musicband', $song);
                }
            }
        } else {
            // Usuwanie pliku z serwera
            JFile::delete($dest);
            return false;
        }
        // Usuwanie pliku z serwera
        JFile::delete($dest);
        return true;
    }
}
