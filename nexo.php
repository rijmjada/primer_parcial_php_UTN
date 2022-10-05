<?php

require_once("clases/neumatico.php");

$neumatico = new Neumatico("Pirelli", "small", 1230);
$neumatico->guardarJSON("./neumaticos.json");