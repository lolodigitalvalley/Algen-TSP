<?php
class Algen{

	private $sortfield = null;
    private $sortorder = 1;

    private function sort_callback(&$a, &$b)
    {
        if ($a[$this->sortfield] == $b[$this->sortfield]) {
            return 0;
        }

        return ($a[$this->sortfield] < $b[$this->sortfield]) ? -$this->sortorder : $this->sortorder;
    }

    public function sort(&$v, $field, $asc = true)
    {
        $this->sortfield = $field;
        $this->sortorder = $asc ? 1 : -1;
        usort($v, array('algen', 'sort_callback'));
    }
    
    public function initialPopulation($dna, $population){
        $initialPopulation = array();
        for ($i = 0; $i < $population; $i++) {
            $initialPopulation[$i] = $this->pickRandom($dna);
            while (!in_array($initialPopulation[$i], $initialPopulation)) {
                $initialPopulation[$i] = $this->pickRandom($dna);
            }
        }
        return $initialPopulation;
    }

    public function survivalSelection($currentPopulation, $population){
        $newPopulation = array();
        for ($i = 0; $i < $population; $i++) {
            $newPopulation[$i]['dna']     = $currentPopulation[$i]['dna'];
            $newPopulation[$i]['cost']    = $currentPopulation[$i]['cost'];
            $newPopulation[$i]['fitness'] = $currentPopulation[$i]['fitness']; 
            $newPopulation[$i]['metric']  = $currentPopulation[$i]['metric'];
            $newPopulation[$i]['chances'] = $currentPopulation[$i]['chances'];
        }

        for ($i = 0; $i < $population; $i++) {
            $roulette   = rand(0, 100) / 100;
            for ($j = 0; $j < $population; $j++) {
                if ($roulette < $currentPopulation[$j]['chances']) {
                    $newPopulation[$i]['dna']     = $currentPopulation[$j]['dna'];
                    $newPopulation[$i]['cost']    = $currentPopulation[$j]['cost'];
                    $newPopulation[$i]['fitness'] = $currentPopulation[$j]['fitness'];
                    $newPopulation[$i]['metric']  = $currentPopulation[$j]['metric'];
                    $newPopulation[$i]['chances'] = $currentPopulation[$j]['chances'];
                }
                break;
            }
        }

        return $newPopulation;
    }

    public function crossover($parent1, $parent2)
    {
        $child1   = array();
        $child2   = array();
        $return   = array();
        $parent1 = explode('-', $parent1);
        $parent2 = explode('-', $parent2);


        //cycle crossover
        $stop      = $parent1[1];
        $child1[1] = $parent1[1];
        $child2[1] = $parent2[1];
        $x         = 1;
        while ($parent2[$x] != $stop) {
            $x          = array_search($parent2[$x], $parent1);
            $child1[$x] = $parent1[$x];
            $child2[$x] = $parent2[$x];
        }

        //Pindah silang parent1 ke parent2 dan sebaliknya
        for ($i = 0; $i < count($parent1); $i++) {
            if (empty($child1[$i])) {
                $child1[$i] = $parent2[$i];
            }

            if (empty($child2[$i])) {
                $child2[$i] = $parent1[$i];
            }
        }

        ksort($child1, SORT_NUMERIC);
        ksort($child2, SORT_NUMERIC);
        $return[0] = $child1;
        $return[1] = $child2;

        return $return;
    }

    public function mutation($dna)
    {
        $dna    = explode('-', $dna);
        $max    = count($dna) - 1;
        $rand1  = 0;
        $rand2  = 0;
        while ($rand1 == $rand2) {
            $rand1 = rand(2, $max);
            $rand2 = rand(2, $max);
        }
        $temp            = $dna[$rand1 - 1];
        $dna[$rand1 - 1] = $dna[$rand2 - 1];
        $dna[$rand2 - 1] = $temp;
        
        return $dna; 
    }

    private function pickRandom($choices)
    {
        shuffle($choices);
        $choices = implode('-', $choices);
        return '1-' . $choices . '-1';
    }

    public function rate($dna, $distances)
    {
        $mileage = 0;
        $dna = explode('-', $dna);

        for ($i = 0; $i < CITY_COUNT; $i++) {
            $mileage += $distances[$dna[$i]][$dna[$i + 1]];
        }
        return $mileage;
    }

    public function debug($ar)
	{
    	
    	$print = "<table class='table table-striped table-bordered'>";
    	$print .= "<tr><th>&nbsp;</th><th>DNA</th><th>Cost</th><th>Fitness</th><th>Prob</th><th>Kum Prob</th><th>Roulette</th></tr>\n";
    	foreach ($ar as $element => $value) {
        	$print .= "<tr><td>" . $this->leadingZero($element) . "</td><td>" . $value['dna'] . "</td><td>" . $value['cost'] . "</td><td>" . round($value['fitness'], 5) . "</td><td>" . round($value['metric'], 5) . "</td><td>" . round($value['chances'], 5) . "</td><td>" . sprintf("%01.2f", $value['chances'] * 100) . "%</td></tr>\n";
    	}
    	$print .= "</table>\n";

    	echo $print;
	}

	private function leadingZero($value)
	{
	    if ($value < 10) {
	        $value = '00' . $value;
	    } else if ($value < 100) {
	        $value = '0' . $value;
	    }

	    return $value;
	}

    public function faktorial($n)
    {
        if ($n <= 1) {
            return 1;
        } else {
            return $n * faktorial($n - 1);
        }
    }
}
?>