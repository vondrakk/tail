<html><head>
<title>Tail :: <?php echo $title ?></title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/default.css" type="text/css" media="screen"/>
<body>

<table width=100% cellspacing=0 cellpadding=0 style='background: transparent'>
<tr>
<td class=clear width=49%>
</td>
<td class=clear>
<div align=center>
<img src="<?php echo asset_url();?>img/logo.gif" align=center>
</div>
</td>
<td class=clear width=49% align=right>
<a href=donate.php><img src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" border="0" alt="Make a donation" style='margin-top: 5px'></a>
</td>
</tr></table>
<table class=mainouter width=100% border="1" cellspacing="0" cellpadding="10">

<!------------- MENU ------------------------------------------------------------------------>

<tr><td class=outer align=center>
<table class=main width=700 cellspacing="0" cellpadding="5" border="0">
<tr>

<td align="center" class="navigation"><a href='view/home'>Home</a></td>
<td align="center" class="navigation"><a href='browse'>Browse</a></td>
<td align="center" class="navigation"><a href='upload.php'>Upload</a></td>
<?php if (!isset($CURUSER)) { ?>
<td align="center" class="navigation">
<a href='login.php'>Login</a> / <a href='signup.php'>Signup</a>
</td>
<?php } else { ?>
<td align="center" class="navigation"><a href='my.php'>Profile</a></td>
<?php } ?>
<td align="center" class="navigation">Chat</td>
<td align="center" class="navigation"><a href='forums.php'>Forums</a></td>
<td align="center" class="navigation">DOX</td>
<td align="center" class="navigation"><a href='topten.php'>Top 10</a></td>
<td align="center" class="navigation"><a href='log.php'>Log</a></td>
<td align="center" class="navigation"><a href='rules.php'>Rules</a></td>
<td align="center" class="navigation"><a href='faq.php'>FAQ</a></td>
<td align="center" class="navigation"><a href='links.php'>Links</a></td>
<td align="center" class="navigation"><a href='staff.php'>Staff</a></td>
</tr>
</table>
</td>
</tr>
<tr><td align=center class=outer style="padding-top: 20px; padding-bottom: 20px">
<?php

if (isset($unread))
{
  print("<p><table border=0 cellspacing=0 cellpadding=10 bgcolor=red><tr><td style='padding: 10px; background: red'>\n");
  print("<b><a href=$BASEURL/inbox.php><font color=white>You have $unread new message" . ($unread > 1 ? "s" : "") . "!</font></a></b>");
  print("</td></tr></table></p>\n");
}

