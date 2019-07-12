<?php
$url = array(
	'https://ofertas.vw.com.br/sao-caetano-do-sul-SP',
	'https://ofertas.vw.com.br/sao-caetano-do-sul-SP',
	'https://ofertas.fiat.com.br/',
	'https://ofertas.fiat.com.br/',
	'https://www.savol.com.br/veiculos/estoque/lista_okm/1', /* volkswagen */
	'https://www.savol.com.br/veiculos/estoque/lista_okm/1',
	'https://www.savol.com.br/veiculos/estoque/lista_okm/8', /* toyota */
	'https://www.savol.com.br/veiculos/estoque/lista_okm/8',
	'https://www.madel.com.br/'
);

$array_1 = array(
	'span class="on-offers__card-model" itemprop="name"',
	'p class="on-offers__payment-methods custom"',
	'span class="title-brand"',
	'span class="price-text-big"',
	'div class="title"',
	'div class="price"',
	'div class="title"',
	'div class="price"',
	'h3 class="product-name"'
);
$array_2 = array(
	'span',
	'p',
	'span',
	'span',
	'div',
	'div',
	'div',
	'div',
	'h3'
);

$array_xls = array();
?>

<html>
	<head>
		<style>
		</style>
	</head>
	<body>
		<table>
			<tr>
<?php				
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
	?>	
			</tr>
		</table>
	</body>
</html>
<?php
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
