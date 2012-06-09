<?php
$from = $_GET['from'];
$to = $_GET['to'];
$date = $_GET['date'];
error_reporting(E_ALL);
$f = file_get_contents("http://www.slo-zeleznice.si/sl/potniki/slovenija/vozni-redi/vozni-red-s-cenikom?entrystation=".$from."&via=-1&exitstation=".$to."&date=".$date);

$x = preg_match("/<li class=\"relFirst\">(.*) - (.*)<\/li>/", $f,$out);
$from_name = $x[1];
$to_name = $x[2];
$f=str_replace("</tr><tr class=\"tableRow1\">", "</tr>
<tr>", $f);
$f=str_replace("</tr><tr>", "</tr>
<tr>", $f);
preg_match_all("/<tr><td(.*)><a href=\"(.*)\" title=\"\" class=\"thickbox\">(.*)<\/a><\/td><td class=\"icons\">(.*)<\/td><td class=\"dest\">(.*)<\/td><td class=\"time\">(.*)<\/td><td class=\"dest\">(.*)<\/td><td class=\"time\">(.*)<\/td><td class=\"vtop\" rowspan=\"1\">(.*)<\/td><td class=\"vtop\" rowspan=\"1\"><a href=\"(.*)\"  class=\"thickbox\">Cene<\/a><\/td><td class=\"vtop\" rowspan=\"1\"><a href=\"(.*)\" title=\"\" class=\"thickbox\">Poglej<\/a><\/td><\/tr>/",
$f, $out, PREG_SET_ORDER);

$vlaki = array();

foreach($out as $vlak) {
	$a = array(
		'name' => $vlak[3],
		'from' => $vlak[5],
		'to' => $vlak[7],
		'from_time' => $vlak[6],
		'to_time' => $vlak[8],
		'cost_url' => $vlak[10],
		'detail_url' => $vlak[11]
	);
	
	$vlaki[] = $a;
}
echo json_encode($vlaki);
?>
