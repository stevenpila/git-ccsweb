<div class="row user-type-row">
	<div class="col-md-12 ccs-request-user-type">
		<table class="datatable table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>User Type</th>
					<th>Status</th>
					<th>Date Requested</th>
					<th>Date Affirmed</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($user_type_requests){
					$i = 1;
					foreach($user_type_requests as $user_type_request){ ?>
					<tr>
						<td data-value="<?php echo $user_type_request->id ?>"> 
							<a class="accordion-collapse" href="#accordion<?php echo $i++ ?>">
								<i class="ic-arrow-down"></i>
							</a>
						</td>
						<td><?php echo ucwords($user_type_request->requestor_name) ?></td>
						<td><?php echo ($user_type_request->status == 'Pending')?$user_type_request->user_type:$this->authentication->user_type($user_type_request->affirmedusertypeid) ?></td>
						<td class="<?php echo $user_type_request->status ?>"><span><?php echo $user_type_request->status ?></span></td>
						<td><?php echo date('F d, Y', strtotime($user_type_request->daterequested)) ?></td>
						<td><?php echo ($user_type_request->dateaffirmed)?date('F d, Y', strtotime($user_type_request->dateaffirmed)):'------' ?></td>
					</tr>
				<?php }}else{ ?>
					<tr>
						<td colspan="6" align="center"><b>No Pending Request Available</b></td>
						<td class="hide"></td>
						<td class="hide"></td>
						<td class="hide"></td>
						<td class="hide"></td>
						<td class="hide"></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
        $('.ccs-request-user-type > table').dataTable({ 
            "sPaginationType": "bs_normal",
			"aoColumnDefs": [
	          {'bSortable': false, 'aTargets': [ 0 ]}
	       	]
        });
	});
</script>