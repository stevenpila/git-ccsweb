<?php if($this->authentication->is_authorized_function_by_name('Privileges/set_privileges')){ ?>
<div class="row ccs-set-privilege-container" style="display: none; padding: 20px; background: #fff">
	<form name="ccs-set-privilege-form" method="POST" action="<?php echo base_url() ?>privileges/set_privileges">
		<div class="col-md-6">
			<span>USER TYPES <i class="icon-asterisk hide" style="color: #B94A48"></i></span><br/><br/>
			<?php foreach($user_types as $user_type){ ?>
				<input type="checkbox" name="user_types[]" id="UT<?php echo $user_type->id ?>" value="<?php echo $user_type->id ?>" /> <label for="UT<?php echo $user_type->id ?>"><?php echo $user_type->name ?></label><br/>
			<?php } ?>
			<div class="ccs-divider" style="margin: 5px 0"></div>
			<input class="ccs-toggle-check-all" id="UTCorUNCA" type="checkbox"/> <label for="UTCorUNCA" style="font-weight: normal">Check or Uncheck All</label>
		</div>
		<div class="col-md-6">
			<span>PRIVILEGES <i class="icon-asterisk hide" style="color: #B94A48"></i></span><br/><br/>
			<?php $flag = TRUE; foreach($privileges as $privilege){ 
				if($flag || $service != $privilege->module_name){
					$service = $privilege->module_name;
					$flag = FALSE;

					echo "<input type='checkbox' class='ccs-module-name' id='$privilege->module_id' value='$privilege->module_id'/> <label for='$privilege->module_id'>$privilege->module_name</label><br/>";
				}
			?>

			<input class="ccs-method-name" type="checkbox" name="privileges[]" id="<?php echo $privilege->module_id.$privilege->id ?>" data-value="<?php echo $privilege->module_id ?>" value="<?php echo $privilege->id ?>" style="margin-left: 15px"/> <label for="<?php echo $privilege->module_id.$privilege->id ?>" style="font-weight: normal"><?php echo $privilege->method_name ?></label><br/>

			<?php } ?>
			<div class="ccs-divider" style="margin: 5px 0"></div>
			<input class="ccs-toggle-check-all" type="checkbox" id="PCorUNCA"/> <label for="PCorUNCA" style="font-weight: normal">Check or Uncheck All</label>

			<div class="row" align="right" style="margin-top: 20px">
				<button class="btn btn-warning" style="border-radius: 0" type="submit"><i class="ic-checkmark"></i> Submit</button>
			</div>
		</div>
	</form>
</div>
<?php } ?>
<?php if($this->authentication->is_authorized_function_by_name('Privileges/set_privileges') || $this->authentication->is_authorized_function_by_name('Privileges/delete_privileges')){ ?>
<div class="row" style="background: #fff;">
	<?php if($this->authentication->is_authorized_function_by_name('Privileges/set_privileges')){ ?>
	<button class="btn btn-default ccs-set-privilege" href="#" style="border-radius: 0"><i class="icon-plus"></i> Set</button>
 	<?php }
 		if($this->authentication->is_authorized_function_by_name('Privileges/delete_privileges')){ ?>
 	<button style="border-radius: 0" href="#" class="btn btn-default ccs-show-delete-privilege"><i class="icon-trash"></i> Delete</button>
 	<?php } ?>
 </div>
 <?php } ?>
<div class="row ccs-privileges">
	<div class="col-md-12 ccs-privileges-show" style="padding: 0">
		<table class="datatable table table-striped table-hover table-bordered" width="100%">
			<thead>
				<tr>
					<th style="text-align: center">ID</th>
					<th>User Type</th>
					<th>Service</th>
					<th>Service Function</th>
				</tr>
			</thead>
			<tbody>
				<?php if($user_privileges){
					$i = 1;
					foreach($user_privileges as $user_privilege){ ?>
					<tr>
						<td><?php echo $user_privilege->id ?></td>
						<td><?php echo $user_privilege->user_type ?></td>
						<td><?php echo $user_privilege->module_name ?></td>
						<td><?php echo $user_privilege->method_name ?></td>
					</tr>
				<?php }}else{ ?>
					<tr>
						<td colspan="4" align="center"><b>No Pending/Affirmed Request Available</b></td>
						<td class="hide"></td>
						<td class="hide"></td>
						<td class="hide"></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-12 ccs-privileges-delete hide" style="padding: 0">
		<form name="ccs-delete-privileges-form" method="POST" action="<?php echo base_url() ?>privileges/delete_privileges">
		<table class="datatable table table-striped table-hover table-bordered" width="100%">
			<thead>
				<tr>
					<th style="text-align: center; vertical-align: middle">ID</th>
					<th style="vertical-align: middle">User Type</th>
					<th style="vertical-align: middle">Service</th>
					<th style="vertical-align: middle">Service Function</th>
					<th style="text-align: center; vertical-align: middle" class="ccs-privileges-delete-checkbox-all" title="Toggle select all rows.">Select All <?php if($user_privileges){ ?><br/><i class="icon-check-empty"></i> <input class="hide" type="checkbox"/><?php } ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if($user_privileges){
					$i = 1;
					foreach($user_privileges as $user_privilege){ ?>
					<tr>
						<td><?php echo $user_privilege->id ?></td>
						<td><?php echo $user_privilege->user_type ?></td>
						<td><?php echo $user_privilege->module_name ?></td>
						<td><?php echo $user_privilege->method_name ?></td>
						<td style="text-align: center" class="ccs-privileges-delete-checkbox"><i class="icon-check-empty"></i><input class="hide" type="checkbox" name="delete_privileges[]" value="<?php echo $user_privilege->id ?>"/></td>
					</tr>
				<?php }}else{ ?>
					<tr>
						<td colspan="5" align="center"><b>No Pending/Affirmed Request Available</b></td>
						<td class="hide"></td>
						<td class="hide"></td>
						<td class="hide"></td>
						<td class="hide"></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.ccs-privileges-show > table').dataTable({
			"sPaginationType": "bs_normal"
	        // "aLengthMenu": [
	        //     [10, 50, 100, -1],
	        //     [10, 50, 100, 'All']
	        // ], 
	        // "iDisplayLength" : -1
		});

		$('.ccs-privileges-delete > form > table').dataTable({
			"sPaginationType": "bs_normal",
	        "aLengthMenu": [
	            [-1],
	            ['All']
	        ], 
	        "iDisplayLength" : -1,
			"aoColumnDefs": [
	          {'bSortable': false, 'aTargets': [ 4 ]}
	       	]
		});

		$('.ccs-privileges-delete > form > div > div:last-child > div > div:eq(1)').hide();
		$('.ccs-privileges-delete > form > div > div:last-child > div > div:eq(0)').css('padding-bottom','35px');
		<?php if($user_privileges){ ?>
		$('<div width="100%" style="margin-top: -6px">\n\
					<button type="submit" class="btn btn-lg btn-warning btn-block ccs-delete-privileges-btn disabled" style="border-radius: 0" disabled><i class="ic-checkmark"></i> Submit</button>\n\
					</div>').insertBefore($('.ccs-privileges-delete > form > div > div:last-child'));
		<?php } ?>
	});
</script>