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
 * Widok dla edycji wydarzeń, imprez
 */
class MusicbandViewEvent extends JViewLegacy {

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
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->script = $this->get('Script');

        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Tytuł i przyciski na stronie
     * 
     * @return  void
     */
    protected function addToolbar() {
        $input = JFactory::getApplication()->input;

        // Wyłączanie menu
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

        if ($isNew) {
            $title = JText::_('COM_MUSICBAND_ADD_EVENT');
        } else {
            $title = JText::_('COM_MUSICBAND_EDIT_EVENT');
        }
        // Tytuł strony
        JToolbarHelper::title(JText::_('COM_MUSICBAND') . ': ' . $title, 'stack article');

        // Przyciski
        JToolBarHelper::save('event.save');
        JToolbarHelper::save2new('event.save2new');
        JToolBarHelper::cancel('event.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
}
