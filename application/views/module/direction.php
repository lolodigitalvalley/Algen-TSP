
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Genetic Algorithm</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Traveling Salesman Problem
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

 <?php
	$origin      = $origin;
	$destination = $dest;
?>
<div class="item">           
    <div class="row">
     	 <div id="panel-direction" class="col-md-4"></div> 
         <div id="map-direction" class="col-md-8" style="height:1000px; padding:0 10px;"></div>   
    </div>
</div>

   <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&language=id&libraries=geometry"></script>
   <script type="text/javascript"> 

     var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();

     var map = new google.maps.Map(document.getElementById('map-direction'), {
       zoom:7,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     });

     directionsDisplay.setMap(map);
     directionsDisplay.setPanel(document.getElementById('panel-direction'));

     var request = {
       origin: '<?php echo $origin; ?>', 
       destination: '<?php echo $destination; ?>',
       travelMode: google.maps.DirectionsTravelMode.DRIVING
     };

     directionsService.route(request, function(response, status) {
       if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(response);
       }
     });
   </script> 
			
            </div>
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
