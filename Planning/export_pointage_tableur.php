<?php  

$conn = mysqli_connect('localhost', 'root', '', 'planning');  
mysqli_select_db($conn, 'crud');  
$sql = "SELECT `ID`,`Nom`,`Email`,`Date`,`usrid` FROM `pointage`";  
$setRec = mysqli_query($conn, $sql);  
$columnHeader = '';  
$columnHeader = "ID Pointage" . "\t" . "Nom" . "\t" . "E-Mail" . "\t". "Date" . "\t". "ID Utilisateur" . "\t";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  
  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=Pointage.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

  echo ucwords($columnHeader) . "\n" . $setData . "\n";  

 ?>