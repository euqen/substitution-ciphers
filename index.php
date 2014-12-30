<head>

</head

<body>
<?php

$alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

$key = "KEY"; 

$fp = fopen("message.txt", "r"); // Открываем файл в режиме чтения
 if ($fp) {
  while (!feof($fp)) {
   $mes = fgets($fp, 999);
  }
 }
 else echo "Ошибка при открытии файла";
 fclose($fp);
 
 $mes = strtoupper($mes);

function get_position($arr, $word) {
    $i = 0;
    for($i = 0; $i <= 25; $i++) {
        if ($arr[$i] == $word){
            return $i;
            break;
        }
    }
}

function coding($keyword, $message, $alphabet) {
 $i = 0; $k = 0;
 global $cipher;
 while ($i <= strlen($message) - 1) {
    
  if($message{$i} != ' ') {
    
   if ($k == strlen($keyword)) $k = 0;
  
   $keyLetter = $keyword{$k};
   $messageLetter = $message{$i};
 
   $pos = get_position($alphabet, $keyLetter) + get_position($alphabet, $messageLetter);
   $j = 0;
   while (true) {
    
    if ($j > 25) $j = 0;
    
    if ($pos != 0) {
       $pos--;
       $j++; 
    }
    else {
        $cipher .= $alphabet[$j];
        break;
    }
   }
   $i++; $k++; 
  }
  else {
    $cipher .= " ";
    $i++;
  }
 }
 echo $cipher; 
    
} //coding


function decoding($keyword, $cipherCode, $alphabet) {
    $newMessage = ''; $realPos = 0;
 $i = 0; $k = 0;
 while($i <= strlen($cipherCode) - 1) {
  if($cipherCode{$i} != ' ') {   
    if ($k == strlen($keyword)) $k = 0;
   
    $keyLetter = $keyword{$k};
    $messageLetter = $cipherCode{$i};   
    $realPos = 0;
    $j = get_position($alphabet, $keyLetter);
    while(true) {
     if ($j > 25) { 
        $j = 0; 
     //  $realPos++;
     }
     else {
     if($alphabet[$j] == $messageLetter) {
        break;
     }
     else {
        $j++;
        $realPos++;
     }    
     }
    } 
 
   $newMessage .= $alphabet[$realPos];
   $i++; $k++;
  }
  else {
   $newMessage .= " ";
   $i++; 
  }
 }

 echo $newMessage;
         
}//decoding

function nod($a, $b) {
 while ($a != $b) {
  if ($a > $b) {
   $a = $a - $b;
  }
  else {
   $b = $b - $a;
  }
 }
  return $a;
}

function get_gcd($between) {
 $gcd = 1; $i = 0;

 $gcd = nod($between[0], $between[1]);
 
 for ($i = 2; $i <= count($between)-1; $i++) { $gcd = nod($gcd, $between[$i]);}
 
 if ($gcd > 0) {
  return $gcd;
 }
 else return 1;
 
}

function test($cipherCode) {

 $k = 0; $m = 0; $f = 0; $nameOfGram = array(); $n = 0;
 for ($i = 0; $i < strlen($cipherCode)-1; $i++){
    
    $gram = $cipherCode{$i}.$cipherCode{$i+1}.$cipherCode{$i+2};
    
    $gramIsset = 0; $n = 0;
    while ($n < count($nameOfGram)) {
        if ($gram == $nameOfGram[$n]) {
            $gramIsset = 1;
        }
        $n++;
    }
    
    if (($gramIsset == 0) || ($gramIsset == -1)) {
     if($cipherCode{$i} == ' ' || $cipherCode{$i+1} == ' ' || $cipherCode{$i+2} == ' ') continue;
    
    
    for ($j = $i; $j < strlen($cipherCode)-1; $j++) {   
     if($cipherCode{$j} == ' ' || $cipherCode{$j+1} == ' ' || $cipherCode{$j+2} == ' ') continue;
     if (($i != $j) ){
      if ($gram == $cipherCode{$j}.$cipherCode{$j+1}.$cipherCode{$j+2}) {
       if ($gramIsset == 0) {
        array_push($nameOfGram, $gram);
        $gramIsset = -1;
       }
       echo $gram;
       $counter = 0; $current = $i;
       while ($current != $j) {
        if ($cipherCode{$current} != ' ') $counter++;
        $current++;
       } 
       $range[$k++] = $counter;
       if ($f == 0) { //perenosa ewe ne bilo
        $f = 1;
        $dump = $i; 
       }       
       $i = $j;
      }
     }
    } // for j
   
    if ($f == 1) {  
     $i = $dump;
     $f = 0;
    }
 
 for ($j = 0; $j < count($range); $j++) {
    echo $range[$j]."<br>";
 }
 
    if (count($range) > 2) { //убираем незначительные повторы
     $gcdArray[$m++] = get_gcd($range); 
    } 
 
    $k = 0; $range = array();

   }
 
 } // for i

 $result = get_gcd($gcdArray);
 echo $result;

} //function

/* MAIN PART */


coding($key, $mes, $alpha);
echo '<br>';
decoding($key, $cipher, $alpha);
echo '<br>';
test($cipher);


?>

</body>