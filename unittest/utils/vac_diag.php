<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

if(!file_exists('../../core/codon.config.php')) {
	die('This file must be placed in the same directory as index.php');
}

include '../../core/codon.config.php';

Config::set('VACENTRAL_ENABLED', true);
?>
<html>
<head>
<title>vaCentral Diagnostics </title>
<style type="text/css">
td {
	font-family: verdana;
	font-size: 12px;
}
pre {
}
</style>

</head>

<body>
<h2>vaCentral Diagnostic Page</h2>

<table width="90%" align="center">
<tr>
<td><strong>API Server: </strong><?php echo Config::Get('PHPVMS_API_SERVER'); ?>  <br />
	<strong>API Key: </strong><?php echo Config::Get('PHPVMS_API_KEY'); ?>
</td>
</tr>
<tr>
<td><br />
	<a href="?a=sendstats">Send VA Stats</a> | <a href="?a=sendschedules">Send Schedules</a> |
	<a href="?a=sendpilots">Send Pilots</a> | <a href="?a=sendallpireps">Send all PIREPS</a> | 
	<a href="?a=sendpirep">Send a PIREP</a> | <a href="?a=sendacars">Send ACARS Data</a> |
	<a href="?a=sendallacars">Send All ACARS Data</a> 
</td>
</tr>
<tr>
<td>
<br />
<?php

if(isset($_GET['diag'])) {
    Config::Set('VACENTRAL_API_SERVER', 'http://apidev.phpvms.net');
	echo '<p style="color: red">Debug mode enabled!</p>';
}

CentralData::$debug = true;

switch($_GET['a'])
{
	case 'sendstats':
		$resp = CentralData::send_vastats();		
		break;
	case 'sendschedules':
		$resp = CentralData::send_schedules();
		break;
	case 'sendpilots':
		$resp = CentralData::send_pilots();
		break;
	case 'sendallpireps':
		$resp = CentralData::send_all_pireps();
		break;
	case 'sendpirep':
		$pirep = PIREPData::findPIREPS(array(), 20);
		$num = rand(0, count($pirep)-1);
		$resp = CentralData::send_pirep($pirep[$num]->pirepid);
		break;	
	case 'sendacars':
		# Send a random flight
		$flights = ACARSData::GetAllFlights();
		$total = count($flights);
		$resp = CentralData::send_acars_data($flights[rand(0, $total-1)]);
		break;
	case 'sendallacars':
	
		$resp = CentralData::send_all_acars();
		break;
}
?>
<h3>Response:</h3>
<pre><?php 
$response = CentralData::$xml_response;
echo htmlentities(formatXmlString($response));
?>
</pre>

<h3>Sent Data</h3>
<pre><?php 
if(CentralData::$type == 'xml') {
    $xml = CentralData::$xml->asXML();
    echo htmlentities(formatXmlString($xml)); 
} elseif(CentralData::$type == 'json') {
    echo '<pre>';
    print_r(CentralData::$json);
    echo '</pre>';
}

?>
</pre>
</td>
</tr>	
</table>

</body>
</html>

<?php
function formatXmlString($xml) {  
  
  // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
  $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
  
  // now indent the tags
  $token      = strtok($xml, "\n");
  $result     = ''; // holds formatted version as it is built
  $pad        = 0; // initial indent
  $matches    = array(); // returns from preg_matches()
  
  // scan each line and adjust indent based on opening/closing tags
  while ($token !== false) : 
  
    // test for the various tag states
    
    // 1. open and closing tags on same line - no change
    if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
      $indent=0;
    // 2. closing tag - outdent now
    elseif (preg_match('/^<\/\w/', $token, $matches)) :
      $pad--;
    // 3. opening tag - don't pad this one, only subsequent tags
    elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
      $indent=1;
    // 4. no indentation needed
    else :
      $indent = 0; 
    endif;
    
    // pad the line with the required number of leading spaces
    $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
    $result .= $line . "\n"; // add to the cumulative result, with linefeed
    $token   = strtok("\n"); // get the next token
    $pad    += $indent; // update the pad size for subsequent lines    
  endwhile; 
  
  return $result;
}