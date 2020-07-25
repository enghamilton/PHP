<?php 
// https: //stackoverflow.com/questions/45369295/php-file-get-contents-get-all-contents-from-multiple-div-by-class-name?rq=1
// https: //stackoverflow.com/questions/4249432/export-to-csv-via-php
//$url = 'http://localhost/sitepg19036102/mainpage.php';
$url = 'http://www.vipluxuria.com/acompanhantes-porto-alegre/';
$content = file_get_contents($url);

//$first_step = explode( '<div class="image-description">' , $content );
$first_step = explode( '<p class="nome">' , $content );
foreach ($first_step as $key => $value) {
  if($key > 0)
  {
    //$second_step = explode("</div>" , $value );
	$second_step = explode("</p>" , $value );
    echo $second_step[0];    
    echo "<br>";
  }
}
?>
<?php
// https ://stackoverflow.com/questions/30153912/echoing-whole-websites-html-with-file-get-contents
$site = file_get_contents('http://www.vipluxuria.com/acompanhantes-porto-alegre/');

$htmlentities = htmlentities($site);

$htmlspecialchars = htmlspecialchars($site);

echo $htmlentities;
echo '<br/><br/>';
//echo $htmlspecialchars;

/*
https://www.clubmodel.com.br/sao-paulo-sp/acompanhantes/
http://www.kissclass.com/home
http://www.linkrosa.com.br/acompanhantes-sao-paulo
http://www.malicia.com.br
http://www.mclass.com.br/acompanhantes
http://www.missclass.net/acompanhantes
http://www.monicaloira.com
http://www.splove.com.br/modelos
http://www.hotside.com.br/acompanhantes-garotas-de-programa-rio-de-janeiro-rj.html
http://www.barravipsrio.com
http://www.barravipsrj.com.br/home.php
http://www.riovips.com.br/home.php
http://www.vipgoldrj.com.br/acompanhantes-rj
http://www.riosexsite.com
http://www.cariocasvips.com.br/acompanhantesrj
http://www.capitalsexy.com.br/acompanhantes-de-brasilia-df
http://www.topdebrasilia.com.br/acompanhantes-brasilia/
http://www.vipbrasilia.com.br/acompanhantebrasilia
http://www.elitte.com.br/acompanhantes-campinas.php
http://www.elitte.com.br/acompanhantes/campinas
http://www.elitte.com.br/acompanhantes/piracicaba
http://www.elitte.com.br/acompanhantes/sorocaba
http://www.curitibaacompanhantes.com/home.html
http://www.classivip.com/principal.html
http://www.acompanhantesflorianopolis.com.br
http://www.londrinasexy.com.br/acompanhantes
http://agenda31.com.br/acompanhantes-bh/
http://www.bhmodels.com.br/home
http://www.gpgbh.com.br/categoria/mulheres
http://www.modelsclubbh.com.br/acompanhantes-bh/
http://www.musaclass.com.br/acompanhantes/fortaleza
http://www.musaclass.com.br/acompanhantes/recife

https://www.barralove.net <h2></h2>
confrariars.com.br  20170620 visiting gp-guia new web domain porto alegre
alibi51.com.br porto alegre
garotasfloripa.com.br florianópolis
photoacompanhantes.com.br
executivovip.com.br Slavador
ilhadoprazer.com.br Vitória Espirito Santo username advertising with price
www.f4n.com.br fun for night -new 20170811- advertisng in google ranking search in first page last result
vipluxuria
private55

*/

?>