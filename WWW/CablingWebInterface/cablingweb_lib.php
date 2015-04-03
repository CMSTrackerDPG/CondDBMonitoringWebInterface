<?php

function SetMatrix (&$matrix, $entry_name)
{
	$num = 0;
	for ($i = 0; $i < count ($matrix); $i++)
	{
		for ($j = 0; $j < count ($matrix[$i]); $j++)
		{
			if ($_POST["${entry_name}"."_".$i."_".$j] != "")
			{
				$matrix[$i][$j] = $_POST["${entry_name}"."_".$i."_".$j];
				$num = $i;
			}
		}
	}
	
	for ($i = 0; $i <= $num; $i++)
	{
		for ($j = 0; $j < count ($matrix[$i]); $j++)
		{
			if ($matrix[$i][$j] == "-")
			{
				$matrix[$i][$j] = "";
			}
		}
	}
	
	
}

function AddMatrix (&$matrix)
{
	$num = 0;
	for ($i = 0; $i < count ($matrix); $i++)
	{
		if ($matrix[$i][0] == "-")
		{
			$num = $i;
			break;
		}
	}
	
	for ($j = 0; $j < count ($matrix[$num]); $j++)
	{
		$matrix[$num][$j] = "";
	}
}

function DeleteMatrix (&$matrix, $entry_name)
{
	$num = 0;
	for ($i = 0; $i < count ($matrix); $i++)
	{
		for ($j = 0; $j < count ($matrix[$i]); $j++)
		{
			if ($_POST["${entry_name}"."_".$i."_".$j] != "")
			{
				$matrix[$i][$j] = $_POST["${entry_name}"."_".$i."_".$j];
				$num = $i;
			}
		}
	}
	
	for ($j = 0; $j < count ($matrix[$num]); $j++)
	{
		$matrix[$num][$j] = "-";
	}
}

function AddInPower ($matrix_power, $entry_name)
{
	for ($i = 0; $i < count ($matrix_power); $i++)
	{
		if ($matrix_power[$i][0] != "-")
		{
			echo "cms_trk_dcs_<input name = '".$entry_name."_".$i."_0' value = '".$matrix_power[$i][0]."' type='text' size=10/>:CAEN ";
		}
		if ($matrix_power[$i][1] != "-")
		{
			echo "CMS_TRACKER_SY1527_<input name = '".$entry_name."_".$i."_1' value = '".$matrix_power[$i][1]."' type='text' size=10/>";
		}
		if ($matrix_power[$i][2] != "-")
		{
			echo "branchController<input name = '".$entry_name."_".$i."_2' value = '".$matrix_power[$i][2]."' type='text' size=10/>";
		}
		if ($matrix_power[$i][3] != "-")
		{
			echo "easyCrate<input name = '".$entry_name."_".$i."_3' value = '".$matrix_power[$i][3]."' type='text' size=10/>";
		}
		if ($matrix_power[$i][4] != "-")
		{
			echo "easyBoard<input name = '".$entry_name."_".$i."_4' value = '".$matrix_power[$i][4]."' type='text' size=10/>";
			echo "<br>";
		}
	}
// 	echo "<input type = 'submit' name = 'add_power' value = 'Add' />";
// 	echo "<input type = 'submit' name = 'del_power' value = 'Del' />";
	echo "<br>";
}

function formString ($list, & $list_string)
{
	for ($i = 0; $i < count ($list); $i ++)
	{
		if ($list[$i] != "-")
		{
			$list_string = $list_string." ".$list[$i];
		}
		
	}
}

?>