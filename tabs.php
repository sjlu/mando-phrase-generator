<?php $skip_login = 1; ?>
<?php include 'conf/config.php'; ?>
<?php include 'conf/admin.php'; ?>

<?php $db->Raw("SET NAMES utf8")?>
<?php if(isset($id)) { $db_random = $db->Raw("SELECT * FROM `phrases` WHERE `id`='$id'"); } else { $db_random = $db->Raw("SELECT * FROM `phrases` ORDER BY RAND() LIMIT 1"); } ?>
<form>
<div style="border-top: 1px solid #d8dfea; padding: 3px 16px; height: 14px; color: #3b5998;">
<table border="0" width="100%">
	<tr>
		<td width="40%"><center><b>English</b></center></td>
		<td width="55%"><center><b>Pinyin / Characters</b></center></td>
		<td width="5%"><center><b>Audio</b></center></td>
	</td>
</table>
</div>
<div style="border-style:solid; border-left: 1px; border-right: 1px; border-color: #ffd04d; background-color: #fff5b1; padding:10px">
	<div id="content"><center><table border="0" width="100%">
		<tr>
			<td width="40%"><div style="letter-spacing: 1px; font-family: tacoma; font-size: 14px; text-align: left; color: #003355"><div align="center"><strong><?php print $db_random[0]['english']; ?></strong></div></div>
			</td>
			<td width="55%"><div style="letter-spacing: 1px; font-family: tacoma; font-size: 14px; text-align: left; color: #003355"><div align="center"><?php echo $db_random[0]['pinyin']; ?></div></div><br /><div style="letter-spacing: 1px; font-family: tacoma; font-size: 14px; text-align: left; color: #003355"><div align="center"><?php echo $db_random[0]['characters']; ?></div></div>
			</td>
			<td width="5%"><div align="center"><fb:mp3 src="<?php echo $appcallbackurl; ?>audio/<?php echo $db_random[0]['id']; ?>.mp3" width="35"></div>
			</td>
		</tr>
	</table></center></div>
</div>

<div style="border-bottom: 1px solid #d8dfea; padding: 3px 16px; height: 14px; color: #3b5998;">
	<div style="float: left;"></div>
	<div style="float: right;"><img src="<?php echo $appcallbackurl; ?>img/logo.gif" width="10" height="10"> <a href="http://www.mandomandarin.com/">Mando Mandarin</a></div>
</div>
<center><input type="submit" clickrewriteurl="<?php echo $appcallbackurl; ?>index.php?regenerate=1" clickrewriteid="content" value="Generate a New Phrase"/></center>
</form>