<?php

include 'cablingweb_lib.php';

function selectOptionsArray ($listopt, $listoptions)
{
	echo "<select name = 'listopt' >";
	echo "<option value = ''> </option>";
	while (current ($listoptions))
	{
		$option = current ($listoptions);
		if ($listopt == key ($listoptions))
		{
			echo "<option value = '".key ($listoptions)."' selected > ".$option;
		}
		else
		{
			echo "<option value = '".key ($listoptions)."' > ".$option;
		}
		next ($listoptions);
	}
	echo "</select>";
}

function selectOptionsArrayMultiple ($listopt, $listoptions)
{
	echo "<select multiple name = 'listopt' size=" . count ($listoptions) . ">";
	echo "<option value = ''> </option>";
	while (current ($listoptions))
	{
		$option = current ($listoptions);
		if ($listopt == key ($listoptions))
		{
			echo "<option value = '".key ($listoptions)."' selected > ".$option;
		}
		else
		{
			echo "<option value = '".key ($listoptions)."' > ".$option;
		}
		next ($listoptions);
	}
	echo "</select>";
}

function SelectOptionsArrayMultipleKeyValue ($key_name, $key_option, $list_input)
{
	echo "<select multiple name = '$key_name' size=" . count ($list_input) . ">";
	echo "<option value = ''> </option>";
	while (current ($list_input))
	{
		if ($key_option == key ($list_input))
		{
			echo "<option value = '".key ($list_input)."' selected > ".key ($list_input);
		}
		else
		{
			echo "<option value = '".key ($list_input)."' > ".key ($list_input);
		}
		next ($list_input);
	}
	echo "</select>";
}

function SelectListMenu ($select_name, $element_selected, & $list_input) 
{
	echo "<select multiple name='$select_name' size=5>";
	echo "<option value=''> </option>";
	foreach ($list_input as $list_input_element)
	{
		if ($element_selected == $list_input_element)
		{
			echo "<option value=$list_input_element SELECTED>$list_input_element</option>";
		}
		else
		{
			echo "<option value=$list_input_element >$list_input_element</option>";
		}
	}
	echo "</select>";
}

function selectProcess ($listopt, &$exeok, &$exeok2, &$feature, &$fedid, &$fec, &$detid, &$aliass, &$matrix_power)
{

	if ($listopt == "execopt1") 
	{
		echo "Alias properties, examples: TECminus_2 or TECminus_2_4 or TECminus_5_3_2_2_2 or TOBplus_1 or TIBplus  <br>";
		echo " <textarea name='aliass' rows = '10' cols = '20'>".$aliass."</textarea>";
		echo "<br>";
		if ($aliass != "") 
		{
			$exeok2 = true;
		}
			
	}
	if ($listopt == "execopt2") 
	{
		echo "FedIds, examples: 164/8/12 or  164/6 or 164_0 or 166_4 or 165/7 <br>";
		echo " <textarea name='fedid' rows = '10' cols = '20'>".$fedid."</textarea>";
		echo "<br>";
		if ($fedid != "") 
		{
			$exeok2 = true;
		}
	}
	
	if ($listopt == "execopt3") 
	{
//		echo "Fec: <br>";
		echo "Fecs. FecCrate/FecSlot/FecRing/CcuAddr/CcuChan, examples: 3 or 3/3 or 3/16/3  or 3/3/1/111 or 3/3/1/111/24 <br>";
		echo " <textarea name='fec' rows = '10' cols = '20'>".$fec."</textarea>";
		echo "<br>";
		if ($fec != "") 
		{
			$exeok2 = true;
		}
	}

	if ($listopt == "execopt4") 
	{
		echo "Modules: <br>";
		echo " <textarea name='detid' rows = '10' cols = '13'>".$detid."</textarea> <br>";
//		echo "pink: module not connected <br>";
		echo "NOTE: If the modules are not connected they will be pink <br>";
		echo "<br>";
		if ($detid != "") 
		{
			$exeok2 = true;
		}
	}

	if ($listopt == "execopt5") 
	{
		echo "Power supply name: <br>";
		AddInPower ($matrix_power, "power");
		if ($matrix_power[0][0] != "") 
		{
			$exeok2 = true;
		}
	}
	
	if ($listopt == "execopt6") {
		$exeok2 = true;
	}
}

function selectProcessBash ($listopt, &$option1, &$option2, &$option3, &$option4, &$option5, &$option6, &$option7, &$option8 )
{
	if ($listopt == "execopt1") 
	{
// 		$execution = "1";
		$option1 = "-y";
		$option2 = "--y1";
		$option3 = "--y2";
		$option4 = "--y3";
		$option5 = "--y4";
		$option6 = "--y5";
	} 
	else if ($listopt == "execopt2") 
	{
		$option1 = "-b FedId";
		$option2 = "--bi";
		$option3 = "--b1";
		$option4 = "--b2";
		$option5 = "--b3";
		$option6 = "--b4";
		$option7 = "--b5";
		$option8 = "--b6";
	} 
	else if ($listopt == "execopt3") 
	{
		$option1 = "-b FecCrate";
		$option2 = "--bi";
		$option3 = "--b1";
		$option4 = "--b2";
		$option5 = "--b3";
		$option6 = "--b4";
		$option7 = "--b5";
		$option8 = "--b6";
	} 
	else if ($listopt == "execopt4") 
	{
		$option1 = "-a";
		$option2 = "--a1";
		$option3 = "--a2";
		$option4 = "--a3";
		$option5 = "--a4";
		$option6 = "--a5";

	} 
	else if ($listopt == "execopt5") 
	{
		$option1 = "-v";
		$option2 = "--v1";
		$option3 = "--v2";
		$option4 = "--v3";
		$option5 = "--v4";
		$option6 = "--v5";
	} 
 	else if ($listopt == "execopt6") 
 	{
 		$option1 = "--c1";
 		$option2 = "--c2";
 		$option3 = "--c3";
 		$option4 = "--c4";
 		$option5 = "--c5";
 	}
}

?>