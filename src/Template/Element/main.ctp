<!-- begin:: Page -->
<?=$this->element('mobile_button');?>
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <?=$this->element('aside');?>	
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <?=$this->element('header');?>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">	
                    <?=$this->element('content_head');?>
                    <?=$this->Flash->render();?>
                    <?=$this->element('content_body');?>
                </div>				
            
                <?=$this->element('footer');?>
            </div>
        </div>
    </div>
<!-- end:: Page -->