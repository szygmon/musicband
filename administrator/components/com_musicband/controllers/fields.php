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
 * The musicband controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 */
class MusicbandControllerFields extends JControllerForm {

    function __construct($config = array()) {
         parent::__construct($config);
          // Zmiana widoku po zapisie/edycji utworu
          $this->view_list = 'fields';  
    }

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     */
    public function getModel($name = 'Fields', $prefix = 'MusicbandModel', $config = array('ignore_request' => true)) {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }

}
