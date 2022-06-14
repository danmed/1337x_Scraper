<?PHP
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; 
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"> 
<channel> 

<title>Vyndros RSS</title> 
<link><?PHP print htmlspecialchars("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", ENT_XML1, 'UTF-8'); ?></link> 
<description>TIGOLE Releases</description> 

<?PHP include "config.inc.php"; 

$filter = explode(",", $_GET[filter]);
$exclude = explode(",", $_GET[exclude]);
$cat = explode(",", $_GET[cat]);

$table = "tigole";
$SQL = "select * from $table";
$has_where = False;
if (isset($_GET[filter])) {
  foreach ($filter as $item) {
    if ($has_where) {
      $SQL = $SQL." and title like '%$item%'";
    } else {
      $SQL = $SQL." where title like '%$item%'";
      $has_where = True;
    }
  }
}
if (isset($_GET[exclude])) {
  foreach ($exclude as $item) {
    if ($has_where) {
      $SQL = $SQL." and title not like '%$item%'";
    } else {
      $SQL = $SQL." where title not like '%$item%'";
      $has_where = True;
    }
  }
}
if (isset($_GET[cat])) {
  foreach ($cat as $item) {
    if ($has_where) {
      $SQL = $SQL." and category like '%$item%'";
    } else {
      $SQL = $SQL." where category like '%$item%'";
      $has_where = True;
    }
  }
}

$SQL = $SQL."  order by id desc limit 40";

$db_handle = mysqli_connect($DBServer, $DBUser, $DBPassword); 
$db_found = mysqli_select_db($db_handle, $DBName); if ($db_found) {
#    $SQL = "select * from tigole order by id desc";
    $result = mysqli_query($db_handle, $SQL);
    while ($db_field = mysqli_fetch_assoc($result)) {
	$id = $db_field['id'];
        $title = $db_field['title'];
        $hash = $db_field['hash'];
        $encoder = $db_field['encoder'];
        $size = $db_field['size'];
	$magnet = "magnet:?xt=urn:btih:" . $hash . "&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.torrent.eu.org%3A451%2Fannounce&tr=udp%3A%2F%2Ftracker.zer0day.to%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969%2Fannounce&tr=udp%3A%2F%2Fcoppersurfer.tk%3A6969%2Fannounce";
        
	$pubdate = $db_field['pubdate'];        
       	if($pubdate == "NULL" or $pubdate == ""){$pubdate = "2018-01-01";}else{$pubdate = $pubdate;}

#Figure out proper size

if( strpos($size, "MB") !== FALSE ) { $sizetype = "MB"; }
if( strpos($size, "GB") !== FALSE ) { $sizetype = "GB"; }
$sizetoconvert = substr($size, 0, -3);
if( $sizetype == "MB") { $convertedsize = $sizetoconvert * 1048576; }
if( $sizetype == "GB") { $convertedsize = $sizetoconvert *1024*1024*1024; }

        
$rssfeed .= '<item>';
$rssfeed .= '<title><![CDATA[ ' . $title .' ]]></title>';
$rssfeed .= '<description></description>';
$rssfeed .= '<link><![CDATA[' . $magnet . ']]></link>';
$rssfeed .= '<hash>' . $hash . '</hash>';
$rssfeed .= '<pubDate>' . $pubdate . '</pubDate>';
$rssfeed .= '<size>' . round($convertedsize) . '</size>';
$rssfeed .= '</item>';
  }

echo $rssfeed;
    
    mysqli_close($db_handle);
    
}
?> </channel> </rss>
