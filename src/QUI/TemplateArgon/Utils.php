<?php

/**
 * This file contains QUI\TemplateArgon\Utils
 */

namespace QUI\TemplateArgon;

use QUI;

/**
 * Help Class for Template Argon
 *
 * @package QUI\TemplateArgon
 * @author www.pcsg.de (Michael Danielczok)
 *
 * @return array
 */
class Utils
{
    /**
     * @param array $params
     * @return array
     */
    public static function getConfig($params)
    {
        try {
            return QUI\Cache\Manager::get(
                'quiqqer/templateArgon/' . $params['Site']->getId()
            );
        } catch (QUI\Exception $Exception) {
        }

        $config = array();

        /* @var $Project QUI\Projects\Project */
        $Project  = $params['Project'];
        $Template = $params['Template'];

        /**
         * no header?
         * no breadcrumb?
         * Body Class
         *
         * own site type
         */

        $showHeader     = false;
        $showBreadcrumb = false;

        switch ($Template->getLayoutType()) {
            case 'layout/startPage':
                $showHeader     = $Project->getConfig('templateArgon.settings.showHeaderStartPage');
                $showBreadcrumb = $Project->getConfig('templateArgon.settings.showBreadcrumbStartPage');
                break;

            case 'layout/noSidebar':
                $showHeader     = $Project->getConfig('templateArgon.settings.showHeaderNoSidebar');
                $showBreadcrumb = $Project->getConfig('templateArgon.settings.showBreadcrumbNoSidebar');
                break;

            case 'layout/rightSidebar':
                $showHeader     = $Project->getConfig('templateArgon.settings.showHeaderRightSidebar');
                $showBreadcrumb = $Project->getConfig('templateArgon.settings.showBreadcrumbRightSidebar');
                break;

            case 'layout/leftSidebar':
                $showHeader     = $Project->getConfig('templateArgon.settings.showHeaderLeftSidebar');
                $showBreadcrumb = $Project->getConfig('templateArgon.settings.showBreadcrumbLeftSidebar');
                break;
        }


        $showPageTitle = $params['Site']->getAttribute('templateArgon.showTitle');
        $showPageShort = $params['Site']->getAttribute('templateArgon.showShort');

        /* site own show header */
        switch ($params['Site']->getAttribute('templateArgon.showEmotion')) {
            case 'show':
                $showHeader = true;
                break;
            case 'hide':
                $showHeader = false;
        }

        $settingsCSS = include 'settings.css.php';

        $config += array(
            'quiTplType'     => $Project->getConfig('templateArgon.settings.standardType'),
            'showHeader'     => $showHeader,
            'showBreadcrumb' => $showBreadcrumb,
            'settingsCSS'    => '<style>' . $settingsCSS . '</style>',
            'typeClass'      => 'type-' . str_replace(array('/', ':'), '-', $params['Site']->getAttribute('type')),
            'showPageTitle'  => $showPageTitle,
            'showPageShort'  => $showPageShort
        );

        // set cache
        QUI\Cache\Manager::set(
            'quiqqer/templateArgon/' . $params['Site']->getId(),
            $config
        );

        return $config;
    }
}
