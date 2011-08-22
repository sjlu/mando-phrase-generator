<?php include 'conf/config.php'; ?>
<?php include 'conf/admin.php'; ?>

<?php if($admin !== 1) { die(); } ?>

<fb:dashboard>
<?php if($admin == 1) { ?> <fb:action href='http://apps.facebook.com/mandompg/'>Switch to Application Interface</fb:action> <?php } ?>
<fb:help href='http://facebook.com/board.php?uid=6611557469'>Help</fb:help>
<fb:help href='http://facebook.com/apps/application.php?id=6611557469'>About</fb:help>
<fb:create-button href="invite.php">Invite Friends</fb:create-button>
</fb:dashboard>

<fb:tabs>
<fb:tab_item href="admin.php" title="Add a New Phrase" selected="<?php if(!isset($_GET['p'])) { echo "true"; } ?>"></fb:tab_item> 
<fb:tab_item href="admin.php?p=showall" title="Show All Phrases" selected="<?php if($_GET['p'] == showall) { echo "true"; } ?>"></fb:tab_item>
</fb:tabs>

<?php if($_GET['p'] == NULL) { ?>
	<?php if ($_GET['a'] == add) { ?>
		<?php $db->Raw("SET NAMES utf8")?>
		<?php
		$db->Raw("INSERT INTO `phrases` (`english` , `pinyin` , `characters`) VALUES ('$_POST[english]' , '$_POST[pinyin]' , '$_POST[characters]')");
		$id = $db->Raw("SELECT `id` FROM `phrases` WHERE `english`='$_POST[english]'");
		$id = $id[0]['id'];
		var_dump($_FILES['audio']['tmp_name']);
		$location = '/home/28664/domains/apps.burst-dev.com/html/mando/audio/' . $id . '.mp3';
		if(move_uploaded_file($_FILES['audio']['tmp_name'], $location)) {
			$facebook->redirect('http://apps.facebook.com/mandompg/admin.php?a=add-done&id=' . $id . '');
		}
		die();
		?>
	<?php } ?>
	<?php if ($_GET['a'] == 'add-done') { ?>
	<fb:explanation>
		<fb:message>Phrase Added</fb:message>
		The phrase was successfully added to the database and the audio was added to the server. <br />
		<a href="http://apps.facebook.com/mandompg/?id=<?php echo $id; ?>">http://apps.facebook.com/mandompg/?id=<?php echo $id; ?></a>
	</fb:explanation>
	<?php } ?>
	<div style="border: 1px solid #999; padding: 10px; margin: 10px">
	<form name="form1" enctype="multipart/form-data" method="post" action="http://apps.burst-dev.com/mando/admin.php?a=add">
	<center><table border="0">
		<tr><td><b>English: </b></td><td><input type='text' name='english' size='33' maxlength='255' style='color: #003366; font-family: Verdana; font-weight: normal; font-size:11px'></td></tr>
		<tr><td><b>Pinyin: </b></td><td><input type='text' name='pinyin' size='33' maxlength='255' style='color: #003366; font-family: Verdana; font-weight: normal; font-size:11px'></td></tr>
		<tr><td><b>Characters: </b></td><td><input type='text' name='characters' size='33' maxlength='255' style='color: #003366; font-family: Verdana; font-weight: normal; font-size:11px'></td></tr>
		<tr><td><b>Audio: </b></td><td><input name='audio' type='file' size='23' style='color: #003366; font-family: Verdana; font-weight: normal; font-size:11px'></td></tr>
		</table>
		<input name='add' type='submit' id='add' value='Add to Database'></center>
	</form>

<?php } elseif($_GET['p'] == showall) { ?>
	<?php if (isset($_GET['delete'])) { ?>
		<?php $db->Raw("DELETE FROM `phrases` WHERE `id`='$_GET[delete]'"); ?>
		<?php unlink('/home/28664/domains/apps.burst-dev.com/html/mando/audio/' . $_GET[delete] . '.mp3'); ?>
		<fb:explanation>
		     <fb:message>Phrase Deleted</fb:message>
		     The phrase was deleted from the database and the audio file has been removed from the server.
		</fb:explanation>
	<?php } ?>
	<div style="border: 1px solid #999; padding: 10px; margin: 10px">
	<?php $db->Raw("SET NAMES utf8")?>
	<?php $db_query = $db->Raw("SELECT * FROM `phrases` ORDER BY `id` ASC"); ?>
	<center><table border='0' cellpadding='2' cellspacing='0' width='100%'><tr><td style='border-bottom: 1px solid #899cc1; border-right: 1px solid #899cc1;'><strong><center>English</center></strong></td><td style='border-bottom: 1px solid #899cc1; border-right: 1px solid #899cc1;'><strong><center>Pinyin</center></strong></td><td style='border-bottom: 1px solid #899cc1; border-right: 1px solid #899cc1;'><strong><center>Characters</center></strong></td><td style='border-bottom: 1px solid #899cc1; border-right: 1px solid #899cc1;'><strong><center>Audio</center></strong></td><td style='border-bottom: 1px solid #899cc1;'><strong><center>Actions</center></strong></td></tr>
	<?php foreach($db_query as $db_query) { ?>
		<tr><td><center><?php echo $db_query['english']; ?></center></td>
			<td><center><?php echo $db_query['pinyin']; ?></center></td>
			<td><center><?php echo $db_query['characters']; ?></center></td>
			<td><center><a href="http://apps.burst-dev.com/mando/audio/<?php echo $db_query['id']; ?>.mp3"><?php echo $db_query['id']; ?></a></center></td>
			<td><center><a href="index.php?id=<?php echo $db_query['id']; ?>"><img src="http://apps.burst-dev.com/mando/img/view.png" border="0" width="12" height="12"></a><a href="admin.php?p=showall&delete=<?php echo $db_query['id']; ?>"><img src="http://apps.burst-dev.com/mando/img/delete.png" border="0" width="12" height="12"></a></center></td>
		</tr>
	<?php } ?>
	</table></center>
<?php } ?>
</div>
<?php include 'footer.php'; ?>