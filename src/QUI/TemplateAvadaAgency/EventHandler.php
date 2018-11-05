<?php
/**
 * This file contains \QUI\TemplateAvadaAgency\EventHandler
 */

namespace QUI\TemplateAvadaAgency;

use QUI;

/**
 * Event Class
 *
 * @author www.pcsg.de (Michael Danielczok)
 */
class EventHandler
{
    /**
     * Clear system cache on project save
     *
     * @return void
     */
    public static function onProjectConfigSave()
    {
        try {
            QUI\Cache\Manager::clear('quiqqer/templateAvadaAgency');
        } catch (QUI\Exception $Exception) {
            QUI\System\Log::writeException($Exception);
        }
    }

    /**
     * Clear system cache on site save
     *
     * @return void
     */
    public static function onSiteSave()
    {
        try {
            QUI\Cache\Manager::clear('quiqqer/templateAvadaAgency');
        } catch (QUI\Exception $Exception) {
            QUI\System\Log::writeException($Exception);
        }
    }
}
