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
 * Widok dla importu utworów z programu Excel
 */
class MusicbandViewImport extends JViewLegacy {

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

        MusicbandHelper::addSubmenu('import');

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        // Info o wymaganiach pliku
        $application = JFactory::getApplication();
        $application->enqueueMessage(JText::_('COM_MUSICBAND_IMPORT_INFO'), 'notice');
        
        parent::display($tpl);
    }

    /**
     * Tytuł i przyciski na stronie
     * 
     * @return  void
     */
    protected function addToolbar() {
        // Tytuł strony
        JToolbarHelper::title(JText::_('COM_MUSICBAND') . ': ' . JText::_('COM_MUSICBAND_IMPORT'), 'stack article');

        // Przyciski
        JToolBarHelper::apply('import.import', JText::_('COM_MUSICBAND_IMPORT_NOW'));
        if (JFactory::getUser()->authorise('core.admin', 'com_musicband'))
            JToolbarHelper::preferences('com_musicband');
    }
}
