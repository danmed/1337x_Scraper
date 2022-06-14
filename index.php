<!DOCTYPE html>                                                                                              
<?PHP                                                                                                        
include "config.inc.php";                                                                                    
?>                                                                                                           
<html lang="en">                                                                                             
<head>                                                                                                       
<!-- Global site tag (gtag.js) - Google Analytics -->                                                        
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116906-4"></script>                        
<script>                                                                                                     
  window.dataLayer = window.dataLayer || [];                                                                 
  function gtag(){dataLayer.push(arguments);}                                                                
  gtag('js', new Date());                                                                                    
                                                                                                             
  gtag('config', 'UA-116906-4');                                                                             
</script>                                                                                                    
                                                                                                             
<title>Tigole Releases</title>                                                                              
  <meta charset="utf-8">                                                                                     
  <meta name="viewport" content="width=device-width, initial-scale=1">                                       
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">       
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>                   
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>                
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" class="init">                                                                 
$(document).ready(function() {                                                                               
        $('#status').DataTable({                                                                             
        "order": [[0, "desc" ]]                                                                              
} );            
} );                                                                                                         
                                                                                                             
        </script>                                                                                            
</head>                                                                                                      
                                                                                                             
  <body><font size="2">                                                                                      
<?PHP
include "../menu.php";
?>

<center><a href="zxc.php"><img src="rss.png"></a>                                                                                                             
                                                                                                             
    <div class="container">                                                                                  
    <table class="table table-striped table-bordered" id="status">                                           
    <thead>                                                                                                  
    <tr><th colspan="6"><center><b>tigole Releases</th></tr>                                                
        <tr><th><b>DBID</th><th><b>TITLE</th><th>SIZE</th><th><b>HASH</th><th>CATEGORY</th><th><b>ENCODER</th></tr>
    </thead>                                                                                                 
    <tbody>  
<?PHP                                                                                                        
$relcount = 1;                                                                                               
$db_handle = mysqli_connect($DBServer, $DBUser, $DBPassword);                                                
$db_found  = mysqli_select_db($db_handle, $DBName);                                                          
                                                                                                             
if ($db_found) {                                                                                             
    $SQL    = "select * from tigole order by id asc";                                                       
    $result = mysqli_query($db_handle, $SQL);                                                                
    while ($db_field = mysqli_fetch_assoc($result)) {                                                        
        $id = $relcount;                                                                                     
        $title  = $db_field['title'];                                                                        
        $hash  = $db_field['hash'];                                                                          
        $encoder  = $db_field['encoder'];                                                                    
        $category = $db_field['category'];                                                                   
        $size = $db_field['size'];                                                                           
        $magnet = "magnet:?xt=urn:btih:" . $hash . "&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.torrent.eu.org%3A451%2Fannounce&tr=udp%3A%2F%2Ftracker.zer0day.to%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969%2Fannounce&tr=udp%3A%2F%2Fcoppersurfer.tk%3A6969%2Fannounce";
        print "<tr><td>" . $id . "</td><td>" . $title . "</td><td>" . $size . "</td><td><a href='" . $magnet ."'>" . $hash ."</a></td><td>" . $category ."</td><Td>" . $encoder ."</td></tr>";
        $relcount = $relcount + 1;                                                                           
}                                                                                                            
                                                                                                             
    mysqli_close($db_handle);                                                                                
                                                                                                             
}                                                                                                            
?>                                                                                                           
           </tbody>                                                                                          
    </table>                                                                                                 
    </div>                                                                                                   
                                                                                                             
   <?PHP
include "../footer.php";
?>
  
