function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";

    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;

    }
  }
  xmlhttp.open("GET","functions/busca.php?q="+str,true);
  xmlhttp.send();
}
function setText(valor){

      document.getElementById('t').value = valor;

  }
  function buscar(valor) {
    var ra = valor.split("-");
      document.getElementById('split').value = ra[ra.length - 1];//coloca o RA em um campo de texto to pra teste
      /*passar  ra[ra.length - 1] para pesquisar no banco
        1 - pegar o id_aluno a partir do RA
        2 - buscar as atividades desse aluno pelo id_aluno resultante*/
  }
