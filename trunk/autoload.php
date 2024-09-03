<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'dynamictags\\lib\\activator' => '/Lib/Activator.php',
                'dynamictags\\lib\\deactivator' => '/Lib/Deactivator.php',
                'dynamictags\\lib\\dynamictags' => '/Lib/DynamicTags.php',
                'dynamictags\\lib\\dynamictags\\acfrepeater' => '/Lib/DynamicTags/AcfRepeater.php',
                'dynamictags\\lib\\dynamictags\\arecommentsallowed' => '/Lib/DynamicTags/AreCommentsAllowed.php',
                'dynamictags\\lib\\dynamictags\\cookies' => '/Lib/DynamicTags/Cookies.php',
                'dynamictags\\lib\\dynamictags\\currentlanguage' => '/Lib/DynamicTags/CurrentLanguage.php',
                'dynamictags\\lib\\dynamictags\\currenturl' => '/Lib/DynamicTags/CurrentUrl.php',
                'dynamictags\\lib\\dynamictags\\currentusercan' => '/Lib/DynamicTags/CurrentUserCan.php',
                'dynamictags\\lib\\dynamictags\\is404' => '/Lib/DynamicTags/Is404.php',
                'dynamictags\\lib\\dynamictags\\isauthorofpost' => '/Lib/DynamicTags/IsAuthorOfPost.php',
                'dynamictags\\lib\\dynamictags\\isfeed' => '/Lib/DynamicTags/IsFeed.php',
                'dynamictags\\lib\\dynamictags\\isfrontpage' => '/Lib/DynamicTags/IsFrontpage.php',
                'dynamictags\\lib\\dynamictags\\ishome' => '/Lib/DynamicTags/IsHome.php',
                'dynamictags\\lib\\dynamictags\\ispostincategory' => '/Lib/DynamicTags/IsPostInCategory.php',
                'dynamictags\\lib\\dynamictags\\ispostinlist' => '/Lib/DynamicTags/IsPostInList.php',
                'dynamictags\\lib\\dynamictags\\issingular' => '/Lib/DynamicTags/IsSingular.php',
                'dynamictags\\lib\\dynamictags\\numberpostsquery' => '/Lib/DynamicTags/NumberPostsQuery.php',
                'dynamictags\\lib\\dynamictags\\podsextended' => '/Lib/DynamicTags/PodsExtended.php',
                'dynamictags\\lib\\dynamictags\\postcontent' => '/Lib/DynamicTags/PostContent.php',
                'dynamictags\\lib\\dynamictags\\postparent' => '/Lib/DynamicTags/PostParent.php',
                'dynamictags\\lib\\dynamictags\\poststatus' => '/Lib/DynamicTags/PostStatus.php',
                'dynamictags\\lib\\dynamictags\\posttype' => '/Lib/DynamicTags/PostType.php',
                'dynamictags\\lib\\dynamictags\\servervars' => '/Lib/DynamicTags/ServerVars.php',
                'dynamictags\\lib\\dynamictags\\session' => '/Lib/DynamicTags/Session.php',
                'dynamictags\\lib\\dynamictags\\userauthorimageurl' => '/Lib/DynamicTags/UserAuthorImageUrl.php',
                'dynamictags\\lib\\dynamictags\\userrole' => '/Lib/DynamicTags/UserRole.php',
                'dynamictags\\lib\\dynamictags\\widgetcontent' => '/Lib/DynamicTags/WidgetContent.php',
                'dynamictags\\lib\\dynamictags\\woocommerceisfeatured' => '/Lib/DynamicTags/WooCommerceIsFeatured.php',
                'dynamictags\\lib\\elementbase' => '/Lib/ElementBase.php',
                'dynamictags\\lib\\i18n' => '/Lib/I18n.php',
                'dynamictags\\lib\\loader' => '/Lib/Loader.php',
                'dynamictags\\lib\\template' => '/Lib/Template.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd