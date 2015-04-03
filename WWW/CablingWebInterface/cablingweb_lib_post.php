<?php

include 'cablingweb-lib.php';

function vectorAddDel (&$feature, &$fedid, &$module, &$pairnum, &$fechan, &$alias, &$subde, &$hv)
{
	if (isset ($_POST["add_feature"]))
	{
		addVector ($feature);
	}
	
	if (isset ($_POST["del_feature"]))
	{
		delVector ($feature, "feature");
	}
	
// 	if (isset ($_POST["add_fedid"]))
// 	{
// 		addVector ($fedid);
// 	}
// 	
// 	if (isset ($_POST["del_fedid"]))
// 	{
// 		delVector ($fedid, "fedid");
// 	}
	
	if (isset ($_POST["add_module"]))
	{
		addVector ($module);
	}
	
	if (isset ($_POST["del_module"]))
	{
		delVector ($module, "module");
	}
	
	if (isset ($_POST["add_pairnum"]))
	{
		addVector ($pairnum);
	}
	
	if (isset ($_POST["del_pairnum"]))
	{
		delVector ($pairnum, "pairnum");
	}
	
	if (isset ($_POST["add_fechan"]))
	{
		addVector ($fechan);
	}
	
	if (isset ($_POST["del_fechan"]))
	{
		delVector ($fechan, "fechan");
	}
	
	if (isset ($_POST["add_alias"]))
	{
		addVector ($alias);
	}
	
	if (isset ($_POST["del_alias"]))
	{
		delVector ($alias, "alias");
	}
	
	if (isset ($_POST["add_subde"]))
	{
		addVector ($subde);
	}
	
	if (isset ($_POST["del_subde"]))
	{
		delVector ($subde, "subde");
	}
	
	if (isset ($_POST["add_hv"]))
	{
		addVector ($hv);
	}
	
	if (isset ($_POST["del_hv"]))
	{
		delVector ($hv, "hv");
	}
	
}
	
?>