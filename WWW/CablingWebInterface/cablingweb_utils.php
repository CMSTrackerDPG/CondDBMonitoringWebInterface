<?php

function FindLessString ($reference_string, $list_strings)
{
	$found_less_string = false;
	$index_list_string = 0;
	for ($i = 0; $i < count ($list_strings); $i++)
	{
		if (strcmp ($reference_string, $list_strings[$i]) == 0)
		{
			$index_list_string = $i;
			$found_less_string = false;
			break;
		}
		else if (strcmp ($reference_string, $list_strings[$i]) > 0)
		{
			$index_list_string = $i;
			$found_less_string = true;
		}
		else if (strcmp ($reference_string, $list_strings[$i]) < 0)
		{
			$index_list_string = $i - 1;
			$found_less_string = true;
			break;
		}
	}
	
	if ($index_list_string == -1)
	{
		$index_list_string = 0;
		$found_less_string = true;
	}
	
	
	return $list_strings[$index_list_string];
}

function FindLessStringListKey ($string_input, $key_list, & $list_input) 
{
	while (current ($list_input))
	{
		if ($key_list == key ($list_input))
		{
			$string_input = FindLessString ($string_input, $list_input[key ($list_input)]);
			break;
		}
		next ($list_input);
	}
	return $string_input;
}

function ReturnListSubDirs($directory) 
{
// 	exec ("ls -F ${directory} | grep /", $lista);
	exec ("ls -F ${directory} | grep CablingInfo", $lista);
	return $lista;
	
}

function GenerateRunNumberList ($directory) 
{
	$list_return = ReturnListSubDirs($directory);
	$list_temp = array();
	for ($i = 0; $i < count($list_return); $i++)
	{
		$list_return[$i] = str_replace("CablingInfo_Run", "", $list_return[$i]);
		$list_return[$i] = str_replace(".txt", "", $list_return[$i]);
		if ((string) intval($list_return[$i]) != "0")
		{
			$list_temp[] = $list_return[$i];
		}
	}
	unset($list_return);
	$list_return = $list_temp;
// 	unset($list_temp);
	return $list_return;
	
}


?> 
