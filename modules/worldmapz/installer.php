<?php
function worlmapz_install_real(){
	$version=getsetting("installer_version","1.1.1 Dragonprime Edition");
	if ((!is_module_installed("cities"))&& $version<"2.0.0") {
		output("`b`^***** This module requires the Multiple Cities module to be installed, or for you to use 2.x Elvenhall Edition. *****`b`7");
		return false;
	} else {
		module_addhook("village");
		module_addhook("villagenav");
		module_addhook("mundanenav");
		module_addhook("superuser");
		module_addhook("pvpcount");
		module_addhook("footer-gypsy");
		module_addhook("count-travels");
		module_addhook("changesetting");
		module_addhook("boughtmount");
		module_addhook("newday");
		module_addhook("items-returnlinks");
	}
	if (is_module_installed("staminasystem")||$version>"2.0.0") {
		require_once('modules/staminasystem/lib/lib.php');
		install_action("Travelling - Plains",array(
			"maxcost"=>5000,
			"mincost"=>2500,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>25,
			"class"=>"Travelling"
		));
		install_action("Travelling - Jungle",array(
			"maxcost"=>10000,
			"mincost"=>4000,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>60,
			"class"=>"Travelling"
		));
		install_action("Travelling - River",array(
			"maxcost"=>15000,
			"mincost"=>5000,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>100,
			"class"=>"Travelling"
		));
		install_action("Travelling - Ocean",array(
			"maxcost"=>25000,
			"mincost"=>7500,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>175,
			"class"=>"Travelling"
		));
		install_action("Travelling - Mountains",array(
			"maxcost"=>20000,
			"mincost"=>6000,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>140,
			"class"=>"Travelling"
		));
		install_action("Travelling - Snow",array(
			"maxcost"=>25000,
			"mincost"=>7500,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>175,
			"class"=>"Travelling"
		));
		install_action("Travelling - Beach",array(
			"maxcost"=>5000,
			"mincost"=>2500,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>25,
			"class"=>"Travelling"
		));
		install_action("Travelling - Swamp",array(
			"maxcost"=>12500,
			"mincost"=>5000,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>75,
			"class"=>"Travelling"
		));
		install_action("Travelling - Cave",array(
			"maxcost"=>20000,
			"mincost"=>6000,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>140,
			"class"=>"Travelling"
		));
		install_action("Travelling - Roads",array(
			"maxcost"=>4000,
			"mincost"=>1000,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>20,
			"class"=>"Travelling"
		));
		install_action("Travelling - Air",array(
			"maxcost"=>25000,
			"mincost"=>7500,
			"firstlvlexp"=>500,
			"expincrement"=>1.1,
			"costreduction"=>175,
			"class"=>"Travelling"
		));
	} 
	return true;
}
?>
