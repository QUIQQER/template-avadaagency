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

    /**
     * Event : on smarty init
     * @param \Smarty $Smarty - \Smarty
     */
    public static function onSmartyInit($Smarty)
    {
        // {pace}
        if (!isset($Smarty->registered_plugins['function']) ||
            !isset($Smarty->registered_plugins['function']['fetch'])
        ) {
            $Smarty->registerPlugin(
                "function",
                "fetch",
                "\\QUI\\TemplateAvadaAgency\\EventHandler::fetch"
            );
        }
    }

    /**
     * @param $params
     * @param $Smarty
     * @return string
     */
    public static function fetch($params, $Smarty)
    {
        $template = $params['template'];
        $path     = OPT_DIR . 'quiqqer/template-avadaagency/';

        $Engine = QUI::getTemplateManager()->getEngine();
        $Engine->assign($params);

        return $Engine->fetch($path . $template);
    }

}
