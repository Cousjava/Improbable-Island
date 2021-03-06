<?php

require_once("common.php");
global $session,$inventory;

page_header("Inventory");

$op = httpget("op");
$from = httpget('from');
$key = httpget('key');
$transferto = httpget('transferto');
$invloc = httpget('invloc');

$items_useitem = httpget("items_useitem");
$items_discarditem = httpget("items_discarditem");
$items_transferitem = httpget("items_transferitem");
$items_transferto = httpget("items_transferto");
$context = httpget("items_context");

require_once("lib/modules/superuser.php");

switch($op){
		case "superuser":
			require_once("modules/iitems/lib/superuser.php");
			iitems_superuser();
		break;
		case "useitem":			
			iitems_use_item($key,false,$invloc);
		break;
		case "transferitem":			
			iitems_transfer_item($key,$transferto);
		break;
		case "discarditem":			
			iitems_discard_item($key);
		break;
}

modulehook("iitems-show-inventory");
// iitems_show_inventory($from,"main");
// if (get_module_setting("fightinventory")){
	// output_notl("`n`n");
	// iitems_show_inventory($from,"fight");
// }
iitems_show_inventory_new($from);
switch ($from){
	case "village":
		addnav("Return");
		addnav("Return to the Outpost","village.php");
		break;
	case "forest":
		addnav("Return");
		addnav("Return to the Jungle","forest.php");
		break;
	case "worldnav":
		addnav("Return");
		addnav("Return to the World Map","runmodule.php?module=worldmapen&op=continue");
		break;
	case "lodge":
		addnav("Return");
		addnav("Return to the Hunter's Lodge","runmodule.php?module=iitems_hunterslodge&op=start");
}
modulehook("iitems_inventory_from");

page_footer();

/*
//handle moving, using, discarding, and contexts
if ($items_transferitem && $items_transferto){
	move_item($items_transferitem,$items_transferto);
}

if ($items_useitem){
	use_item($items_useitem,$context);
}

if ($items_discarditem){
	delete_item($items_discarditem);
}

load_inventory();
//debug($inventory);

$hook = array(
	'inventory' => $inventory,
	'context' => $context,
);
$new = modulehook("inventory-predisplay",$hook);
if ($hook != $new){
	load_inventory();
}

addnav("Sort by...");
addnav("Recently Acquired","inventory.php?items_sort=key&items_context=$context");
addnav("Alphabetical","inventory.php?items_sort=alpha&items_context=$context");
addnav("Quantity","inventory.php?items_sort=qty&items_context=$context");

$sort = httpget("items_sort");
$gr = group_items($inventory,$sort);
//debug($gr);

// switch ($sort){
	// case "key":
		// arsort($gr);
		// usort($gr, 'sortcarriers');
	// break;
	// case "alpha":
		// usort($gr,'alphacompare');
		// usort($gr, 'sortcarriers');
	// break;
	// case "qty":
		// usort($gr,'qtycompare');
		// usort($gr, 'sortcarriers');
	// break;
// }
// //debug($gr);

$hook = array(
	'inventory' => $gr,
	'context' => $context,
	'sort' => $sort,
);
$hook = modulehook("inventory",$hook);

$context = $hook['context'];
$inventory = $hook['inventory'];

$dinv = array();
$carriers = array();

//arrange display inventory
foreach ($inventory AS $itemid => $vals){
	if (!$vals['carrieritem']){
		$dinv[$vals['inventorylocation']]['items'][$itemid] = $vals;
	} else {
		$dinv[$vals['carrieritem']]['carrier'] = $vals;
		$carriers[$vals['carrieritem']] = $vals;
	}
}

output("Jump to: ");
foreach($carriers AS $carrier => $vals){
	rawoutput("<a href=\"#".$carrier."\">".$vals['verbosename']."</a> | ");
}

foreach($dinv AS $carrier => $cvals){
	//debug($cvals);
	rawoutput("<a name=\"$carrier\"></a><table width=100% style='border: dotted 1px #000000'><tr><td>");
	if ($cvals['carrier']['image']) rawoutput("<table width=100% cellpadding=0 cellspacing=0><tr><td>");
	output_notl("`b%s`b`n",$cvals['carrier']['verbosename']);
	output_notl("`0%s`n",$cvals['carrier']['description']);
	$cun = "kg";
	if ($cvals['carrier']['units']) $cun = $cvals['carrier']['units'];
	if ($cvals['carrier']['weight_max']){
		if (!isset($cvals['carrier']['weight_current'])){
			$cvals['carrier']['weight_current'] = 0;
		}
		require_once "lib/bars.php";
		$bar = flexibar($cvals['carrier']['weight_current'],$cvals['carrier']['weight_max'],$cvals['carrier']['weight_max']*5);
		rawoutput("<table><tr><td>".$bar."</td><td>");
		output_notl("%s / %s %s`n",$cvals['carrier']['weight_current'],$cvals['carrier']['weight_max'],$cun);
		rawoutput("</td></tr></table>");
	}
	if ($cvals['carrier']['image']) rawoutput("</td><td align=right width=100px><img src=\"images/items/".$cvals['carrier']['image']."\"></td></tr></table>");
	// debug($carrier);
	// debug($cvals);
	if (is_array($cvals['items']) && count($cvals['items'])){
		rawoutput("<table width=100% style='border: dotted 1px #000000; margin-left:10px; padding-right:-10px;'>");
		foreach($cvals['items'] AS $sortid => $prefs){
			$itemid = $prefs['itemid'];
			$classcount+=1;
			$class=($classcount%2?"trdark":"trlight");
			rawoutput("<tr class='$class'><td>");
			//debug($itemid);
			if ($prefs['image']) rawoutput("<table width=100% cellpadding=0 cellspacing=0><tr><td width=100px align=center><img src=\"images/items/".$prefs['image']."\"></td><td>");
			output_notl("`0`b%s`b`n",$prefs['verbosename']);
			if ($prefs['quantity'] > 1){
				output_notl("Quantity: `b`J%s`0`b | ",$prefs['quantity']);
			}
			if ($prefs['weight']){
				$un = "kg";
				if ($prefs['units']) $un = $prefs['units'];
				if ($prefs['quantity'] > 1){
					output_notl("Weight: %s %s each, `@`b%s`b`0 %s total | ",$prefs['weight'],$un,$prefs['weight']*$prefs['quantity'],$un);
				} else {
					output_notl("Weight: `@`b%s`b`0 %s | ",$prefs['weight'],$un);
				}
			}
			// debug($prefs);
			//links to use/discard/transfer items
			//do the use link first
			$divide=false;
			if ($prefs['context_'.$context] && !$prefs['blockuse']) {
				$divide = true;
				rawoutput("<a href=\"inventory.php?items_useitem=$itemid&items_context=$context&items_sort=$sort\">Use</a>");
				addnav("","inventory.php?items_useitem=$itemid&items_context=$context&items_sort=$sort");
			}
			if ($divide) output_notl(" | ");
			$divide=false;
			if (!$prefs['cannotdiscard']){
				$divide = true;
				rawoutput("<a href=\"inventory.php?items_discarditem=$itemid&items_context=$context&items_sort=$sort\">Discard</a>");
				addnav("","inventory.php?items_discarditem=$itemid&items_context=$context&items_sort=$sort");
			}
			if ($divide) output_notl(" | ");
			$divide=false;
			
			//now handle moving items from one carrier to another
			if (!$cvals['carrier']['blocktransferout']){
				foreach($carriers AS $carrier => $cprefs){
					if ($divide) output_notl(" | ");
					$divide=false;
					if (!$cprefs['blocktransfer'] || $prefs['allowtransfer']==$carrier){ //the carrier doesn't block transfers in OR this item is specifically allowed in
						if ($prefs['inventorylocation']!=$carrier){ //the item is not already in the carrier
							if (!$prefs['blockcarrier_'.$carrier]){ //the item is not blocked from being in this carrier
								if (!$prefs['blocktransfer'] || $prefs['allowtransfer']==$carrier){ //the item is not blocked from being transferred completely OR the item is allowed to be transferred to only this carrier
									$cvname = $cprefs['verbosename'];
									//check hard weight limits
									if ($cprefs['wlimit_hardlimit']){
										//check weight
										if ($cprefs['weight_max'] < ($cprefs['weight_current'] + $prefs['weight'])){
											//rawoutput("This item won't fit in your $cvname<br />");
											continue;
										}
									}
									$divide = true;
									rawoutput("<a href=\"inventory.php?items_transferitem=$itemid&items_transferto=$carrier&items_context=$context&items_sort=$sort\">Transfer to your $cvname</a>");
									addnav("","inventory.php?items_transferitem=$itemid&items_transferto=$carrier&items_context=$context&items_sort=$sort");
								}
							}
						}
					}
				}
			}
			if (isset($prefs['inventoryactions'])) rawoutput($prefs['inventoryactions']);
			output_notl("`n`0%s`n",$prefs['description']);
			if (isset($prefs['inventorydisplay'])) output_notl("`0%s`n",$prefs['inventorydisplay']);
			if ($prefs['image']) rawoutput("</td></tr></table>");
			rawoutput("</td></tr>");
		}
		rawoutput("</table>");
	} else {
		output_notl("`bEmpty`b`n");
	}
	rawoutput("</td></tr></table><br />");
}


//handle return links
addnav("Return");
//addnav("Back to where you came from",iitems_return_link($context)"village.php");
//addnav("Back to where you came from",iitems_return_link($context)"village.php");*/

page_footer();
?>

