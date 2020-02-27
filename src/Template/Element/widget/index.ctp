<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
                <?=$titlesubModule;?>
				</h3>
			</div>
		</div>
		<?=$this->element('widget/portlet_tools_index',['rightButton' => $rightButton]);?>
	</div>
	<div class="m-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover" id="m_table_1">
		  							
        </table>
	</div>
</div>