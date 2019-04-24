
<?php
$xmlDoc=new DOMDocument();
include "geraXml.php";
$xmlDoc->load("alunos.xml");

$x=$xmlDoc->getElementsByTagName('link');

//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";//valor do botao
  $response="";
  for($i=0; $i<($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('nome');
    $z=$x->item($i)->getElementsByTagName('ra');
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q) or stristr($z->item(0)->childNodes->item(0)->nodeValue,$q)) {

        $hint2="<button name='buscaAluno' form='buscaA' id='botao' type='submit' value='";
        if ($hint=="") {
          $hint=$y->item(0)->childNodes->item(0)->nodeValue." - ".$z->item(0)->childNodes->item(0)->nodeValue;
        } else {
          $hint=$hint.$y->item(0)->childNodes->item(0)->nodeValue." - ".$z->item(0)->childNodes->item(0)->nodeValue;
        }

        $hint2=$hint2.$hint."'onclick='setText(this.value)'>".$hint."</button><br/>";


        $hint = $hint2;
        $hint2 = "";
      }
    }
    if ($hint!="") {
      $response=$response.$hint;
      $hint="";
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
/*if ($hint=="") {
  $response="no suggestion";
  echo $response;
}else {
  $response=$hint;
}*/

//output the response
echo $response;
?>
