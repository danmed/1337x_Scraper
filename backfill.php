 <?PHP

function getBetween($content, $start, $end)
{
    $r = explode($start, $content);
    if (isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}


include "config.inc.php";

// Create connection
$conn = new mysqli($DBServer, $DBUser, $DBPassword, $DBName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


#INITIAL SCRAPE OF PAGE
$initial_results = array();

$proxyip = 'oberon.usbx.me';
$proxyport = '8080';
$proxyusername = 'foghorn';
$proxypassword = 'N01d34M4t3';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
curl_setopt($ch, CURLOPT_PROXY, $proxyip);
curl_setopt($ch, CURLOPT_PROXYPORT, $proxyport);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$proxyusername:$proxypassword");
curl_setopt($ch, CURLOPT_URL, "https://1337x.to/sort-search/tigole/time/desc/3/");
// create curl resource
//$ch = curl_init();

// set url

//curl_setopt($ch, CURLOPT_URL, "https://1337x.to/user/QxR/");

//return the transfer as a string
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);
#        print $output;
// close curl resource to free up system resources
curl_close($ch);


$data = strip_tags($output, "<a>");
$d    = preg_split("/<\/a>/", $data);
foreach ($d as $k => $u) {
    if (strpos($u, "<a href=") !== FALSE) {
        $u = preg_replace("/.*<a\s+href=\"/sm", "", $u);
        $u = preg_replace("/\".*/", "", $u);
        if (strpos($u, '/torrent/') !== FALSE) {
            array_push($initial_results, $u);
        }
    }
    }
    #LOOP TO GRAB INFO FROM PAGES
    $reversed = array_reverse($initial_results);
    foreach ($reversed as $result) {
        $title_split = explode("/", $result);
        $title       = "'" . $title_split[3] . "'";
        $category = "'Movie'";
        if (preg_match("/[s]\d\d[e]\d\d/i", $title)) { $category = "'Weekly'"; }
        if (preg_match("/season/i", $title)) { $category = "'TV Season Pack'"; }
	if( strpos($title, "-Tigole") !== FALSE ) { 

$encoder = "'tigole'";

 print "TITLE: " . $title . "<br>"; $url="https://1337x.to".$result;
 print "URL: <a href='" . $url . "'>" . $url . "</a><br>";

// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
curl_setopt($ch, CURLOPT_PROXY, $proxyip);
curl_setopt($ch, CURLOPT_PROXYPORT, $proxyport);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$proxyusername:$proxypassword");

//return the transfer as a string
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);
#        print $output;
// close curl resource to free up system resources
curl_close($ch);

$data=$output;
$data = substr($data, 66646);
# GET SIZE OF TORRENT
$getsize  = strip_tags($data,"<li>");
$getsize2 = preg_split("/<\/li>/",$getsize2);
#print $getsize2;
foreach ($getsize2 as $v=>$s ) {
print $s;
if ( strpos($s, "Total size") !== FALSE ) {
$size = str_replace("<li> Total size ", "", $s);
$size = "''";

}}


$data = strip_tags($data,"<a>");
$d = preg_split("/<\/a>/",$data);
foreach ( $d as $k=>$u ){
    if( strpos($u, "href=\"magnet") !== FALSE ){
        $u = preg_replace("/.*href=\"/sm","",$u);
        $u = preg_replace("/\".*/","",$u);
        if( strpos($u, "magnet") !== FALSE ){
        print "MAGNET: <a href='" . $u . "'>MAGNET</a><br>";
        $start = "btih:";
        $end = "&dn";
        $hash = "'".getBetween($u,$start,$end)."'";
        print "HASH: " . $hash . "<br>";
        print "ENCODER: " . $encoder . "<br>";
        print "SIZE: " . $size . "<br>";
$pubdate = "'" . date('Y-m-d H:i:s') . "'";
#CHECK IF ALREADY EXISTS

$check_select = mysqli_query($conn, "SELECT * FROM `tigole` WHERE hash = " . $hash);
$numrows=mysqli_num_rows($check_select);
if ($numrows == 0){
       $sql = "INSERT INTO tigole (title,size,hash,encoder,category,pubdate) VALUES ($title, '5GB', $hash, $encoder, $category, $pubdate)";
       print $sql;
$conn->query($sql);
}}}

    }

    }
   } 

$conn->close();
?> 
