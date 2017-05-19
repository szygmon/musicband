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
 * Widok dla listy imprez i listy wybranych przez klientów piosenek
 */
class MusicbandViewEvents extends JViewLegacy {

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

        $this->print = JRequest::getVar('print', false);

        $this->addToolbar();
        if (!$this->print) {
            MusicbandHelper::addSubmenu('events');
            $this->sidebar = JHtmlSidebar::render();
        }

        $app = JFactory::getApplication();
        $this->params = JComponentHelper::getParams('com_musicband');
        if ($app->input->get('layout', 'default') == 'list') {
            $this->event_info = $this->getModel()->getEventInfo(JRequest::getVar('id'));
            $this->rows = $this->getModel()->getSongs(JRequest::getVar('id'));
            $this->info = $this->getModel()->getInfo(JRequest::getVar('id'));
        } else {
            $this->rows = $this->get('Events');
            // Info o wymaganiach pliku
            if ($this->params->get('pass_text', NULL))
                $passInfo = $this->params->get('pass_text');
            else
                $passInfo = JText::_('COM_MUSICBAND_EVENTS_INFO');
            $app->enqueueMessage($passInfo, 'notice');
        }

        parent::display($tpl);
    }

    /**
     * Tytuł i przyciski na stronie
     * 
     * @return  void
     */
    protected function addToolbar() {
        // Tytuł strony
        JToolbarHelper::title(JText::_('COM_MUSICBAND') . ': ' . JText::_('COM_MUSICBAND_EVENTS'), 'stack article');

        // Przyciski
        if (JFactory::getApplication()->input->get('layout', 'default') == 'list') {
            JToolbarHelper::back();
            JToolbarHelper::apply('event.toprint', 'COM_MUSICBAND_PRINT');
        } else {
            JToolBarHelper::addNew('event.add');
            JToolBarHelper::editList('event.edit');
            JToolBarHelper::deleteList(JText::_('COM_MUSICBAND_CONFIRM_DELETE'), 'events.delete');
            JToolBarHelper::custom('events.deleteold', 'delete', '', JText::_('COM_MUSICBAND_DELETE_OLD'), false);
            JToolbarHelper::divider();
            JToolbarHelper::publishList('events.publish');
            JToolbarHelper::unpublishList('events.unpublish');
            //(JText::_('COM_MUSICBAND_CONFIRM_DELETE_OLD'), 'events.deleteold', JText::_('COM_MUSICBAND_DELETE_OLD'));
        }
        if (JFactory::getUser()->authorise('core.admin', 'com_musicband'))
            JToolbarHelper::preferences('com_musicband');
    }
}
