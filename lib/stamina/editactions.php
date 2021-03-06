<?php

page_header("Actions Management");

$op2 = httpget('op2');
if($op2 == "del"){
	$act = actions_list();
	$key = httpget('key');
	$value = $act[$key];
	output("All values of the action \"".$value."\" were deleted.");
	$stamina = db_prefix("stamina");
	db_query("DELETE FROM $stamina WHERE action='$key'");
	unset($act[$key]);
	
	set_module_setting("actionsarray",serialize($act),"staminasystem");
	actions_list();
	$version=getsetting("installer_version","1.1.1 Dragonprime Edition");
	if ($version<"2.0.0"){
		$actiondebug = get_module_setting("actionsarray","staminasystem");
	} else {
		$sql="SELECT actions FROM ".db_prefix("staminaactionsarray");
		$result=db_query;
		$row=db_fetch_assoc($result);
		$actiondebug=unserialize($row['actions']);
	}
	debug($actiondebug);
	addnav("Continue");
	addnav("Continue","stamina.php?op=superuser");
}
if($op2 == "new"){
	$new = httppost('action');
	output("The action \"$new\" has been added.");
	$act = actions_list();
	$act[] = $new;
	$version=getsetting("installer_version","1.1.1 Dragonprime Edition");

	if ($version<"2.0.0"){
		set_module_setting("actionsarray",serialize($act),"staminasystem");
	} else {
		$sarray=serialize($act);
		$sql="INSERT INTO ".db_prefix("staminaactionsarray")." VALUES ($sarray)";
		db_query($sql);
	}

	$act = actions_list();
	addnav("Continue");
	addnav("Continue","stamina.php?op=superuser");
}
	
page_footer();

?>
