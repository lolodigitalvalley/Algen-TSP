<!-- jQuery -->
<!--
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&language=id&libraries=geometry,weather"></script>
-->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQxFMPwj80PFpdF8QkDjQsTakKKIi0zfQ&language=id&libraries=geometry,weather" type="text/javascript"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/';?>js/inputDestination.js"></script>

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

			<form action="<?php echo site_url('tsp/initiation'); ?>" method="post" id="myform" role="form">
            <input type="hidden" name="chromosom" id="chromosom"/>
            <input type="hidden" name="distanceList" id="distanceList"/>
            <input type="hidden" name="durationList" id="durationList"/>
			<div class="form-group">
				<label>Origin : </label>
				<div class="row">
					<div class="col-md-3">
						<input class="form-control" type="text" name="origin" id="origin"/>
					</div>
					<button type="button" id="add-origin" class="btn btn-primary" style="cursor:pointer;">Tambah</button>
				</div>
			</div>
			<br>
			<div id="tabel-origin">
				<table class="table">
				<thead>
				<tr>
					<td>Lokasi Saya</td><td>Latitude</td><td>Longitude</td><td>Hapus</td>
				</tr>
				</thead>
				<tbody id="body-origin"></tbody>
				</table>
			</div>
			<br/><br/><br/>
			<div class="form-group">
				<label>Destination : </label>
				<div class="row">
					<div class="col-md-3"><input class="form-control" type="text" name="destination" id="destination"/></div>
					<button type="button" id="add-dest" class="btn btn-primary" style="cursor:pointer;">Tambah</button>
				</div>
			</div>

			<br>
			<div id="tabel-dest">
				<table class="table">
				<thead>
				<tr>
					<td>Nama tempat Wisata</td><td>Alamat</td><td>LatLong</td><td>Hapus</td>
				</tr>
				</thead>
				<tbody id="body-dest"></tbody>
				</table>
			</div>
			<div class="col-md-3">
                <input type="button" name="inisiasi" id="inisiasi" value="Inisiasi" class="btn btn-primary" />
            </div>
		    </form>
		    <br/><br/>
		    <ul id="output"></ul>
            </div>
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
