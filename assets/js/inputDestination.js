$(document).ready(function() {
    var num_dest = 0;
    var text;
    var chromosom;

    $("#add-origin").click(function(){
    	var origin = $('#origin').val();
        if($.isNumeric(origin)){
            alert('Data yang dimasukan tidak valid');
        }
        else{  
            origin = origin.toLowerCase() + ' yogyakarta';        
            findLocation(origin, function(result){
                if(result[0] != 'Yogyakarta' ){
                    $('#body-origin').append(
                      '<tr class="row-origin">'
                       + '<input id="latlng" name="latlng" value="'+ result[2] +'" type="hidden">'
                         + '<input id="lat" name="lat" value="'+ result[2].lat() +'" type="hidden">'
                         + '<input id="lng" name="lng" value="'+ result[2].lng() +'" type="hidden">'
                       + '<td><input class="form-control" id="origin" name="origin" type="text" value="'+ result[0] +' Yogyakarta" readonly /></td>'
                       + '<td><input class="form-control" value="'+ result[1] +'" type="text"/></td>'
                       + '<td><input class="form-control" value="'+ result[2].lat() + ',' + result[2].lng() +'" type="text"/></td>'
                       + '<td><input class="btn btn-danger" type="button" id="del-origin" value="Hapus"></td></tr>'
                    );
                }
                else{
                    alert('Lokasi tidak ditemukan');
                }
        });
        }
    });

    $(document).on('click', '#del-origin', function () {
        $(this).parents(".row-origin").remove();
    });

    $("#add-dest").click(function(){
        var destination = $('#destination').val();
        if($.isNumeric(destination)){
            alert('Data yang dimasukan tidak valid');
        }
        else{ 
            destination = destination.toLowerCase() + ' yogyakarta';
            num_dest ++;
            findLocation(destination, function(result){
                if(result[0] != 'Yogyakarta' ){
                    $('#body-dest').append(
                      '<tr class="row-dest">'
                       + '<input name="num_dest[]" value="'+ num_dest +'" type="hidden">'
                         + '<input id="latlng_' + num_dest +'" name="latlng_' + num_dest +'" value="'+ result[2] +'" type="hidden">'
                         + '<input id="lat_' + num_dest +'" name="lat_' + num_dest +'" value="'+ result[2].lat() +'" type="hidden">'
                         + '<input id="lng_' + num_dest +'" name="lng_' + num_dest +'" value="'+ result[2].lng() +'" type="hidden">'
                       + '<td><input class="form-control" id="dest_'+ num_dest +'" name="dest_'+ num_dest +'" type="text" value="'+ result[0] +' Yogyakarta" readonly /></td>'
                       + '<td><input class="form-control" value="'+ result[1] +'" type="text"/></td>'
                       + '<td><input class="form-control" value="'+ result[2].lat() + ',' + result[2].lng() +'" type="text"/></td>'
                       + '<td><input class="btn btn-danger" type="button" id="del-dest" value="Hapus"></td></tr>'
                    );
                }else{
                    alert('Lokasi tidak ditemukan');
                }
            });
        }
    });

    $(document).on('click', '#del-dest', function () {
        $(this).parents(".row-dest").remove();
        num_dest = num_dest - 1;
    });

    /* Begin Inisiasi and Submit Form */
    $('#inisiasi').click(function(){
        var origin = $('#origin').val();
        if($('#origin').val().length > 0){
            if(num_dest > 2){
                chromosom = new Array();
                /* Begin Push origin and destination in JSON */
                chromosom.push($('#body-origin #origin').val());
                text = '[{ "label": "1", "name": "'+ $('#body-origin #origin').val() + '", "lat": "'+$('#body-origin #lat').val() +'", "lng": "'+$('#body-origin #lng').val() +'", "latlng": "'+$('#body-origin #latlng').val() +'"},';
                for(i=1; i<=num_dest; i++){
                    chromosom.push($('#body-dest #dest_'+i).val());
                    text = text + '{ "label" : "' + (i+1) + '", "name": "'+ $('#body-dest #dest_'+i).val() + '", "lat": "'+ $('#body-dest #lat_'+i).val() + '", "lng": "'+ $('#body-dest #lng_'+i).val() + '", "latlng": "'+$('#body-dest #latlng_'+i).val() +'"}';
                    if(i != num_dest) text = text + ',';
                }
                text = text + ']';
                /* End Push origin and destination in JSON */

                /* Begin Calculate Distance and duration */
                var service = new google.maps.DistanceMatrixService;
                service.getDistanceMatrix({
                    origins: chromosom,
                    destinations: chromosom,
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.METRIC,
                    avoidHighways: false,
                    avoidTolls: false
                }, function(response, status) {
                    if (status !== google.maps.DistanceMatrixStatus.OK) {
                        alert('Error was: ' + status);
                    } else {
                        var originList = response.originAddresses;
                        var destinationList = response.destinationAddresses;
                        var distanceList = new Array();
                        var durationList = new Array();

                        /* Begin Capture Distance and duration */
                        for (var i = 0; i < originList.length; i++) {
                            var results = response.rows[i].elements;
                            distanceList[i] = new Array();
                            durationList[i] = new Array();
                            for (var j = 0; j < results.length; j++) {                              
                                if(originList[i] != destinationList[j])
                                {
                                    distanceList[i][j] = results[j].distance.value;
                                    durationList[i][j] = results[j].duration.value;
                                }
                                else{
                                    distanceList[i][j] = null;
                                    durationList[i][j] = null;
                                }
                            }
                        }
                        /* Capture Distance and duration */

                        $('#chromosom').val(text);
                        $('#distanceList').val(JSON.stringify(distanceList));
                        $('#durationList').val(JSON.stringify(durationList));
                        $('#myform').submit();
                    }
                });
                /* End Calculate Distance and duration */
            }/* End Check Num Object */
            else{
                alert('Jumlah objek harus lebih besar 4.');
            }
        }/* End Check Empty Origin */
        else{
            alert('Lokasi awal tidak boleh kosong.');
        }

    });
    /* End Inisiasi and Submit Form */
});


function findLocation(locationName, fn) {
    var gc = new google.maps.Geocoder();
    gc.geocode({address: locationName}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var position = [results[0].address_components[0].long_name, results[0].formatted_address, results[0].geometry.location];
            fn(position);
        }
    });
}