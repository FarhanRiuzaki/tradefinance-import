<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
	<div class="kt-header-mobile__logo">
		<a href="<?=$this->Url->build(['controller'=>'Default','action'=>'index']);?>">
			<img alt="Logo" src="<?=$this->Utilities->generateUrlAsset(null,$defaultAppSettings['App.Logo']);;?>" style="max-height:50px;max-width:100%;"/>
		</a>
	</div>
	<div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
		<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
	</div>
</div>
<!-- end:: Header Mobile -->