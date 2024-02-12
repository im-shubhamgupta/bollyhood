<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Analytics Dashboard - Application Intel - SmartAdmin v4.5.1
    </title>
    <meta name="description" content="Analytics Dashboard">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <!-- <meta name="apple-mobile-web-app-capable" content="yes" /> -->
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <!-- <meta name="msapplication-tap-highlight" content="no"> -->
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="<?=RESOURCE_URL?>/css/vendors.bundle.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script> -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="<?=asset('css/vendors.bundle.css')?>">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="<?=asset('css/app.bundle.css')?>">
    <!-- <link id="mytheme" rel="stylesheet" media="screen, print" href="#"> -->
    <link id="myskin" rel="stylesheet" media="screen, print" href="<?=asset('css/skins/skin-master.css')?>">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=asset('img/favicon/apple-touch-icon.png')?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=asset('/img/favicon/favicon-32x32.png')?>">
    <link rel="mask-icon" href="<?=asset('/img/favicon/safari-pinned-tab.svg"')?>" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href= "<?=asset('/css/miscellaneous/reactions/reactions.css')?>">
    <!-- <link rel="stylesheet" media="screen, print" href="<?=asset('/css/miscellaneous/fullcalendar/fullcalendar.bundle.css')?>"> -->
    <link rel="stylesheet" media="screen, print" href="<?=asset('/css/miscellaneous/jqvmap/jqvmap.bundle.css')?>">
    <link rel="stylesheet" media="screen, print" href="<?=asset('css/datagrid/datatables/datatables.bundle.css')?>">
    <link rel="stylesheet" media="screen, print" href="<?=asset('css/datagrid/datatables/datatables.bundle.css')?>">
    <link rel="stylesheet" media="screen, print" href="<?=asset('css/sweet-alert/sweetalert2.bundle.css')?>">
    <link rel="stylesheet" media="screen, print" href="<?=asset('css/light-gallery/lightgallery.bundle.css')?>">
    <link rel="stylesheet" media="screen, print" href="<?=asset('/css/custom_css.css')?>">
        <!-- <script src="<?=asset('/js/header_setting.js')?>"></script> -->
</head>
<body class="mod-bg-1 mod-nav-link ">
    <script type="text/javascript">
    /**
             *  This script should be placed right after the body tag for fast execution 
             *  Note: the script is written in pure javascript and does not depend on thirdparty library
             **/
            'use strict';
            var classHolder = document.getElementsByTagName("BODY")[0],
                /** 
                 * Load from localstorage
                 **/
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            /** 
             * Load theme options
             **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            }
            else
            {
                console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...", "color: #ed1c24");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);

            }
            else if (themeSettings.themeURL && document.getElementById('mytheme'))
            {
                document.getElementById('mytheme').href = themeSettings.themeURL;
            }
            /** 
             * Save to localstorage 
             **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|footer|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /** 
             * Reset settings
             **/
            var resetSettings = function()
            {
                localStorage.setItem("themeSettings", "");
            }
    </script>
    <div class="page-wrapper">
        <div class="page-inner">
            <!-- div close on footer -->