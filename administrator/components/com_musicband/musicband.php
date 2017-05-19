<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_musicband
 *
 * @copyright   Copyright (C) 2017 Szymon Michalewicz. All rights reserved.
 */

// Brak bezpośredniego dostępu do pliku
defined('_JEXEC') or die('Restricted access');

// Sprawdzanie dostępu
if (!JFactory::getUser()->authorise('core.manage', 'com_musicband')) {
    throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::register('MusicbandHelper', JPATH_COMPONENT . '/helpers/musicband.php');

// Get an instance of the controller prefixed by Musicband
$controller = JControllerLegacy::getInstance('Musicband');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();







