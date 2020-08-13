<?php

$arquivo = 'planilha.xls';

$numbers = array('1','2','3');

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

$arquivo = 'planilha.xls';
// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="3">Planilha teste</tr>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td><b>Coluna 1</b></td>';
$html .= '<td><b>Coluna 2</b></td>';
$html .= '<td><b>Coluna 3</b></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>L1C1</td>';
$html .= '<td>L1C2</td>';
$html .= '<td>L1C3</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>L2C1</td>';
$html .= '<td>L2C2</td>';
$html .= '<td>L2C3</td>';
$html .= '</tr>';

foreach ($url as $key=>$value){
						$content = file_get_contents($value);						
						// $dom_element1 e $dom_element2 tem que pensar um jeito para fazer o foreach
						$first_step = explode( '<'.$array_1[$key].'>' , $content );
						$html .= '<td><ul>';
						$html .= "<li>".$value."</li>";
						foreach($first_step as $key1=>$value1){
							if($key1>0){
								$second_step = explode( '</'.$array_2[$key].'>', $value1 );
								$html .= "<li>";
								$html .= $second_step[0];    
								$html .= "</li>";
							}
						}
						$html .= '</ul></td>';
					}

$html .= '</table>';

// Configurações header para forçar o download

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );


// Envia o conteúdo do arquivo
echo $html;
exit;

?>