<?php

function counciloffices_getmoduleinfo(){
	$info = array(
		"name"=>"Council Offices",
		"author"=>"Cousjava",
		"version"=>"2010-12-20",
		"category"=>"Council Offices",
		"download"=>"",
	);
	return $info;
}

function counciloffices_install(){
	module_addhook("village");
	return true;
}

function counciloffices_uninstall(){
	return true;
}

function counciloffices_dohook($hookname,$args){
	global $session;
	switch($hookname){
		case "village":
			tlschema($args['schemas']['fightnav']);
			addnav($args['fightnav']);
			tlschema();
			addnav("Council Offices","runmodule.php?module=counciloffices&councilop=enter");
			break;
	}
	return $args;
}

function counciloffices_run(){
	global $session;
	page_header("Council Offices");
	switch (httpget('councilop')){
		case "enter":
			switch ($session['user']['location']){
				case "NewHome":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with a man inside reading a newspaper behind a desk.  He looks up as you come in.`n`n\"`1Can I help you?`0\"`n`n");
					break;
				case "Kittania":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with a patient-looking KittyMorph sat behind a desk inside.  She looks up as you come in.`n`n\"`1What can I do for you?`0\"`n`n");
					break;
				case "New Pittsburgh":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with a patient-looking Zombie sat behind a desk inside.  She looks up as you come in.`n`n\"`1What can I do for you?`0\"`n`n");
					break;
				case "Squat Hole":
					output("You step into the dilapidated Council Offices.  For a moment, you believe yourself to be alone; then, you notice the shining bald head sat behind the desk.  A squeaky voice shouts \"`1Y'arright there chuck, what d'ya want?`0\"`n`n");
					break;
				case "Pleasantville":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with a patient-looking Mutant sat behind a desk inside.  He looks up as you come in.`n`n\"`1What can I do for you?`0\"`n`n");
					break;
				case "Cyber City 404":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with a stern-looking Robot sat behind a desk inside.  He looks up as you come in.`n`n\"`1State your request.`0\"`n`n");
					break;
				case "AceHigh":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with an immaculately-dressed woman sat reading a newspaper behind a desk.  She looks up as you come in, eyes giving off a faint green glow.`n`n\"`1What can I do for you?`0\"`n`n");
					break;
				case "Improbable Central":
					output("The \"Council Offices\" of this Outpost amount to a tiny hut with a man inside reading a newspaper behind a desk.  He looks up as you come in.`n`n\"`1Can I help you?`0\"`n`n");
					break;
			}
			addnav("State your business.");
			addnav("You know, I don't have a clue what I came in here for.  Back to the Outpost.","village.php");
			addnav("What's the monster situation like here?","runmodule.php?module=counciloffices&councilop=monster");
			addnav("Where's worst off?","runmodule.php?module=counciloffices&councilop=maxmonsters");
			break;
		case "monster":
		require_once("modules/onslaught.php");
		require_once("modules/cityprefs/lib.php");
		$localmonsters = counciloffices_localmonsters();
			switch ($session['user']['location']){
				case "NewHome":					
					output("The human looks at a sheet of paper in front of him. \"`1Ah, yes,`0\" he says. \"`1There are about %s monsters around here.`0\"`n`n",e_rand($localmonsters*0.9,$localmonsters*1.1));
					break;
				case "Kittania":
					output("The kittymorph pauses a moment. \"`1That's it?`0\" she says. \"`1Oh, there are about %s monsters around,`0\" quite possibly just pulling the number from the top of her head.`n`n",e_rand($localmonsters*0.8,$localmonsters*1.2));
					break;
				case "New Pittsburgh":
					output("The zombie smiles at you. \"`1There are about %s BRAAAAIIIINS waiting to be eaten out there.`0\"`n`n",e_rand($localmonsters*0.9,$localmonsters*1.1));
					break;
				case "Squat Hole":
					output("\"`1Why shud I care?`0\" come the answer. \"`1Mi' be 'round %s, dick'ead.`n`n",e_rand($localmonsters*0.8,$localmonsters*1.2));
					break;
				case "Pleasantville":
					output("The mutant sighs. \"`1There are %s monsters out there. It proves once and for all we're doomed, all doomed.`0\"`n`n",e_rand($localmonsters*0.9,$localmonsters*1.1));
					break;
				case "Cyber City 404":
					output("The robot checks a scanner.\"`1There are %s monsters in this area, with a margin of 5 per cent`0\"`n`n",e_rand($localmonsters*0.95,$localmonsters*1.05));
					break;
				case "AceHigh":
					output("The joker nods in response to your question, and `gvanishes`0 in a puff of green smoke. You think you perhaps should leave, but a moment later she reappears. There is some blood on her which you are `isure`i wasn't there before.\"`1There are %s monsters herabouts,`0\" she says.\"`1Currently.\"`n`n",e_rand($localmonsters*0.9,$localmonsters*1.1));
					break;
				case "Improbable Central":
					output("The man sighs, folds up his newspaper and disappears through a door benind the desk. A moment later he comes out again, and gives the answer.\"`1There are about %s monsters out there. Okay?`0\" He sits down again and reopens the newspaper, which you notice is last week's `iEnquirer`i, in which he seems to be doing the crossword.`n`n",e_rand($localmonsters*0.9,$localmonsters*1.1));
					break;
			}
			addnav("Okay");
			addnav("Stay in offices","runmodule.php?module=counciloffices&councilop=stay");
			addnav("Return to outpost","village.php");
			addnav("What about other places?","runmodule.php?module=counciloffices&councilop=maxmonsters");
			break;
		case "stay":
			addnav("What now?");
			addnav("Return to Outpost","village.php");
			addnav("What's the monster situation like here?","runmodule.php?module=counciloffices&councilop=monster");
			addnav("Where's worst off?","runmodule.php?module=counciloffices&councilop=maxmonsters");
			break;
		case "maxmonsters":
			addnav("What now?");
			addnav("Stay here","runmodule.php?module=counciloffices&councilop=stay");
			addnav("Return to Outpost","village.php");
			
			//This outputs data on all outposts.
			$manning = counciloffices_worldmonsters();
			//Lets see hwo it works now
			
			//for debugging purposes only, delete later
			if ($maxn["city"]==null)
			{
				output("maxncity was null");
			}
			if ($maxn["city"]=="none")
			{
				output("maxnxcity was none");
			}
			
			//output("maxncity with double is %s.",$maxn["city"]);
			//output("maxncity with single is %s",$maxn['city']);
			break;
	}
	modulehook("counciloffices");
	page_footer();
}

function counciloffices_localmonsters($cid="none"){
	global $session;
	require_once "modules/cityprefs/lib.php";
	if ($cid=="none"){
		$cid = get_cityprefs_cityid("location",$session['user']['location']);
	}
	$creatures = get_module_objpref("city",$cid,"creatures","onslaught");
	return $creatures;
}

function counciloffices_maxmonsters(){
	global $session;
	require_once "modules/cityprefs/lib.php";
	if ($cid=="none"){
		$cid = get_cityprefs_cityid("location",$session['user']['location']);
	}
	$sql = "SELECT * FROM ".db_prefix("module_objprefs")." WHERE modulename='onslaught' AND setting='creatures' ORDER BY value DESC LIMIT 1";
	$result=mysql_query($sql);
	//$cid=mysql_result($result,0,"objid");
	$maxmonsters=mysql_result($result,0,"value");
	$cid=mysql_result($result,0,"objid");
	//$maxcname=get_cityprefs_cityname('cityprefs',$cid);
	$maxcname=counciloffices_getcityname($cid);
	//FOR DEBUGGING
	$maxm = array("monsters"=>$maxmonsters,"city"=>$maxcname,"cid"=>$cid,"breach"=>0);
	return $maxm;
}

function counciloffices_getcityname($cid)
{
	$where=$cid;
	$sql="SELECT * FROM ".db_prefix("cityprefs")." WHERE cityid=\"$where\"";	
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);	
	$res=mysql_result($result,0,'cityname');	
	return $res;
	
}

function counciloffices_checkmonsters($cid="none"){	
	$maxmonsters = counciloffices_maxmonsters();
	
	$breachpoint = get_module_objpref("city",$cid,"breachpoint","onslaught");
	
	if ($maxmonsters["monsters"]==0){
		$maxmonsters["breach"]=1;
	}else{
		$maxmonsters["breach"]=($maxmonsters["monsters"]/$breachpoint)*100;
	}
	return $maxmonsters;
}

function counciloffices_worldmonsters(){
	
	$sql="SELECT * FROM ".db_prefix("module_objprefs")." WHERE modulename='onslaught' AND setting ='creatures' ORDER BY value DESC";
	$result=mysql_query($sql);
	$rows=mysql_num_rows($result);
	$arr[] = array();
	for($i=0;i<$rows;$i++)
	{
		$arr[$i]=array(
			"cid"=>mysql_result($result,$i,'objid'),
			"monsters"=>mysql_result($result,$i,'value'));	
	}
	$breachpoint= get_module_objpref("city",$arr[$i]["cid"],"breachpoint","onslaught");
	for($i=0;i<$rows;$i++)
	{
		$cname=counciloffices_getcityname($arr[$i]["cid"]);
		$arr[$i]["cname"]=$cname;
		
		$level = ($arr[$i]["monsters"]/$breachpoint)*100;
		$arr[$i]["level"]=$level;
		$arr[$i]["randmonsters"]=e_rand($arr[$i]["monsters"]*0.9,$arr[$i]["monsters"]*1.1);
	}
	rawoutput("<table><tr><td>City</td><td>Monsters</td></tr>");
	for ($i=1;$i<$rows;$i++)
	{
		//rawoutput("<tr><td>%s",$arr[$i]["cname"]);//output("%s",$arr[$i]["cname"]);
		//rawoutput("</td><td>%s",$arr[$i]["monsters"]);//output("%s",$arr[$i]["monsters"]);
		//rawoutput("</td></tr>");
		rawoutput("<tr><td>%s</td><td>%s</td></tr>",$arr[$i]["cname"],$arr[$i]["monsters"]);
	}
	rawoutput("</table>");
	return;

}
?>
