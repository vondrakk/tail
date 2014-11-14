<?php
include("bcode.php");

$bcode = new Bcode();

$db = new mysqli("localhost", "root", "", "tail");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$res = $db->query("select tracker_id,url from trackers where isactive='Y' and lastcollectiondt < now()-interval 5 minute");
//$res = $db->query("select tracker_id,url from trackers where isactive='Y' and tracker_id=4");
if ($res->num_rows) {
	while ($row = $res->fetch_assoc()) {
		$html = file_get_contents($row["url"]);
		if (preg_match_all('|<tr><td><code>(.*?)</code></td><td>(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td></tr>|',$html,$matches,PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$db->query("insert ignore into torrents values('$match[1]',0,0,'$match[2]','$match[3]',NOW(),'yes')");
				$db->query("insert ignore into tracking_data values(0,".$row["tracker_id"].",'$match[1]',NOW(),'$match[4]','$match[5]','$match[6]','$match[7]')");
			}
		}

		if (preg_match_all('|<tr>\s+<td><a href="([^"]+)">(.*?)</a></td>\s+<td>(.*?)</td>\s+<td>(.*?)</td>\s+<td>(.*?)</td>\s+<td>(.*?)</td>\s+</tr>  |',$html,$matches,PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$torrent = file_get_contents($match[1]);
				$ret = $bcode->bdec($torrent);
				$info_hash=urlencode(sha1($bcode->benc($ret["value"]["info"])));
				$db->query("insert ignore into torrents values('$info_hash',0,0,'$match[3]','$match[4]','$match[5]','yes')");			}
		}
		
		if (preg_match_all('|20:(.*?)d8:completei(.*?)e10:downloadedi(.*?)e10:incompletei(.*?)ee|',$html,$matches,PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$db->query("insert ignore into tracking_data values(0,".$row["tracker_id"].",'".bin2hex($match[1])."',NOW(),'$match[2]','$match[4]','$match[3]','0')");
			}
		}
		$db->query("update trackers set lastcollectiondt=NOW() where tracker_id=".$row["tracker_id"]);
	}	
}

