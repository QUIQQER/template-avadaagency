<?php

$Convert = new \QUI\Utils\Convert();

$navBarBgColor      = '#ffffff';
$navBarFontColor      = '#969595';

if ($Project->getConfig('templateAvadaAgency.settings.navBarBgColor')) {
    $navBarBgColor = $Project->getConfig('templateAvadaAgency.settings.navBarBgColor');
}

if ($Project->getConfig('templateAvadaAgency.settings.navBarFontColor')) {
    $navBarFontColor = $Project->getConfig('templateAvadaAgency.settings.navBarFontColor');
}

$navBarBgColorLighter = $Convert->colorBrightness($navBarBgColor, 0.9);

/**
 * colors
 */
$colorFooterBackground = '#414141';
$colorFooterNavBackground = '#2c2c2c';
$colorFooterBackgroundOpacity = 1;
$colorFooterFont       = '#D1D1D1';
$colorFooterLinks      = '#DDDDDD';
$backgroundImageUrl = false;
$backgroundImagePosition = 'center';
$colorMain             = '#252525';
$buttonFontColor       = '#ffffff';
$colorMainContentBg    = '#ffffff';

if ($Project->getConfig('templateAvadaAgency.settings.footer.colorBackground.opacity')) {
    $colorFooterBackgroundOpacity = $Project->getConfig('templateAvadaAgency.settings.footer.colorBackground.opacity');

    // min 0, max 1
    $colorFooterBackgroundOpacity = $colorFooterBackgroundOpacity / 100;

    if ($colorFooterBackgroundOpacity > 1 || $colorFooterBackgroundOpacity < 0) {
        $colorFooterBackgroundOpacity = 1;
    }
}

if ($Project->getConfig('templateAvadaAgency.settings.footer.colorBackground')) {
    $colorFooterBackground = $Project->getConfig('templateAvadaAgency.settings.footer.colorBackground');
    $colorFooterNavBackground = $Convert->colorBrightness($colorFooterBackground, -0.8);
}

if ($Project->getConfig('templateAvadaAgency.settings.footer.backgroundOpacity')) {
    $colorFooterBackgroundOpacity = $Project->getConfig('templateAvadaAgency.settings.footer.backgroundOpacity');
}

if ($Project->getConfig('templateAvadaAgency.settings.footer.colorFont')) {
    $colorFooterFont = $Project->getConfig('templateAvadaAgency.settings.footer.colorFont');
}

if ($Project->getConfig('templateAvadaAgency.settings.footer.colorLinks')) {
    $colorFooterLinks = $Project->getConfig('templateAvadaAgency.settings.footer.colorLinks');
}

if ($Project->getConfig('templateAvadaAgency.settings.footer.backgroundImage')) {
    $backgroundImage = $Project->getConfig('templateAvadaAgency.settings.footer.backgroundImage');
    $backgroundImageUrl = QUI\Projects\Media\Utils::getImageByUrl($backgroundImage)->getSizeCacheUrl();
}

if ($Project->getConfig('templateAvadaAgency.settings.footer.backgroundImage.position')) {
    $backgroundImagePosition = $Project->getConfig('templateAvadaAgency.settings.footer.backgroundImage.position');
}


if ($Project->getConfig('templateAvadaAgency.settings.colorMain')) {
    $colorMain = $Project->getConfig('templateAvadaAgency.settings.colorMain');
}

if ($Project->getConfig('templateAvadaAgency.settings.buttonFontColor')) {
    $buttonFontColor = $Project->getConfig('templateAvadaAgency.settings.buttonFontColor');
}

if ($Project->getConfig('templateAvadaAgency.settings.colorMainContentBg')) {
    $colorMainContentBg = $Project->getConfig('templateAvadaAgency.settings.colorMainContentBg');
}


// Footer background color (Transparency is observed.)
$colorFooterBackground = QUI\TemplateAvadaAgency\Utils::hexToRgb($colorFooterBackground, $colorFooterBackgroundOpacity, true);
// Footer nav background color
$colorFooterNavBackground = QUI\TemplateAvadaAgency\Utils::hexToRgb($colorFooterNavBackground ,$colorFooterBackgroundOpacity, true);


$colorFooterLinksLighter = $Convert->colorBrightness($colorFooterLinks, 0.9);

$headerHeight = (int)$Project->getConfig('templateAvadaAgency.settings.headerHeight');
$bgColorSwitcherPrefix = $Project->getConfig('templateAvadaAgency.settings.bgColorSwitcherPrefix');
$bgColorSwitcherSuffix = $Project->getConfig('templateAvadaAgency.settings.bgColorSwitcherSuffix');
$headerImagePosition = $Project->getConfig('templateAvadaAgency.settings.headerImagePosition');
$navPos = $Project->getConfig('templateAvadaAgency.settings.navPos');
$colorMainButton = $Convert->colorBrightness($colorMain, 0.7);

ob_start();

?>
/**
 * Farbeinstellungen
 */

/* nav bar */
#mainNavigation {
    background-color: <?php echo $navBarBgColor; ?>;
}

.dropdown-menu {
    background-color: <?php echo $navBarBgColorLighter; ?>;
}

#mainNavigation .navbar-nav li a {
    color: <?php echo $navBarFontColor; ?>;
}

.color-main,
.control-color,
.mainColor {
    color: <?php echo $colorMain; ?>;
}

.pace .pace-progress {
    background-color: <?php echo $colorMain; ?>;
}

button,
.button {
    background-color: <?php echo $colorMain; ?>;
    color: <?php echo $buttonFontColor; ?>;
}

button:hover,
.button:hover {
    background-color: <?php echo $Convert->colorBrightness($colorMain, 0.8); ?>;
    color: <?php echo $buttonFontColor; ?>;
}

a {
    color: <?php echo $colorMain; ?>;
}

a:hover,
a:focus {
    color: <?php echo $Convert->colorBrightness($colorMain, -0.8); ?>;
}

<?php if ($backgroundImageUrl) { ?>
/***************************/
/* footer background image */
/***************************/

.page-footer-wrapper {
    background-position: <?php echo $backgroundImagePosition ?>;
    background-image: url("<?php echo $backgroundImageUrl ?>");
}

<?php }; ?>

.page-footer {
    background: <?php echo $colorFooterBackground; ?>;
    color: <?php echo $colorFooterFont; ?>;
}

.page-footer p,
.page-footer h1,
.page-footer h2,
.page-footer h3,
.page-footer h4,
.page-footer h5 {
    color: <?php echo $colorFooterFont; ?>;
}

.footer-nav {
    background: <?php echo $colorFooterNavBackground ; ?>;
    color: <?php echo $colorFooterFont; ?>;
}

.footer-links li a {
    color: <?php echo $colorFooterLinks; ?>;
}

.footer-links li a:before {
    color: <?php echo $colorFooterFont; ?>;
}

.page-footer a {
    color: <?php echo $colorFooterLinks; ?>;
}

.page-footer a:hover {
    color: <?php echo $Convert->colorBrightness($colorFooterLinks, 0.25); ?>;
}

.control-background-active {
    background: <?php /*echo $colorMain; */?> !important;
    color: #FFFFFF !important;
}

.control-background {
    background: <?php /*echo $colorMain; */?>;
}

*

/

/**
 * background color prefix suffix switcher
 * Prefix
 */
<?php if ($bgColorSwitcherPrefix == 'display') { ?>
.brick-even-prefix {
    background: #f5f5f5;
}

.brick-odd-prefix {
    background: #e5e5e5;
}

<?php }; ?>

/**
 * background color prefix suffix switcher
 * Suffix
 */
<?php if ($bgColorSwitcherSuffix == 'display') { ?>
.brick-even-suffix {
    background: #f5f5f5;
}

.brick-odd-suffix {
    background: #e5e5e5;
}

<?php }; ?>

<?php if ($headerHeight) { ?>
.page-head .header-wrapper {
    height: <?php echo $headerHeight; ?>px !important;
}

.page-head {
    background-position: <?php echo $headerImagePosition; ?>;
}

<?php };
?>

<?php

$settingsCSS = ob_get_contents();
ob_end_clean();

return $settingsCSS;

?>
