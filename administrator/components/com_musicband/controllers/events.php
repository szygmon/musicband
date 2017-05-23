<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2015 Szymon Michalewicz. All rights reserved.
 */
// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

//use Joomla\Google\Google;
use Joomla\Registry\Registry;

/**
 * The musicband controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 */
class MusicbandControllerEvents extends JControllerAdmin {

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     */
    public function getModel($name = 'Event', $prefix = 'MusicbandModel', $config = array('ignore_request' => true)) {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }

    // Obsługa usuwania danych z powiązanych tabel BD
    public function delete() {
        $id = JRequest::getVar('cid');

        $this->getModel('Events')->deleteEvents($id);

        parent::delete();
    }

    // Obsługa usuwania przestarzałych wydarzeń z BD
    public function deleteold() {
        $this->getModel('Events')->deleteOldEvents();
        $this->setRedirect('index.php?option=com_musicband&view=events', JText::_('COM_MUSICBAND_DELETED_OLD_SUCCESS'));
    }

    public function publish() {

        parent::publish();

        if ($this->getTask() == 'publish') {
            if (JFactory::getSession()->get('google_access_token')) {
                $this->getModel('Events')->publishCalendar(JFactory::getApplication()->input->get('cid')[0]);
            } else {
                $redirect_uri = JUri::getInstance() . '&layout=oauth2callback&cid=' . JFactory::getApplication()->input->get('cid')[0];
                $this->setRedirect($redirect_uri);
                $this->redirect();
            }
        }
    }

}
