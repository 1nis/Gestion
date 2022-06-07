<?php  

$conn = mysqli_connect('localhost', 'root', '', 'planning');  
mysqli_select_db($conn, 'crud');  
$sql = "SELECT `ID`,`Nom`,`Email`,`Adresse`,`Telephone` FROM `user`";  
$setRec = mysqli_query($conn, $sql);  
$columnHeader = '';  
$columnHeader = "ID de l'utilisateur" . "\t" . "Nom" . "\t" . "E-Mail" . "\t". "Adresse" . "\t". "Telephone" . "\t";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  

header("Content-Encoding: UTF-8");
header("Content-type: application/octet-stream; charset=UTF-8");  
header("Content-Disposition: attachment; filename=Liste_employes.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

  echo ucwords($columnHeader) . "\n" . $setData . "\n";  

 ?>