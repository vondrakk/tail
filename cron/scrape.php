<?php
$db = new mysqli("localhost", "root", "", "tail");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$res = $db->query("select tracker_id,url from trackers where isactive='Y' and lastcollectiondt < now()-interval 5 minute");
if ($res->num_rows) {
	while ($row = $res->fetch_assoc()) {
		$html = file_get_contents($row["url"]);
		preg_match_all('|<tr><td><code>(.*?)</code></td><td>(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td><td align="right">(.*?)</td></tr>|',$html,$matches,PREG_SET_ORDER);
		foreach ($matches as $match) {
				$db->query("insert ignore into torrents values('$match[1]',0,0,'$match[2]','$match[3]',NOW(),'yes')");
				$db->query("insert ignore into tracking_data values(0,".$row["tracker_id"].",'$match[1]',NOW(),'$match[4]','$match[5]','$match[6]','$match[7]')");
		}
		$db->query("update trackers set lastcollectiondt=NOW() where tracker_id=".$row["tracker_id"]);
	}	
}

