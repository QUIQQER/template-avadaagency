<?php

/**
 * This file contains QUI\templateAvadaAgency\Utils
 */

namespace QUI\templateAvadaAgency;

use QUI;

/**
 * Help Class for Template Avada Agency
 *
 * @package QUI\templateAvadaAgency
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
                'quiqqer/templateAvadaAgency/' . $params['Site']->getId()
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
                $showHeader     = $Project->getConfig('templateAvadaAgency.settings.showHeaderStartPage');
                $showBreadcrumb = $Project->getConfig('templateAvadaAgency.settings.showBreadcrumbStartPage');
                break;

            case 'layout/noSidebar':
                $showHeader     = $Project->getConfig('templateAvadaAgency.settings.showHeaderNoSidebar');
                $showBreadcrumb = $Project->getConfig('templateAvadaAgency.settings.showBreadcrumbNoSidebar');
                break;

            case 'layout/rightSidebar':
                $showHeader     = $Project->getConfig('templateAvadaAgency.settings.showHeaderRightSidebar');
                $showBreadcrumb = $Project->getConfig('templateAvadaAgency.settings.showBreadcrumbRightSidebar');
                break;

            case 'layout/leftSidebar':
                $showHeader     = $Project->getConfig('templateAvadaAgency.settings.showHeaderLeftSidebar');
                $showBreadcrumb = $Project->getConfig('templateAvadaAgency.settings.showBreadcrumbLeftSidebar');
                break;
        }


        $showPageTitle = $params['Site']->getAttribute('templateAvadaAgency.showTitle');
        $showPageShort = $params['Site']->getAttribute('templateAvadaAgency.showShort');

        /* site own show header */
        switch ($params['Site']->getAttribute('templateAvadaAgency.showEmotion')) {
            case 'show':
                $showHeader = true;
                break;
            case 'hide':
                $showHeader = false;
        }

        $settingsCSS = include 'settings.css.php';

        $config += array(
            'quiTplType'     => $Project->getConfig('templateAvadaAgency.settings.standardType'),
            'showHeader'     => $showHeader,
            'showBreadcrumb' => $showBreadcrumb,
            'settingsCSS'    => '' . $settingsCSS . '',
            'typeClass'      => 'type-' . str_replace(array('/', ':'), '-', $params['Site']->getAttribute('type')),
            'showPageTitle'  => $showPageTitle,
            'showPageShort'  => $showPageShort
        );

        // set cache
        QUI\Cache\Manager::set(
            'quiqqer/templateAvadaAgency/' . $params['Site']->getId(),
            $config
        );

        return $config;
    }
}
