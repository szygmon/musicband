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
 * Widok dla listy piosenek
 */
class MusicbandViewMusicband extends JViewLegacy {

    protected $form = null;

     /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise a Error object.
     *
     * @since   1.6
     */
    public function display($tpl = null) {
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));

            return false;
        }

        MusicbandHelper::addSubmenu('list');

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        $this->rows = $this->get('Musicband');

        parent::display($tpl);
    }

    /**
     * Tytuł i przyciski na stronie
     * 
     * @return  void
     */
    protected function addToolbar() {
        // Tytuł strony
        JToolbarHelper::title(JText::_('COM_MUSICBAND') . ': ' . JText::_('COM_MUSICBAND_LIST'), 'stack article');

        // Przyciski
        JToolBarHelper::addNew('song.add');
        JToolBarHelper::editList('song.edit');
        JToolBarHelper::deleteList(JText::_('COM_MUSICBAND_CONFIRM_DELETE'), 'songs.delete');
        if (JFactory::getUser()->authorise('core.admin', 'com_musicband'))
            JToolbarHelper::preferences('com_musicband');
    }
}
