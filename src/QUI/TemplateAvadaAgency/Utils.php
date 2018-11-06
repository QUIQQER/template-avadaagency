<?php

/**
 * This file contains QUI\TemplateAvadaAgency\Utils
 */

namespace QUI\TemplateAvadaAgency;

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

        $config = [];

        /* @var $Project QUI\Projects\Project */
        $Project  = $params['Project'];
        $Template = $params['Template'];

        $showFooterNav = false;
        if ($Project->getConfig('templateAvadaAgency.settings.footer.showFooterNav')) {
            $showFooterNav = $Project->getConfig('templateAvadaAgency.settings.footer.showFooterNav');
        }

        /**
         * no header?
         * no breadcrumb?
         * Body Class
         *
         * own site type
         */

        $showHeader = false;

        switch ($Template->getLayoutType()) {
            case 'layout/startPage':
                $showHeader = $Project->getConfig('templateAvadaAgency.settings.showHeaderStartPage');
                break;

            case 'layout/noSidebar':
                $showHeader = $Project->getConfig('templateAvadaAgency.settings.showHeaderNoSidebar');
                break;

            case 'layout/noSidebarSmall':
                $showHeader = $Project->getConfig('templateAvadaAgency.settings.showHeaderNoSidebarSmall');
                break;

            case 'layout/rightSidebar':
                $showHeader = $Project->getConfig('templateAvadaAgency.settings.showHeaderRightSidebar');
                break;

            case 'layout/leftSidebar':
                $showHeader = $Project->getConfig('templateAvadaAgency.settings.showHeaderLeftSidebar');
                break;
        }


        $showPageTitle = $params['Site']->getAttribute('templateAvadaAgency.showTitle');
        $showPageShort = $params['Site']->getAttribute('templateAvadaAgency.showShort');

        /* site own show header */
        /*switch ($params['Site']->getAttribute('templateAvadaAgency.showEmotion')) {
            case 'show':
                $showHeader = true;
                break;
            case 'hide':
                $showHeader = false;
        }*/

        $settingsCSS = include 'settings.css.php';

        $config += [
            'quiTplType'    => $Project->getConfig('templateAvadaAgency.settings.standardType'),
            'showHeader'    => $showHeader,
            'showFooterNav' => $showFooterNav,
            'settingsCSS'   => '<style>' . $settingsCSS . '</style>',
            'typeClass'     => 'type-' . str_replace(['/', ':'], '-', $params['Site']->getAttribute('type')),
            'showPageTitle' => $showPageTitle,
            'showPageShort' => $showPageShort
        ];

        // set cache
        QUI\Cache\Manager::set(
            'quiqqer/templateAvadaAgency/' . $params['Site']->getId(),
            $config
        );

        return $config;
    }
}
