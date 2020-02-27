
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$defaultAppSettings['App.Name'];?><?=(!empty($titleModule) ? ' | '.$titleModule : '');?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?=$defaultAppSettings['App.Name'];?>">
    <meta name="keywords" content="<?=$defaultAppSettings['App.Name'];?>">
    <meta name="author" content="Iqbal Ardiansyah">
    <link rel="shortcut icon" href="<?=$this->request->base;?><?=$defaultAppSettings['App.Favico'];?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
        });
    </script>
    <!-- Favicon icon -->
    <?php
        $cssExternal = [];
        $cssDefault = [
            'dist/vendors/base/vendors.bundle.css',
            'dist/demo/default/base/style.bundle.css',
        ];
        
        $cssMain = [
            
        ];
        
        $this->Html->css($cssExternal,['block'=>'cssExternal']);
        $this->Html->css($cssDefault,['block'=>'cssDefault','pathPrefix' => '/assets/']);
        $this->Html->css($cssMain,['block'=>'cssMain','pathPrefix' => '/assets/']);
    
        echo $this->fetch('cssExternal');
        echo $this->fetch('cssDefault');
        echo $this->fetch('cssPlugin');
        echo $this->fetch('cssMain');
    ?>

</head>
    <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid  m-error-5" style="background-image: url(<?=$this->request->base;?>/assets/dist/app/media/img//error/bg5.jpg);">
                <div class="m-error_container">
                    <span class="m-error_title">
                        <h1>
                            Oops!
                        </h1>
                    </span>
                    <p class="m-error_subtitle">
                        Something went wrong here.
                    </p>
                    <p class="m-error_description">
                        You are not allow to access this link.<br>
                        <a href="<?=$this->Url->build(['controller'=>'Pages','action'=>'index']);?>">Click here to return to the main page</a>
                        <div stlye="display:none;">
                        <?=$this->Flash->render();?>
                        </div>
                    </p>
                </div>
            </div>
        </div>
        <!-- end:: Page -->

        <?php
            $jsDefault = [
                'dist/vendors/base/vendors.bundle.js',
                'dist/demo/default/base/scripts.bundle.js',
            ];
            $jsMain = [
                
            ];
            $this->Html->script($jsDefault,['block'=>'jsDefault','pathPrefix' => '/assets/']);
            $this->Html->script($jsDefault,['block'=>'jsPlugin','pathPrefix' => '/assets/']);
            $this->Html->script($jsMain,['block'=>'jsMain','pathPrefix' => '/assets/']);

            echo $this->fetch('jsDefault');
            echo $this->fetch('jsPlugin');
            echo $this->fetch('jsMain');
            echo $this->fetch('script');
        ?>
        <script>
            
        </script>
    </body>
</html>