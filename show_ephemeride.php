<?php


include 'ephemeride.php';
include("header_index.php");
include("nav_bar_index.php");


$date = $_GET['date'];

$date = str_replace("/", "-", $date);

#We need to transform the date format.
#Best way: 
#Check with preg_match("^\\d{1,2}/\\d{2}/\\d{4}^", "datehere");
#Change with echo implode("-", array_reverse(explode("/", $var)));

#We validate the date

if (preg_match('/[^\-0-9]/', $date)) {
    $date = "1960-01-03";
    echo '<div id="results"><p>Almanac results for the default day '.$date.'. Please change your query to get correct results.</p></div>';
} else {
	echo '<div id="results"><p>Almanac results for '.$date.'</p></div>';
}


#We change potentially the order of the date:
if(preg_match("^\\d{2}-\\d{2}-\\d{4}^", $date)) {
	$date = implode("-", array_reverse(explode("-", $date)));
}

$json = retrieve_wikidata($date);

$json = $json["results"]["bindings"];

#We initiate all the types:

$list_entity=[];

$birth = [];
$death = [];
$inception = [];
$discovery = [];
$disparition = [];
$publication = [];
$performance = [];

foreach($json as $item) {
    $url = $item["entity"]["value"];
    $entity = $item["entityLabel"]["value"];
    $description = $item["description"]["value"];
    $value = $item["value"]["value"];
    $type = $item["typeLabel"]["value"];

    if(in_array($entity, $list_entity)) {
		$summary = '';
	} else {
		$summary = '<p><a href="'.$url.'"">'.$entity."</a>, ".$description.'</p>';
		array_push($list_entity, $entity);
	}

    switch ($value) {

    	case "birth":
    		array_push($birth, $summary);
    		break;
    	case "death":
    		array_push($death, $summary);
    		break;
    	case "inception":
    		array_push($inception, $summary);
    		break;
    	case "discovery":
    		array_push($discovery, $summary);
    		break;
    	case "disparition":
    		array_push($disparition, $summary);
    		break;
    	case "publication_date":
    		array_push($publication, $summary);
    		break;
    	case "first_performance":
    		array_push($performance, $summary);
    		break;

    }

}

#We iterate over the birth
if (!(empty($birth))) {

	echo "<h3>Birth</h3><div>";

	foreach($birth as $current_birth) {
      echo $current_birth;
	}

	echo "</div>";
}

if (!(empty($death))) {

	echo "<h3>Death</h3><div>";

	foreach($death as $current_death) {
      echo $current_death;
	}
	
	echo "</div>";
}

if (!(empty($inception))) {

	echo "<h3>Inception/Foundation</h3><div>";

	foreach($inception as $current_inception) {
      echo $current_inception;
	}
	
	echo "</div>";
}


if (!(empty($discovery))) {

	echo "<h3>Discovery</h3><div>";

	foreach($discovery as $current_discovery) {
      echo $current_discovery;
	}
	
	echo "</div>";
}

if (!(empty($disparition))) {

	echo "<h3>Disparition/Dissolution</h3><div>";

	foreach($disparition as $current_disparition) {
      echo $current_disparition;
	}
	
	echo "</div>";
}

if (!(empty($publication))) {

	echo "<h3>Publication/Release</h3><div>";

	foreach($publication as $current_publication) {
      echo $current_publication;
	}
	
	echo "</div>";
}

if (!(empty($performance))) {

	echo "<h3>Performance</h3><div>";

	foreach($performance as $current_performance) {
      echo $current_performance;
	}
	
	echo "</div>";
}

?>

</div></div></body></html>

