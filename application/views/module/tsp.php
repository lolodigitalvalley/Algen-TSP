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

$chromosom = array( 0 => array ( 'label' => 1, 'name' => 'Stasiun Ka Tugu Yogyakarta', 'lat' => '-7.789198799999999', 'lng' => '110.36346630000003', 'latlng' => '(-7.789198799999999, 110.36346630000003)' ), 
                     1 => array ( 'label' => 2, 'name' => 'Jalan Malioboro Yogyakarta', 'lat' => '-7.7940023', 'lng' => '110.36565350000001', 'latlng' => '(-7.7940023, 110.36565350000001)' ), 
                     2 => array ( 'label' => 3, 'name' => 'Kompleks Taman Pintar Yogyakarta', 'lat' => '-7.800767999999999', 'lng' => '110.36813299999994', 'latlng' => '(-7.800767999999999, 110.36813299999994)' ), 
                     3 => array ( 'label' => 4, 'name' => 'Jalan Monumen Jogja Kembali Yogyakarta', 'lat' => '-7.757295099999999', 'lng' => '110.3697621', 'latlng' => '(-7.757295099999999, 110.3697621) '), 
                     4 => array ( 'label' => 5, 'name' => 'Gembira Loka Zoo Yogyakarta', 'lat' => '-7.8038943', 'lng' => '110.3978128', 'latlng' => '(-7.8038943, 110.3978128)' ), 
                     5 => array ( 'label' => 6, 'name' => 'Pantai Depok Yogyakarta', 'lat' => '-8.0137087', 'lng' => '110.29147769999997', 'latlng' => '(-8.0137087, 110.29147769999997)' ) ); 

$distance_list = array ( 0 => array (0 =>0, 1 => 1544, 2 => 2829, 3 => 5036, 4 => 5327, 5 => 29294 ), 
        1 => array ( 0 => 2327, 1 =>0, 2 => 1285, 3 => 6093, 4 => 4334, 5 => 28301 ), 
        2 => array ( 0 => 3376, 1 => 1952, 2 =>0, 3 => 5934, 4 => 4226, 5 => 27362 ), 
        3 => array ( 0 => 4044, 1 => 4805, 2 => 6090, 3 =>0, 4 => 8545, 5 => 32555 ), 
        4 => array ( 0 => 6750, 1 => 5055, 2 => 4274, 3 => 8465, 4 =>0, 5 => 32712 ), 
        5 => array ( 0 => 29571, 1 => 29022, 2 => 27996, 3 => 41060, 4 => 29978, 5 =>0 ) );

$duration_list = array ( 0 => array ( 0 =>0, 1 => 340, 2 => 634, 3 => 873, 4 => 942, 5 => 3284 ), 
        1 => array ( 0 => 479, 1 =>0, 2 => 293, 3 => 1088, 4 => 829, 5 => 3165 ), 
        2 => array ( 0 => 649, 1 => 417, 2 =>0, 3 => 1107, 4 => 786, 5 => 2980 ), 
        3 => array ( 0 => 697, 1 => 881, 2 => 1175, 3 =>0, 4 => 1390, 5 => 3825 ), 
        4 => array ( 0 => 1149, 1 => 1032, 2 => 972, 3 => 1467, 4 =>0, 5 => 3216 ), 
        5 => array ( 0 => 3412, 1 => 3395, 2 => 3147, 3 => 3903, 4 => 3186, 5 =>0 ) );

$chromosomx = json_encode($chromosom);
$chromosom = json_decode($chromosomx);

$dna         = array();
$distanceTbl = '';
$durationTbl = '';
$disxdurTbl  = '';

for ($i = 0; $i < count($chromosom); $i++) {
    array_push($dna, $chromosom[$i]->label);
    $distanceTbl .= '<tr><td width="125px">C' . $chromosom[$i]->label . '</td>';
    $durationTbl .= '<tr><td width="125px">C' . $chromosom[$i]->label . '</td>';
    $disxdurTbl  .= '<tr><td width="125px">C' . $chromosom[$i]->label . '</td>';
    for ($j = 0; $j < count($distance_list[$i]); $j++) {
        $distance = isset($_POST['distance_' . ($i + 1) . '_' . ($j + 1)]) ? $_POST['distance_' . ($i + 1) . '_' . ($j + 1)] : ($distance_list[$i][$j] / 1000);
        $duration = isset($_POST['duration_' . ($i + 1) . '_' . ($j + 1)]) ? $_POST['duration_' . ($i + 1) . '_' . ($j + 1)] : ($duration_list[$i][$j] / 60);
        $disxdur  = $distance * $duration;
        $distanceTbl .= '<td width="125px"><input type="text" name="distance_' . ($i + 1) . '_' . ($j + 1) . '"  value="' . round($distance, 3) . '" /></td>';
        $durationTbl .= '<td width="125px"><input type="text" name="duration_' . ($i + 1) . '_' . ($j + 1) . '"  value="' . round($duration, 3) . '" /></td>';
        $disxdurTbl  .= '<td width="125px"><input type="text" name="' . ($i + 1) . '_' . ($j + 1) . '"  value="' . round($disxdur, 3) . '" /></td>';

    }
    $distanceTbl .= '</tr>'; 
    $durationTbl .= '</tr>'; 
    $disxdurTbl  .= '</tr>';
}

echo '<div class="table-responsive">
<form method="post" action="'.site_url('tsp/calculate').'">';
echo '<table class="table table-striped table-bordered">
    <tr><td><strong>Dari/Ke</strong></td>';
for ($i = 0; $i < count($chromosom); $i++) {
    echo '<td width="125px">C' . $chromosom[$i]->label . '</td>';
}
echo '</tr>';
echo $distanceTbl;
echo '</table>';

echo '<table class="table table-striped table-bordered">
    <tr><td><strong>Dari/Ke</strong></td>';
for ($i = 0; $i < count($chromosom); $i++) {
    echo '<td width="125px">C' . $chromosom[$i]->label . '</td>';
}
echo '</tr>';
echo $durationTbl;
echo '</table>';

echo '<table class="table table-striped table-bordered">
    <tr><td><strong>Dari/Ke</strong></td>';
for ($i = 0; $i < count($chromosom); $i++) {
    echo '<td width="125px">C' . $chromosom[$i]->label . '</td>';
}
echo '</tr>';
echo $disxdurTbl;
echo '</table>';

echo '<input type="hidden" name="chromosom" value=\'' . json_encode($chromosom) . '\' />
        <input type="hidden" name="distanceList" value=\'' . json_encode($distance_list) . '\' />
        <input type="hidden" name="durationList" value=\'' . json_encode($duration_list) . '\' />
        <input type="hidden" name="dna" value=\'' . json_encode($dna) . '\' />
        <br/>
        <input type="submit" name="calculate" id="button" value="Calculate Shortest Route" />
        </form>
        </div><br/><br/>';

echo '<ul>';
for ($i = 0; $i < count($chromosom); $i++) echo '<li>C' . $chromosom[$i]->label . ' : ' . $chromosom[$i]->name . '</li>';
echo '</ul>';

if (!empty($_POST['calculate'])) {
    $this->benchmark->mark('code_start');

    define('CITY_COUNT', count($dna));

    
    if(CITY_COUNT < 8){
    	$population  = 30;
        $pc          = 0.35;
        $pm          = 0.05;
    }
    else{
    	$population  = 180;
        $pc          = 0.35;
        $pm          = 0.05;
    }
    

    $algen = new Algen();


    $distances   = array();
    $initialPopulation = array();

    unset($dna[0]);

    # Ambil Jarak Point dan simpan dalam array
    for ($i = 1; $i <= CITY_COUNT; $i++) {
        for ($j = 1; $j <= CITY_COUNT; $j++) {
            if (isset($_POST[$i . '_' . $j])) {
                $distances[$i][$j] = $_POST[$i . '_' . $j];
            } else if (isset($_POST[$j . '_' . $i])) {
                $distances[$i][$j] = $_POST[$j . '_' . $i];
            } else {
                $distances[$i][$j] = 32767;
            }
        }
    }

    # Bangkitkan Initial Populasi
    $initialPopulation = $algen->initialPopulation($dna, $population);

    $best_chromosom = '';
    $best_fitness   = 0;
    $k    = 1;
    $stop = false;

    while($stop != true){
        $currentPopulation = array();
        $newPopulation     = array();

        //Mencari jarak tiap kromosom/populasi dari initial populasi
        $i = 0;
        $distanceSum = 0;
        foreach ($initialPopulation as $entity) {
            $currentPopulation[$i]['dna']     = $entity;
            $currentPopulation[$i]['cost']    = $algen->rate($entity, $distances);
            $currentPopulation[$i]['fitness'] = 1 / $currentPopulation[$i]['cost'];
            $distanceSum += $currentPopulation[$i]['fitness'];
            $i++;
        }

        $chancesSum = 0;
        for ($i = 0; $i < $population; $i++) {
            //Mencari probabilitas
            $currentPopulation[$i]['metric'] = $currentPopulation[$i]['fitness'] / $distanceSum;
            //Mendapatakan Kumulatif probabilitas
            $chancesSum += $currentPopulation[$i]['metric'];
            $currentPopulation[$i]['chances'] = $chancesSum;
        }

        /*
        if ($k == 1) {
            echo '<h4>Generation - 0</h4>';
            $algen->debug($currentPopulation);
        }
        */
        $newPopulation = $algen->survivalSelection($currentPopulation, $population);

        //Crossover
        for ($i = 0; $i < $population - 1; $i++) {
            $rand = rand(0, 100) / 100;
            if ($rand < $pc) {
                $crossover                    = $algen->crossover($newPopulation[$i]['dna'], $newPopulation[$i + 1]['dna']);
                $newPopulation[$i]['dna']     = implode('-', $crossover[0]);
                $newPopulation[$i + 1]['dna'] = implode('-', $crossover[1]);
            }
        }

        //Mutation
        for ($i = 0; $i < count($newPopulation); $i++) {
            $rand = rand(0, 100) / 100;
            if ($rand < $pm) {
                $mutation                 = $algen->mutation($newPopulation[$i]['dna']);
                $newPopulation[$i]['dna'] = implode('-', $mutation);
            }
        }

        $distanceSum = 0;
        for ($i = 0; $i < $population; $i++) {
            $finalPopulation[$i]['dna']     = $newPopulation[$i]['dna'];
            $finalPopulation[$i]['cost']    = $algen->rate($finalPopulation[$i]['dna'], $distances);
            $finalPopulation[$i]['fitness'] = 1 / $finalPopulation[$i]['cost'];
            $distanceSum += $finalPopulation[$i]['fitness'];
        }

        $chancesSum = 0;
        for ($i = 0; $i < $population; $i++) {
            $finalPopulation[$i]['metric'] = $finalPopulation[$i]['fitness'] / $distanceSum;
            $chancesSum += $finalPopulation[$i]['metric'];
            $finalPopulation[$i]['chances'] = $chancesSum;
        }
        
        /*
        echo '<h4>Generation - ' . $k . '</h4>';
        $algen->sort($finalPopulation, 'chances');
        $algen->debug($finalPopulation);
        */
        $algen->sort($finalPopulation, 'fitness');
        if ($finalPopulation[$population - 1]['fitness'] > $best_fitness) {
            $best_chromosom  = $finalPopulation[$population - 1]['dna'];
            $best_fitness    = $finalPopulation[$population - 1]['fitness'];
            $th = 0;
        }

        $k++;
        $th++;

        if($th > 30){
            $stop = true; 
        }
        else{
            $initialPopulation = $algen->initialPopulation($dna, $population-1);
            $initialPopulation[$population] = $best_chromosom;
        }
    }

    echo '<div>Solusi Terbaik Yang Ditemukan Adalah <strong>' . $best_chromosom . '</strong> dengan fitness <strong>' . $best_fitness . '</strong> dengan <strong>' . $k . '</strong> generations.</div>';

    echo '<ul>';
    for ($i = 0; $i < count($chromosom); $i++) {
        echo '<li>' . $chromosom[$i]->label . ' : ' . $chromosom[$i]->name . '</li>';
    }
    echo '</ul>';

    $dna = explode('-', $best_chromosom);
    echo '<table class="table table-striped table-bordered">
    <tr><td>Perjalan Ke - </td><td>Rekomendasi Tujuan</td><td>Estimasi Jarak</td><td>Estimasi Waktu</td><td>Rute</td></tr>';
    
    $distanceSum = 0;
    $durationSum = 0;
    for ($i = 0; $i < count($dna) - 1; $i++) {
        $origin_latlng = $chromosom[$dna[$i]-1]->lat . ', ' . $chromosom[$dna[$i]-1]->lng;
        $dest_latlng   = $chromosom[$dna[$i+1]-1]->lat . ', ' . $chromosom[$dna[$i+1]-1]->lng;
        $distance      = $distance_list[$dna[$i]-1][$dna[$i+1]-1] / 1000;
        $duration      = $duration_list[$dna[$i]-1][$dna[$i+1]-1] / 60;
        $distanceSum  += $distance;
        $durationSum  += $duration;

        echo '<tr>
        <td>' . ($i + 1) . '</td>
        <td>' . $chromosom[$dna[$i]-1]->name . ' ke ' . $chromosom[$dna[$i+1]-1]->name . '</td>
        <td>' . round($distance, 3) . ' Km</td>
        <td>' . round($duration, 2) . ' menit</td>
        <td><a class="more-link" target="_BLANK" href="direction?origin=' . $origin_latlng . '&dest=' . $dest_latlng . '">Rute</a></td>
        </tr>';
    }
    echo '<tr><td colspan="2">Total</td><td>'.round($distanceSum, 3). ' Km</td><td>'. round($durationSum, 2) . ' menit</td><td></td></tr>';
    echo '</table>';

    $this->benchmark->mark('code_end');
  
    echo 'Waktu Eksekusi : <b>'.$this->benchmark->elapsed_time('code_start', 'code_end').' seconds </b>'.br(1);
    echo 'Memori Yang Digunakan : <b>'.$this->benchmark->memory_usage().'</b>';
}
?>
            </div>
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>