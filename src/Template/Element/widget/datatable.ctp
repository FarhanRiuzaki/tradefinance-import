<?php
    $this->Html->css([
        'dist/vendors/custom/datatables/datatables.bundle.css'
    ],['block'=>'cssPageVendors','pathPrefix' => '/assets/']);
    $this->Html->script([
        'dist/vendors/custom/datatables/datatables.bundle.js'
    ],['block'=>'jsPageVendors','pathPrefix' => '/assets/']);
?>
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						<?=$titlesubModule;?>
					</h3>
				</div>
			</div>
            <div class="kt-portlet__body">
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table_default">
                    
                </table>
            </div>
		</div>
    </div>
</div>