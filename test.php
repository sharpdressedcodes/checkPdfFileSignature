<?php

$files=array(
  'c:\uni\Academic Word List.pdf',
  'c:\uni\Assignment Cover Sheet.pdf',
  'c:\uni\eclipse.pdf',
  'c:\uni\FEE-HELP eCAN - Open Universities Australia.pdf',
  'c:\uni\Programming1\Assignments.pdf',
  'c:\uni\Programming1\Marked Test1.pdf',
  'c:\uni\Programming1\Marked Test2.pdf',
  'c:\uni\Programming1\ScannerPrimer.pdf',
);

foreach ($files as $file)
   echo $file.'='.(checkPdfFileSignature($file) ? 'true':'false').'<br>';

function checkPdfFileSignature($filename){

  $firstChunkLength = 15;
  $lastChunkLength = 30;
  $result = false;

  try {

    if (file_exists($filename)){

      $size = filesize($filename);
      $handle = fopen($filename,'r');
      $firstChunk = fread($handle,$firstChunkLength);
      fseek($handle, $size - $lastChunkLength);
      $lastChunk = fread($handle, $lastChunkLength);
      fclose($handle);

      $check1 = preg_match('/%PDF\-(\d+)\.(\d+)[\\r|\\n]%/', $firstChunk, $matches);
      $check2 = preg_match('/(\\r*)(\\n*)startxref(\\r*)\\n(\d+)(\\r*)\\n%%EOF(\\r*)(\\n*)/', $lastChunk, $matches);
      $result = $check1 && $check2;

      //echo sprintf("%s-%b-%b-%b<br> %s<br> %s<br><br>",$filename,$result,$check1,$check2,$firstChunk,$lastChunk);

    }

  } catch (Exception $e){
    $result = false;
  }

  return $result;

}

?>
