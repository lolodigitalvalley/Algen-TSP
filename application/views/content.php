<?php
if (!empty($module)) {
	switch ($module) {
	case 'inputdestination':
		include 'module/inputdestination.php';
		break;

	case 'tsp':
		include 'module/tsp.php';
		break;

	case 'direction':
		include 'module/direction.php';
		break;

	default:
		include 'module/inputKota.php';
		break;
	}
}
else{
	include 'module/inputKota.php';
}
?>