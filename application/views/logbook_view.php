<div class="container">
	
	<h1>Log Timeline</h1>
	<p>Use mouse to move and zoom in the timeline by dragging and scrolling in the Timeline</p>
	<div id="visualization"></div>
</div>


<script type="text/javascript" src='<?php echo base_url();?>assets/jquery/jquery-3.2.0.min.js'></script>
<script type="text/javascript" src='<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js'></script>

<script type="text/javascript">
  // DOM element where the Timeline will be attached
var container = document.getElementById('visualization');
var $data=[];
// Create a DataSet (allows two way data-binding)
$.ajax({
	url:'<?php echo base_url("logbook/getLogs"); ?>',
	method:'GET',
	dataType:'json',
	success: function(DBdata){
			logs = DBdata.logs;
			$.each(logs, function(index, value){
				content_value = "User "+value.ipAddress+ " " + value.action+" contact #" + value.contact_id;
				item = {id: parseInt(value.id), content: content_value, start: value.time,title: value.time};
				$data.push(item);
			});

				// Configuration for the Timeline
			var items = new vis.DataSet($data);
				var options = {
			
				  margin: {
				    item: 20
				  }
				};
				  // Create a Timeline
				var timeline = new vis.Timeline(container, items, options);
	},
	error: function(jqXHR, textStatus, errorThrown) {
    	console.log(JSON.stringify(jqXHR));
    	console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
		}
});



</script>

