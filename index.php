<?php

$Template->setAttribute('noConflict', true);

$Locale = QUI::getLocale();

/**
 * Emotion
 */
QUI\Utils\Site::setRecursivAttribute($Site, 'image_emotion');
$imageEmotion = false;
if ($Site->getAttribute('image_emotion')) {
    $imageEmotion = $Site->getAttribute('image_emotion');
}

// Inhaltsverhalten
if ($Site->getAttribute('templateBusinessPro.showTitle') ||
    $Site->getAttribute('templateBusinessPro.showShort')
) {
    $Template->setAttribute('content-header', false);
}

/**
 * Project Logo
 */
$Logo = $Project->getMedia()->getLogoImage();

/**
 * Breadcrumb
 */
$Breadcrumb = new QUI\Controls\Breadcrumb();

/**
 * Template config
 */
$templateSettings = QUI\TemplateAvadaAgency\Utils::getConfig([
    'Project'  => $Project,
    'Site'     => $Site,
    'Template' => $Template
]);


/**
 * body class
 */
$bodyClass = '';
$startPage = false;

switch ($Template->getLayoutType()) {
    case 'layout/startPage':
        $bodyClass = 'start-page';
        $startPage = true;
        break;

    case 'layout/noSidebar':
        $bodyClass = 'no-sidebar';
        break;

    case 'layout/rightSidebar':
        $bodyClass = 'right-sidebar';
        break;

    case 'layout/leftSidebar':
        $bodyClass = 'left-sidebar';
        break;
}

$templateSettings['BricksManager'] = QUI\Bricks\Manager::init();
$templateSettings['Logo']          = $Logo;
$templateSettings['Breadcrumb']    = $Breadcrumb;
$templateSettings['bodyClass']     = $bodyClass;
$templateSettings['startPage']     = $startPage;
$templateSettings['imageEmotion']  = $imageEmotion;

$Engine->assign($templateSettings);
