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
$colorFooterFont       = '#D1D1D1';
$colorFooterLinks      = '#DDDDDD';
$colorMain             = '#dd151b';
$buttonFontColor       = '#ffffff';
$colorMainContentBg    = '#ffffff';

if ($Project->getConfig('templateAvadaAgency.settings.colorFooterBackground')) {
    $colorFooterBackground = $Project->getConfig('templateAvadaAgency.settings.colorFooterBackground');
}

if ($Project->getConfig('templateAvadaAgency.settings.colorFooterFont')) {
    $colorFooterFont = $Project->getConfig('templateAvadaAgency.settings.colorFooterFont');
}

if ($Project->getConfig('templateAvadaAgency.settings.colorMain')) {
    $colorMain = $Project->getConfig('templateAvadaAgency.settings.colorMain');
}

if ($Project->getConfig('templateAvadaAgency.settings.buttonFontColor')) {
    $buttonFontColor = $Project->getConfig('templateAvadaAgency.settings.buttonFontColor');
}

if ($Project->getConfig('templateAvadaAgency.settings.colorFooterLinks')) {
    $colorFooterLinks = $Project->getConfig('templateAvadaAgency.settings.colorFooterLinks');
}

if ($Project->getConfig('templateAvadaAgency.settings.colorMainContentBg')) {
    $colorMainContentBg = $Project->getConfig('templateAvadaAgency.settings.colorMainContentBg');
}

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

/*input[type='submit'],
input[type='reset'],
input[type='button'],
button,
.button,
.tpl-Argon-row .button,
button:disabled,
button:disabled:hover,
a.template-button,
button.qui-button-active,
button.qui-button:active,
button.qui-button:hover {
    background-color: <?php /*echo $colorMain; */?>;
    color: <?php /*echo $buttonFontColor; */?>;
    border: 2px solid <?php /*echo $colorMain; */?>;
}

.button:hover {
    background: none;
}*/

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

.page-footer {
    background: <?php echo $colorFooterBackground; ?>;
    color: <?php echo $colorFooterFont; ?> !important;
}

.page-footer p {
    color: <?php echo $colorFooterFont; ?> !important;
}

.footer-nav {
    background: <?php echo $Convert->colorBrightness($colorFooterBackground, -0.9) ; ?>;
    color: <?php echo $colorFooterFont; ?> !important;
}

.footer-links li a {
    color: <?php echo $colorFooterLinks; ?> !important;
}

.footer-links li a:before {
    color: <?php echo $colorFooterFont; ?> !important;
}

.page-footer a {
    color: <?php echo $colorFooterLinks; ?>;
}

.page-footer a:hover {
    color: <?php echo $Convert->colorBrightness($colorFooterLinks, 0.25); ?> !important;
}

/* pagination */
/*.quiqqer-sheets-desktop a:hover {
    border: 1px solid <?php /*echo $colorMain; */?> !important;
    background-color: <?php /*echo $colorMain; */?>;
}

.quiqqer-sheets-desktop-limits a:hover {
    color: <?php /*echo $colorMain; */?>;
}

.control-background-active {
    background: <?php /*echo $colorMain; */?> !important;
    color: #FFFFFF !important;
}

.control-background {
    background: <?php /*echo $colorMain; */?>;
}*/

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

.header-img {
    align-self: <?php echo $headerImagePosition; ?>;
}

<?php };
?>

<?php

$settingsCSS = ob_get_contents();
ob_end_clean();

return $settingsCSS;

?>
