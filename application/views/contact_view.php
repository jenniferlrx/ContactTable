<div class="container">
	<h1>Contact Table</h1>

	<button class="btn btn-success" id= 'addContact' data-toggle="modal" data-target="#myModal">Add New Contact</button>

	<table class="table table-bordered table-hover" id="main_table_id">
		<thead>
			<th>ID</th>
			<th>Name</th>
			<th>Company</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Country</th>
			<th>Active</th>
			<th>Actions</th>
		</thead>
		<tbody>		
		<?php foreach ($contacts as $contact) {?>
		<tr>
			<td><?php echo $contact->contact_id;?></td>
			<td><?php echo $contact->contact_name;?></td>
			<td><?php echo $contact->company_name;?></td>
			<td><?php echo $contact->contact_phone;?></td>
			<td><?php echo $contact->contact_email;?></td>
			<td><?php echo $contact->country_name?></td>
			<td>Active</td>
			<td> 
				<span class= "activeState" hidden><?php echo $contact->contact_active;?></span>
				<button class="btn btn-warning actions" onclick='editContact(<?php echo $contact->contact_id; ?>)'>Edit</button>
				<button class="btn btn-danger actions" onclick='deleteContact(<?php echo $contact->contact_id; ?>)'>Delete</button>
			</td>	
		</tr>
		<?php } ?>	
		</tbody>
	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Contact Info</h4>
      </div>
      <div class="modal-body">
        <form id="form" class="form-horizontal">
        	<div class="form-group">
		    	<label class="col-sm-2 control-label">Name</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id = 'name' name="inputName">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label class="col-sm-2 control-label">Company</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id = 'Company'  name="inputCompany">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label class="col-sm-2 control-label">Phone</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control"  id = 'phone' name="inputPhone">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label class="col-sm-2 control-label">Email</label>
		    	<div class="col-sm-10">
		      		<input type="email" class="form-control"  id = 'email' name="inputEmail">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label  class="col-sm-2 control-label">Country</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control"  id = 'country' name="inputCountry">
		    	</div>
		  	</div>
		  	<input type="hidden" name="inputContactId">		 
        	<button type="button" id ='saveModal' class="btn btn-primary">Save changes</button>		
        </form>
      </div>
     
    </div>
  </div>
</div>


<script type="text/javascript" src='<?php echo base_url();?>assets/jquery/jquery-3.2.0.min.js'></script>
<script type="text/javascript" src='<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js'></script>
<script type="text/javascript" src='<?php echo base_url();?>assets/Datatables/jquery.dataTables.min.js'></script>
<script type="text/javascript" src='<?php echo base_url();?>assets/Datatables/dataTables.bootstrap.min.js'></script>

<script type="text/javascript">
//setup styles according to data value
$(document).ready(function(){
	$.each($('.activeState'), function(){
		if($(this).html()=='0'){
			$(this).parent().prev().html('Inactive');
			$(this).parent().find('button').removeClass('btn-danger btn-warning').addClass('disabled btn-default');	
			$(this).parent().parent().removeClass('activeRow').addClass('inactiveRow');	
		}
	});
	$('#main_table_id').DataTable();
});


var new_method;
var url;

$('#saveModal').on('click', function(){

	if($('#name').val()=='' || $('#country').val()=='' || $('#company').val()==''|| $('#email').val()=='' || $('#phone').val()==''){
		alert('Please fill out the form');
	}else if(!validatePhone($('#phone').val())){
		alert('Please enter a valid phone number');
	}else if( !validateEmail($('#email').val())) 
			{ alert('Please enter a valid email address');
	}else{
		if(new_method){
			url = '<?php echo base_url('contact/addContact'); ?>';
		}else{
			url = '<?php echo base_url('contact/updateContact'); ?>/';
		}
		console.log($('#form').serialize());
		$.ajax({
			url: url,
			method: 'POST',
			data: $('#form').serialize(),
			dataType:'json',
			success: function(data){
				$('#myModal').modal('hide');
				console.log("here");
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
	        	console.log(JSON.stringify(jqXHR));
	        	console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
			}
		});
	};


});

$('#addContact').on('click', function(){
	new_method = true;
});



function editContact(id){
	new_method = false;
	$.ajax({
		url:'<?php echo base_url("contact/editContact"); ?>/'+id,
		method:'GET',
		dataType:'json',
		success: function(data){

			$('[name = "inputName"]').val(data.contact_name);
			$('[name = "inputCompany"]').val(data.company_name);
			$('[name = "inputPhone"]').val(data.contact_phone);
			$('[name = "inputEmail"]').val(data.contact_email);
			$('[name = "inputCountry"]').val(data.country_name);
			$('[name = "inputContactId"]').val(data.contact_id);
			$('#myModal').modal('show');
		},
		error: function(jqXHR, textStatus, errorThrown) {
        	console.log(JSON.stringify(jqXHR));
        	console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
 }
	});
}


function deleteContact(id){
	$.ajax({
		url:"<?php echo base_url('contact/deleteContact') ?>/"+id,
		method:'POST',
		success: function(){
			location.reload();
		},
		error: function(jqXHR, textStatus, errorThrown) {
        	console.log(JSON.stringify(jqXHR));
        	console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
		}
	});
}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}

function validatePhone($phone)  
{  
    var phoneReg =/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/
    return phoneReg.test( $phone );
}  
</script>