<STYLE TYPE="text/css" MEDIA=screen>

  a.catlink:link, a.catlink:visited{
		text-decoration: none;
	}

	a.catlink:hover {
		color: #A83838;
	}

</STYLE>

<table width=750 class=main border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<form method="get" action=browse.php>
<p align="center">
Search:
<input type="text" name="search" size="40" value="<?php if (isset($searchstr)) echo htmlspecialchars($searchstr) ?>" />
in
<select name="cat">
<option value="0">(all types)</option>
<?php

$cats = array(array("id"=>1,"name"=>'Operating Systems'));
$catdropdown = "";
foreach ($cats as $cat) {
   $catdropdown .= "<option value=\"" . $cat["id"] . "\"";
   if ($cat["id"] == $_GET["cat"])
       $catdropdown .= " selected=\"selected\"";
   $catdropdown .= ">" . htmlspecialchars($cat["name"]) . "</option>\n";
}

$deadchkbox = "<input type=\"checkbox\" name=\"incldead\" value=\"1\"";
if ($_GET["incldead"])
   $deadchkbox .= " checked=\"checked\"";
$deadchkbox .= " /> including dead torrents\n";

?>
<?php= $catdropdown ?>
</select>
<?php= $deadchkbox ?>
<input type="submit" value="Search!" />
</p>
</form>
</td></tr></table>

<table border="1" cellspacing=0 cellpadding=5>
<tr>

<td class="colhead" align="center">Category</td>
<td class="colhead" align=left>Name</td>
<td class="colhead" align="center">Added</td>
<td class="colhead" align="center">Size</td>
<td class="colhead" align="center">Complete</td>
<td class="colhead" align=right>Downloading</td>
<td class="colhead" align=right>Downloaded</td>
<td class="colhead" align=right>Transferred</td>
</tr>
<?php
    foreach ($torrents as $row) {
        print("<tr>\n");

        print("<td align=center style='padding: 0px'>");
        if (isset($row["category"])) {
            print("<a href=\"browse.php?cat=" . $row["category"] . "\">");
            if (isset($row["cat_pic"]) && $row["cat_pic"] != "")
                print("<img border=\"0\" src=\"$pic_base_url" . $row["cat_pic"] . "\" alt=\"" . $row["category"] . "\" />");
            else
                print($row["category"]);
            print("</a>");
        }
        else
            print("-");
        print("</td>\n");

        $dispname = htmlspecialchars($row["name"]);
        print("<td align=left><a href=\"details.php?");
        print("id=".$row["torrent_hash"]);
        print("\"><b>".$row["name"]."</b></a>\n");

		print("</td>\n");


        print("<td align=center><nobr>" . $row["createdt"] . "</nobr></td>\n");
        print("<td align=center>" . $row["size"] . "</td>\n");
        print("<td align=center>" . $row["complete"] . "</td>\n");
		print("<td align=center>".$row["downloading"]."</b></td>\n");
		print("<td align=center>".$row["downloaded"]."</b></td>\n");
		print("<td align=right>".$row["transferred"]."</td>");
        print("</tr>\n");
    }

    print("</table>\n");
