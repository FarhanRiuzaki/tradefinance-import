      
<!DOCTYPE html>
<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8"/>
        
        <title><?=$defaultAppSettings['App.Name'];?><?=(!empty($titleModule) ? ' | '.$titleModule : '');?></title>
        <meta name="description" content="<?=$defaultAppSettings['App.Name'];?>">
        <meta name="keywords" content="<?=$defaultAppSettings['App.Name'];?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="aiqbalsyah@zamasco.co.id">

        <!--begin::Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!--end::Fonts -->
        <?php
            $cssExternal = [];
            $cssCustomStyle = [];
            $cssPageVendors = [
            ];
            
            $cssThemeStyle = [
                'dist/vendors/base/vendors.bundle.css',
                'dist/demo/default/base/style.bundle.css'
            ];
            $cssSkinStyle = [
                'dist/demo/default/skins/header/base/light.css',
                'dist/demo/default/skins/header/menu/light.css',
                'dist/demo/default/skins/brand/dark.css',
                'dist/demo/default/skins/aside/dark.css',
            ];
            
            $this->Html->css($cssExternal,['block'=>'cssExternal']);
            $this->Html->css($cssPageVendors,['block'=>'cssPageVendors','pathPrefix' => '/assets/']);
            $this->Html->css($cssCustomStyle,['block'=>'cssCustomStyle','pathPrefix' => '/assets/']);
            $this->Html->css($cssThemeStyle,['block'=>'cssThemeStyle','pathPrefix' => '/assets/']);
            $this->Html->css($cssSkinStyle,['block'=>'cssSkinStyle','pathPrefix' => '/assets/']);
        ?>
        
        <?=$this->fetch('cssExternal');?>
        <!--begin::Page Vendors Styles(used by this page) -->
            <?=$this->fetch('cssPageVendors');?>
        <!--end::Page Vendors Styles -->

        <!--begin::Page Custom Styles(used by this page) -->  
            <?=$this->fetch('cssCustomStyle');?>
        <!--end::Page Custom Styles -->
        
        <!--begin::Global Theme Styles(used by all pages) -->
            <?=$this->fetch('cssThemeStyle');?>
        <!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->
            <?=$this->fetch('cssSkinStyle');?>      
        <!--end::Layout Skins -->

        <?=$this->fetch('cssMain');?>
        
        <link rel="shortcut icon" href="<?=$this->Utilities->generateUrlAsset(null,$defaultAppSettings['App.Favico']);?>" />
    </head>
    <!-- end::Head -->

    <!-- begin::Body -->
    <!-- begin::Body -->
    <body  class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading"  >
    	<?=$this->element('main');?>

    <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
    <!-- end::Scrolltop -->
        <!-- end::Body -->
        <!-- begin::Global Config(global config for global JS sciprts) -->
        <script>
            var KTAppOptions = {"colors":{"state":{"brand":"#5d78ff","dark":"#282a3c","light":"#ffffff","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
        </script>
        <!-- end::Global Config -->
    <?php
        $jsGlobalTheme = [
            'dist/vendors/base/vendors.bundle.js',
            'dist/demo/default/base/scripts.bundle.js',
        ];
        $jsPageVendors = [

        ];
        $jsPage = [
        ];
        $jsGlobalPage = [
            'dist/app/bundle/app.bundle.js'
        ];
        $this->Html->script($jsGlobalTheme,['block'=>'jsGlobalTheme','pathPrefix' => '/assets/']);
        $this->Html->script($jsPageVendors,['block'=>'jsPageVendors','pathPrefix' => '/assets/']);
        $this->Html->script($jsPage,['block'=>'jsPage','pathPrefix' => '/assets/']);
        $this->Html->script($jsGlobalPage,['block'=>'jsPage','pathPrefix' => '/assets/']);
    ?>
    <!--begin::Global Theme Bundle(used by all pages) -->
        <?=$this->fetch('jsGlobalTheme');;?>
    <!--end::Global Theme Bundle -->

    <!--begin::Page Vendors(used by this page) -->
        <?=$this->fetch('jsPageVendors');;?>
    <!--end::Page Vendors -->
                    
    <!--begin::Page Scripts(used by this page) -->
        <?=$this->fetch('jsPage');;?>
    <!--end::Page Scripts -->
    <!--begin::Global App Bundle(used by all pages) -->
        <?=$this->fetch('jsGlobalPage');;?>
    <!--end::Global App Bundle -->
    <?=$this->fetch('script');;?>
    </body>
    <!-- end::Body -->
</html>