<?php 
//https://stackoverflow.com/questions/37332108/fputcsv-columns-from-table-displayed-in-one-column

/*
$file="demo.xls";
$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;


$start_row = 2; //define start row
$i = 1; //define row count flag
$file = fopen("newfile.csv", "r");
while (($row = fgetcsv($file)) !== FALSE) {
    if($i >= $start_row) {
        print_r($row);
		echo "</br>".$row[1];
        //do your stuff
    }
    $i++;
}
fclose($file);
*/

$lista = array (
    array('A1', 'B1', 'C1', 'D1'),
    array('A2', 'B2', 'C2'),
    array('A3', 'B3')
);

$fp = fopen('newfile.csv', 'w');
foreach ($lista as $linha) {
    fputcsv($fp, $linha, ';');
}

fclose($fp);


/*
$array_site1 = array("user11","user21","user31");
$array_site2 = array("user12","user22","user32","user42","user52");
$array_site3 = array("user13","user23","user33");
*/

<?php
$url = array(
	'http://www.clubmodel.com.br',
	'http://www.linkrosa.com.br',
	'http://www.mclass.com.br/acompanhantes'
);

$array_1 = array(
	'div class="acompanhante_name"',
	'div class="lf-head-btn "',
	'p class="info m-b-0 text-xs-center"'
);
	
$array_2 = array(
	'div',
	'div',
	'p'
);

$array_xls = array();

echo "<table><tr>";
foreach ($url as $key=>$value){
    ${"array_site".($key+1)} = array();    
}
foreach ($url as $key=>$value){
    echo $key;
	$content = file_get_contents($value);						
	// $dom_element1 e $dom_element2 tem que pensar um jeito para fazer o foreach
	$first_step = explode( '<'.$array_1[$key].'>' , $content );
	echo '<td><ul>';
	echo "<li>".$value."</li>";array_push($array_xls, $value);
	foreach($first_step as $key1=>$value1){
		if($key1>0){
			$second_step = explode( '</'.$array_2[$key].'>', $value1 );
			echo "<li>";
			echo $second_step[0];
			echo "</li>";
			array_push(${"array_site".($key+1)}, $second_step[0]);
            //print_r(${"array_site".($key+1)});
		}
	}
	echo '</ul></td>';
}
echo "</tr></table>";

$array_max = array();
for($i=1;$i <= sizeof($url); $i++){
    $tmp = sizeof(${"array_site".$i});
    array_push($array_max, sizeof(${"array_site".$i}));
    echo $tmp;
    print_r(${"array_site".$i});
    echo "</br>";
}
echo max($array_max)."</br>";
for($j=1; $j <= max($array_max); $j++){
    ${"array_line".$j} = array();
    for ($k=1; $k <= count($url); $k++){
        if( array_key_exists(($j-1),  ${'array_site'.$k}) ){
            array_push(${"array_line".$j}, ${'array_site'.$k}[$j-1]); 
        } else {
            array_push(${"array_line".$j}, 0);
        }
    }    
    echo "</br>";
    print_r(${"array_line".$j});
    $array_for_xls[$j] = ${"array_line".$j};
}
    print_r($array_for_xls);

?>
/*

	//header('Content-Type: text/csv');
	//header('Content-Disposition: attachment; filename="sample.csv"');

	//$fp = fopen('php://output', 'wb');
	$fp = fopen('newfile.csv', 'w');
	$data = array(array("One","Two", "Three"), array('1','2','3'),array('1','2','3'),array('1','2','3'));
    $rowData = array();
    foreach ($data as $row) {

        foreach ($row as $item) {
            $rowData[] = $item;
        }
        fputcsv($fp, $rowData,";");
        unset($rowData);
    }
*/
?>