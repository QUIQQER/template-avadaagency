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
         * Body Class
         *
         * own site type
         */

        $showHeader    = false;
        $showPageTitle = true;
        $showPageShort = true;

        switch ($Template->getLayoutType()) {
            case 'layout/startPage':
                $showHeader    = $Project->getConfig('templateAvadaAgency.settings.showHeaderStartPage');
                $showPageTitle = $Project->getConfig('templateAvadaAgency.settings.general.showTitleStartPage');
                $showPageShort = $Project->getConfig('templateAvadaAgency.settings.general.showShortStartPage');
                break;

            case 'layout/noSidebar':
                $showHeader    = $Project->getConfig('templateAvadaAgency.settings.showHeaderNoSidebar');
                $showPageTitle = $Project->getConfig('templateAvadaAgency.settings.general.showTitleNoSidebar');
                $showPageShort = $Project->getConfig('templateAvadaAgency.settings.general.showShortNoSidebar');
                break;

            case 'layout/noSidebarSmall':
                $showHeader    = $Project->getConfig('templateAvadaAgency.settings.showHeaderNoSidebarSmall');
                $showPageTitle = $Project->getConfig('templateAvadaAgency.settings.general.showTitleNoSidebarSmall');
                $showPageShort = $Project->getConfig('templateAvadaAgency.settings.general.showShortNoSidebarSmall');
                break;

            case 'layout/rightSidebar':
                $showHeader    = $Project->getConfig('templateAvadaAgency.settings.showHeaderRightSidebar');
                $showPageTitle = $Project->getConfig('templateAvadaAgency.settings.general.showTitleRightSidebar');
                $showPageShort = $Project->getConfig('templateAvadaAgency.settings.general.showShortRightSidebar');
                break;

            case 'layout/leftSidebar':
                $showHeader    = $Project->getConfig('templateAvadaAgency.settings.showHeaderLeftSidebar');
                $showPageTitle = $Project->getConfig('templateAvadaAgency.settings.general.showTitleLeftSidebar');
                $showPageShort = $Project->getConfig('templateAvadaAgency.settings.general.showShortLeftSidebar');
                break;
        }


        /* site own settings: show page title */
        switch ($params['Site']->getAttribute('templateAvadaAgency.showTitle')) {
            case 'show':
                $showPageTitle = true;
                break;
            case 'hide':
                $showPageTitle = false;
        }

        /* site own settings: show page short description */
        switch ($params['Site']->getAttribute('templateAvadaAgency.showShort')) {
            case 'show':
                $showPageShort = true;
                break;
            case 'hide':
                $showPageShort = false;
        }

        /* site own settings: show header */
        switch ($params['Site']->getAttribute('templateAvadaAgency.showHeader')) {
            case 'show':
                $showHeader = true;
                break;
            case 'hide':
                $showHeader = false;
        }

        /**
         * Breadcrumb
         */
        $showBreadcrumb = 'displayInHeader';
        switch ($Project->getConfig('templateAvadaAgency.settings.general.breadcrumb')) {
            case 'displayUnderHeader':
                $showBreadcrumb = 'displayUnderHeader';
                break;
            case 'hide':
                $showBreadcrumb = false;
        }

        /* site own settings: breadcrumb */
        switch ($params['Site']->getAttribute('templateAvadaAgency.breadcrumb')) {
            case 'displayInHeader':
                $showBreadcrumb = 'displayInHeader';
                break;
            case 'displayUnderHeader':
                $showBreadcrumb = 'displayUnderHeader';
                break;
            case 'hide':
                $showBreadcrumb = false;
        }

        /**
         * Template footer settings
         */
        $footerTemplate = false;
        if ($Project->getConfig('templateAvadaAgency.settings.footerTemplate.enable')) {
            $footerTemplate = $Project->getConfig('templateAvadaAgency.settings.footerTemplate.enable');
            $config         += self::getFooterTemplate($Project);
        }

        $settingsCSS = include 'settings.css.php';

        $config += [
            'quiTplType'     => $Project->getConfig('templateAvadaAgency.settings.standardType'),
            'showHeader'     => $showHeader,
            'showBreadcrumb' => $showBreadcrumb,
            'showFooterNav'  => $showFooterNav,
            'settingsCSS'    => '<style>' . $settingsCSS . '</style>',
            'typeClass'      => 'type-' . str_replace(['/', ':'], '-', $params['Site']->getAttribute('type')),
            'showPageTitle'  => $showPageTitle,
            'showPageShort'  => $showPageShort,
            'footerTemplate' => $footerTemplate
        ];

        // set cache
        QUI\Cache\Manager::set(
            'quiqqer/templateAvadaAgency/' . $params['Site']->getId(),
            $config
        );

        return $config;
    }

    /**
     * @param $Project \QUI\Projects\Project
     * @return array
     */
    private static function getFooterTemplate($Project)
    {
        $lang                 = $Project->getLang();
        $footerTemplateConfig = [];
        $where['active']      = 1;

        // default
        $footerTemplateConfig['footerTemplate'] = [
            'linksBox'     => null,
            'linksBoxMore' => null,
            'recent'       => null,
            'shortText'    => null
        ];

        /**
         * Links box
         */
        if ($Project->getConfig('templateAvadaAgency.settings.footerTemplate.linksBox.show')) {
            $titleArray = json_decode($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.linksBox.title'
            ), true);

            $title = false;
            if (isset($titleArray[$lang])) {
                $title = $titleArray[$lang];
            }

            // order the box in footer
            $linksBoxPriority = 1;
            if ($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.linksBox.priority'
            )) {
                $linksBoxPriority = $Project->getConfig(
                    'templateAvadaAgency.settings.footerTemplate.linksBox.priority'
                );
            }

            $parents = $Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.linksBox.sites'
            );

            $sites = QUI\Projects\Site\Utils::getSitesByInputList($Project, $parents, [
                'where' => $where,
                'limit' => 10,
                'order' => $Project->getConfig('templateAvadaAgency.settings.footerTemplate.linksBox.sites.order')
            ]);

            $footerTemplateConfig['footerTemplate']['linksBox'] = [
                'title'    => $title,
                'sites'    => $sites,
                'priority' => $linksBoxPriority
            ];
        }

        /**
         * Links box (second / more links)
         */
        if ($Project->getConfig('templateAvadaAgency.settings.footerTemplate.linksBoxMore.show')) {
            $titleArray = json_decode($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.linksBoxMore.title'
            ), true);

            $title = false;
            if (isset($titleArray[$lang])) {
                $title = $titleArray[$lang];
            }

            // order the box in footer
            $linksBoxPriority = 1;
            if ($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.linksBoxMore.priority'
            )) {
                $linksBoxPriority = $Project->getConfig(
                    'templateAvadaAgency.settings.footerTemplate.linksBoxMore.priority'
                );
            }

            $parents = $Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.linksBoxMore.sites'
            );

            $sites = QUI\Projects\Site\Utils::getSitesByInputList($Project, $parents, [
                'where' => $where,
                'limit' => 10,
                'order' => $Project->getConfig('templateAvadaAgency.settings.footerTemplate.linksBoxMore.sites.order')
            ]);

            $footerTemplateConfig['footerTemplate']['linksBoxMore'] = [
                'title'    => $title,
                'sites'    => $sites,
                'priority' => $linksBoxPriority
            ];
        }

        /**
         * Recent (blog / news)
         */
        if ($Project->getConfig('templateAvadaAgency.settings.footerTemplate.recent.show')) {
            $titleArray = json_decode($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.recent.title'
            ), true);

            $title = false;
            if (isset($titleArray[$lang])) {
                $title = $titleArray[$lang];
            }


            // order the box in footer
            $linksBoxPriority = 1;
            if ($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.recent.priority'
            )) {
                $linksBoxPriority = $Project->getConfig(
                    'templateAvadaAgency.settings.footerTemplate.recent.priority'
                );
            }

            $parents = $Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.recent.sites'
            );

            $sites = QUI\Projects\Site\Utils::getSitesByInputList($Project, $parents, [
                'where' => $where,
                'limit' => $Project->getConfig('templateAvadaAgency.settings.footerTemplate.recent.limit'),
                'order' => $Project->getConfig('templateAvadaAgency.settings.footerTemplate.recent.sites.order')
            ]);

            $footerTemplateConfig['footerTemplate']['recent'] = [
                'title'    => $title,
                'sites'    => $sites,
                'priority' => $linksBoxPriority
            ];
        }

        /**
         * Short text
         */
        if ($Project->getConfig('templateAvadaAgency.settings.footerTemplate.shortText.show')) {
            $titleArray = json_decode($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.shortText.title'
            ), true);

            $title = false;
            if (isset($titleArray[$lang])) {
                $title = $titleArray[$lang];
            }

            // order the box in footer
            $linksBoxPriority = 1;
            if ($Project->getConfig(
                'templateAvadaAgency.settings.footerTemplate.shortText.priority'
            )) {
                $linksBoxPriority = $Project->getConfig(
                    'templateAvadaAgency.settings.footerTemplate.shortText.priority'
                );
            }

            $footerTemplateConfig['footerTemplate']['shortText'] = [
                'title'    => $title,
                'content'  => $Project->getConfig('templateAvadaAgency.settings.footerTemplate.shortText.content'),
                'priority' => $linksBoxPriority
            ];
        }

        return $footerTemplateConfig;
    }

    /**
     * Convert #hex value to rgb(a)
     * inspired by https://stackoverflow.com/a/31934345
     *
     * returns array...
     * Array (
     *     [r] => 25
     *     [g] => 182
     *     [b] => 152
     *     [a] => 1
     * )
     *
     * or string in rgba format...
     * "255,255,255,1"
     *
     * @param $hex
     * @param bool $alpha
     * @param bool $rgbaFormat
     * @return array | string
     */
    public static function hexToRgb($hex, $alpha = false, $rgbaFormat = false)
    {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

        if ($alpha) {
            $rgb['a'] = $alpha;
        }

        //If you'd like to return the rgb(a) in CSS format...
        if ($rgbaFormat) {
            return implode(array_keys($rgb)) . '(' . implode(', ', $rgb) . ')';
        }

        return $rgb;
    }
}
