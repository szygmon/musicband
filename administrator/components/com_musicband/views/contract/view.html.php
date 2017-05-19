<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2017 Szymon Michalewicz. All rights reserved.
 */
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

/**
 * Widok dla listy imprez i listy wybranych przez klientów piosenek
 */
class MusicbandViewContract extends JViewLegacy {

    protected $pagination;
    protected $state;
    public $filterForm;
    public $activeFilters;
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

        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->script = $this->get('Script');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        $this->fields = $this->get('Fields');
        
        MusicbandHelper::addSubmenu('contract');

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        $this->contracts = $this->get('Contracts');
        
        parent::display($tpl);
    }

    /**
     * Tytuł i przyciski na stronie
     * 
     * @return  void
     */
    protected function addToolbar() {
        if (JFactory::getApplication()->input->get('layout', 'default') == 'edit') {
            // Blokowanie menu
            JFactory::getApplication()->input->set('hidemainmenu', true);

            // Tytuł strony
            JToolbarHelper::title(JText::_('COM_MUSICBAND') . ': ' . JText::_('COM_MUSICBAND_CONTRACT'), 'stack article');

            // Przyciski
            JToolBarHelper::apply('contract.apply');
            JToolBarHelper::save('contract.save');
            JToolBarHelper::cancel('contract.cancel');
        } else {
            // Tytuł strony
            JToolbarHelper::title(JText::_('COM_MUSICBAND') . ': ' . JText::_('COM_MUSICBAND_CONTRACT'), 'stack article');

            // Przyciski
            JToolBarHelper::addNew('contract.add');
            JToolBarHelper::editList('contract.edit');
            JToolBarHelper::deleteList(JText::_('COM_MUSICBAND_CONFIRM_DELETE'), 'contract.delete');
        }

        if (JFactory::getUser()->authorise('core.admin', 'com_musicband'))
            JToolbarHelper::preferences('com_musicband');
    }

}
