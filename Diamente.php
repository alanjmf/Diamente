<?php
 /*
  Os dados são coletados através do javascript para setar o cookie e posteriormente montar o diamente. O diamente é montado em duas partes: superior e inferior.
  A parte inferior apenas é um reflexo da superior, mas de forma inversa. O processo de armazenamento em vetores foi usado para ajustar as posições das letras.
 */
 if  (!isset($_COOKIE['cookie']))//entrada de dados
 {
  echo "<script> var letra = prompt('Ponto mais distante. Ex: \'A\'').replace(/[\d]+/g,'');</script>";//regex para selecionar somente a string
  echo "<script> document.cookie = 'cookie='.concat(letra);</script>";//adiciona no 'cookie', concatenando
  echo "<script> window.location.reload()</script>";//retorna à pagina, porque inicialmente o cookie está NULL
 }
 else
 {
  @$stop= strtoupper(substr($_COOKIE['cookie'],0,1));//pega somente a primeira letra da string, caso o usuário digite uma palavra
  setcookie("cookie");//seta o cookie para NULL, para uma nova chamada(F5)
  diamente($stop);//chama a função já com o dado de entrada 'limpo'
 }

function diamente($stop)
{
 $letra = "A";// Valor inicial
 $esquerda = (int)strcasecmp($stop, $letra); //faz a diferença de tamanho entre o valore de start (letra) e stop fornecido pelo usuário  
 $centro = 0;//variável de controle da distância entra a primeira letra da esquerda e a da direita
 $vetor[] = "";
 $chave = 0;//índice inicial do array
 $espaço = "<span style=color:white>*</span>";//caracter que será usado como espaço

 while ($letra<$stop)
 {
  if($chave==0)//primeira letra 'A'. Só serve para ela
  {
   for ($i=$esquerda; $i >=1 ; $i--)//laço descendente dos '*' 
   {
    $vetor[$chave].=$espaço;//concatena '*' na posição 'i' do vetor para formar a distância da esquerda
   }
   $vetor[$chave].=$letra;//concatena a letra correspondente no total de espaços específicos do laço
  }
  else
  {
   $letra++;
   for ($i=$esquerda; $i >0 ; $i--) //laço dos '*' da ESQUERDA
   {
    $vetor[$chave].=$espaço;//concatena '*' na posição 'i' do vetor para preencher à esquerda
   } 
   $vetor[$chave].=$letra;//concatena a letra correspondente no total de espaços específicos do laço
  
   for ($i=1; $i <$centro ; $i++) //laço dos '*' do CENTRO do diamante
   {
    @$vetor[$chave].=$espaço;//concatena '*' na posição 'i' do vetor para formar a distância do centro
   }
   $vetor[$chave].=$letra;//concatena a letra correspondente no total de espaços específicos do laço
  }
  $esquerda--;
  $centro+=2;//faz com que o incremento seja apenas ímpar
  $chave++;
  $vetor[$chave]="";//seta com espaço em branco para não dar erro de índice inexistente.
 }
 $parte_superior = array_filter($vetor); //retira os 'blanks' do vetor, porque a última posição será um blanck
 foreach($parte_superior as $chave=>$valor) //parte superior do diamente
 {
  echo "$valor<br>";
 }
 
 $parte_inferior=array_pop($parte_superior) ;//retira o último elemento do vetor
 $parte_inferior=array_reverse($parte_superior) ;//inverte as posições do vetor
 
 foreach($parte_inferior as $chave=>$valor) //parte inferior do diamente
 {
  echo "$valor<br>";
 }
}
?>