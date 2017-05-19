<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2015 Szymon Michalewicz. All rights reserved.
 */

// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die;

/**
 * Musicband component helper.
 */
abstract class MusicbandHelper {
    
    // Sidebar
    public static function addSubmenu($vName) {
        JHtmlSidebar::addEntry(
                JText::_('COM_MUSICBAND_LIST'), 'index.php?option=com_musicband', $vName == 'list'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_MUSICBAND_CATEGORIES'), 'index.php?option=com_categories&view=categories&extension=com_musicband', $vName == 'categories'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_MUSICBAND_EVENTS'), 'index.php?option=com_musicband&view=events', $vName == 'events'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_MUSICBAND_IMPORT'), 'index.php?option=com_musicband&view=import', $vName == 'import'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_MUSICBAND_CONTRACT'), 'index.php?option=com_musicband&view=contract', $vName == 'contract'
        );
        JHtmlSidebar::addEntry(
                JText::_('COM_MUSICBAND_CUSTOM_FIELDS'), 'index.php?option=com_musicband&view=fields', $vName == 'fields'
        );
    }
}
