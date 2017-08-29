<H1>GET Cabling, PowerGroupName, PSUname info and a TrackerMap</H1>


<?php
	include 'cablingweb_lib_post.php';
	include 'cablingweb_lib_select.php';
	include 'cablingweb_utils.php';
	
	$inpfile = "";
	$plotwidth = "1200";
	
	$options_set = array_fill (0, 5, "-");
	$power_set = array_fill (0, 10, $options_set);
	
	$exeok = false;
	$exeok2 = false;
	$searchCabFile = false;
	$listopt = "";
	$is_select_options = false; 
	$previous_select_userfile = false;
	$enable_same_colors = "";

	$listoptions = array
	(
	"execopt1" => "1. Alias Info",
	"execopt2" => "2. Feds Info",
	"execopt3" => "3. Fecs Info",
	"execopt4" => "4. DetIDs Info",
	"execopt5" => "5. Power supply info",
	"execopt6" => "6. All Cabling file info",
	"execopth" => "Show Help"
	);

	$tagSel = ""; 
	
	#### TO BE CHANGED
	$directory_tags = "/data/users/event_display/CondDBMonitoringWebInterface/CondDBMonitoringWebInterface/tmp/dev/CMS_CONDITIONS/DBTagCollection/SiStripFedCabling/";
	#### TO BE CHANGED
	
	$list_tags_iovs = GenerateTags($directory_tags);
	
	$hv_option_button = ""; 
	
	if(isset($_POST["next"]) || isset($_POST["go"])) 
	{
		$inpfile = $_POST['userfile'];
		$userfile = $_POST['userfile'];
		$listopt = $_POST["listopt"];
		$tagSel = $_POST["tagSel"];
		
		$cabling_file_selected = $_POST["cabling_file_selected"];
		$hv_option_button = $_POST["hv_option_button"];

		$fedid = $_POST["fedid"];
		$fec = $_POST["fec"];
		$detid = $_POST["detid"];
		$aliass = $_POST["aliass"];
		$power = $_POST["power"];

		SetMatrix ($power_set, "power");
		
		$enable_same_colors = $_POST["samecolors"];
	}
	
	if (isset ($_POST["add_feature"]) || isset ($_POST["add_fedid"]) || isset ($_POST["add_module"]) || isset ($_POST["add_pairnum"]) || isset ($_POST["add_fechan"]) || isset ($_POST["add_alias"]) || isset ($_POST["add_subd"]) || isset ($_POST["add_hv"]) || isset ($_POST["add_power"]))
	{
		$inpfile = $_POST['userfile'];
		$userfile = $_POST['userfile'];
		$listopt = $_POST["listopt"];
		$tagSel = $_POST["tagSel"];

		$cabling_file_selected = $_POST["cabling_file_selected"];
		$hv_option_button = $_POST["hv_option_button"];
	
		$fedid = $_POST["fedid"];
		$fec = $_POST["fec"];
		$detid = $_POST["dedid"];
		$aliass = $_POST["aliass"];
		$power = $_POST["power"];

		SetMatrix ($power_set, "power");

		$enable_same_colors = $_POST["samecolors"];
	}
	
	if (isset ($_POST["del_feature"]) || isset ($_POST["del_fedid"]) || isset ($_POST["del_module"]) || isset ($_POST["del_pairnum"]) || isset ($_POST["del_fechan"]) || isset ($_POST["del_alias"]) || isset ($_POST["del_subd"]) || isset ($_POST["del_hv"]) || isset ($_POST["del_power"]))
	{
		$inpfile = $_POST['userfile'];
		$userfile = $_POST['userfile'];
		$listopt = $_POST["listopt"];
		$tagSel = $_POST["tagSel"];
		
		$cabling_file_selected = $_POST["cabling_file_selected"];
		$hv_option_button = $_POST["hv_option_button"];
		
		$fedid = $_POST["fedid"];
		$fec = $_POST["fec"];
		$detid = $_POST["detid"];
		$aliass = $_POST["aliass"];
		$power = $_POST["power"];

		SetMatrix ($power_set, "power");
		$enable_same_colors = $_POST["samecolors"];
	}
	
	vectorAddDel ($power_set);
	
?>

		<form enctype = "multipart/form-data" action = "cablingweb.php" method = "POST">
		<input type = "hidden" name = "MAX_FILE_SIZE" value = "500000" />
		<input type="hidden" name="outgrafic" value="/tmp/ourmap_<?php echo time(); ?>.png" />
		<input type="hidden" name="outfile" value="/tmp/ourfile_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outinfomodules" value="/tmp/ourinfomodules_<?php echo time() . "-" . mt_rand (); ?>.txt" />
	
		<input type="hidden" name="outDetidsofalias" value="/tmp/ourDetidsofalias_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="grafAliastkm" value="/tmp/ourgrafAliastkm_<?php echo time(); ?>.png" />
		<input type="hidden" name="outDetidstoHv" value="/tmp/ourDetidstoHv_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="grafHvtkm" value="/tmp/ourgrafHvtkm_<?php echo time(); ?>.png" />
		<input type="hidden" name="outHvAliascom" value="/tmp/ourHvAliascom_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outAliastohv" value="/tmp/ourAliastohv_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outCabofAlias" value="/tmp/ourCabofAlias_<?php echo time() . "-" . mt_rand (); ?>.txt" />


		<input type="hidden" name="grafModulescommonhv" value="/tmp/ourgrafModulescommonhv_<?php echo time(); ?>.png" />
		<input type="hidden" name="outHvofAlias" value="/tmp/ourHvofAlias_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outHvmodcom" value="/tmp/ourHvmodcom_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outHvAliasinfo" value="/tmp/ourHvAliasinfo_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outCabofhv" value="/tmp/ourCabofhv_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outCabmodalias" value="/tmp/ourCabmodalias_<?php echo time() . "-" . mt_rand (); ?>.txt" />

		<input type="hidden" name="outModofCab" value="/tmp/ourModofCab_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="grafModofCabtm" value="/tmp/ourgrafModofCabtm_<?php echo time(); ?>.png" />
		<input type="hidden" name="outinfofeds" value="/tmp/ourinfofeds_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outinfofecs" value="/tmp/ourinfofecs_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outDetidsofFedstrm" value="/tmp/ouroutDetidsofFedstrm_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outDetidsofFecstrm" value="/tmp/ouroutDetidsofFecstrm_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outAliasforCabling" value="/tmp/ourAliasforCabling_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outhvofcab" value="/tmp/ourhvofcab_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outAliasModules" value="/tmp/ourAliasModules_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outInfoModuleHV" value="/tmp/ourInfoModuleHV_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="grafDetIdsCab" value="/tmp/ourgrafDetIdsCab_<?php echo time(); ?>.png" />
		<input type="hidden" name="outinfomodules" value="/tmp/ourinfomodules_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outDetIdsCab" value="/tmp/ourDetIdsCab_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="grafcabling" value="/tmp/ourgrafcabling_<?php echo time(); ?>.png" />
		<input type="hidden" name="outdetids" value="/tmp/ouroutdetids_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="outDetidsofDetIDtrm" value="/tmp/ouroutDetidsofDetIDtrm_<?php echo time() . "-" . mt_rand (); ?>.txt" />
		<input type="hidden" name="grafModofdetidtm" value="/tmp/ourgrafModofdetidtm_<?php echo time(); ?>.png" />
		


		Run number (optional): <input name = "userfile" value = "<?php echo $userfile; ?>" type = "text" size = 15 />
		<br>
		<br>
		<?php

		if (isset($_POST["next"]) || isset($_POST["go"]) || isset ($_POST["add_power"]) || isset ($_POST["del_power"]) && $userfile == "")
	// 	if (!$searchCabFile)
		{
			$searchCabFile = true;
		}

		if ($userfile != "")
		{
	// 		$searchCabFile = false;
			$is_select_options = false;
			$previous_select_userfile = true;
		}
		

		if ($searchCabFile)
		{
			if ($tagSel == "")
			{
				$tagSel = "SiStripFedCabling_GR10_v1_hlt";
//				$tagSel = "SiStripFedCabling_GR09_31X_v1_hlt";
			}
			SelectOptionsArrayMultipleKeyValue ("tagSel", $tagSel, $list_tags_iovs); // Menú de selección del tag
		}
		
		if ($tagSel != "")
		{
			$is_select_options = true;
//			echo $userfile;
			echo "</a><br>";
			
			if ($userfile != "")
			{
				$userfile = FindLessString ($userfile, $list_tags_iovs[$tagSel]); // Búsqueda del runnumber que mejor coincida
			}
		}
		
		if ($tagSel != "" && $previous_select_userfile == false)
		{
			SelectListMenu ("cabling_file_selected", $cabling_file_selected, $list_tags_iovs[$tagSel]); // Selección de los RunNumber
			$searchCabFile = true;
		}
		
		if ($cabling_file_selected != "")
		{
			$previous_select_userfile = true;
		}
		
		if ($cabling_file_selected != "") 
		{
			$userfile = $tagSel . "/CablingLog/CablingInfo_Run" . $cabling_file_selected . ".txt"; // Formateo del CablingFile
			echo "</a><br><br>";
		}
		if ($cabling_file_selected != "")
		{
			echo "<b> <br>" . $tagSel . " - IOV " . $cabling_file_selected . "</b> <br> <br>";

		}
			else if ($userfile != "" && $tagSel != "")
		{
		        echo "<b> <br>" . $tagSel . " - IOV " . $userfile . "</b> <br> <br>";

		}		


		if ($is_select_options == true && $previous_select_userfile == true)
		{
			if ($listopt == "") // Si se ha seleccionado una opción se muestra como un menú desplegable
			{
				selectOptionsArrayMultiple ($listopt, $listoptions);
			}
			else // En caso contrario se muestra el menú múltiple
			{
				selectOptionsArray ($listopt, $listoptions);
			}
			echo "<br>";
			selectProcess ($listopt, $exeok, $exeok2, $feature, $fedid, $fec, $detid, $aliass, $power_set);
		}
		
		if ($listopt == "execopt5")
		{
			echo "<br>";
			if ($hv_option_button == "hv_option_1")
			{
			echo "<input name='hv_option_button' value='hv_option_1' type='radio' checked /> HV0";
			}
			else
			{
			echo "<input name='hv_option_button' value='hv_option_1' type='radio' /> HV0";
			}
			if ($hv_option_button == "hv_option_2")
			{
			echo "<input name='hv_option_button' value='hv_option_2' type='radio' checked /> HV1";
			}
			else
			{
			echo "<input name='hv_option_button' value='hv_option_2' type='radio' /> HV1";
			}
			if ($hv_option_button == "hv_option_both")
			{
			echo "<input name='hv_option_button' value='hv_option_both' type='radio' checked /> HV Both channels";
			}
			else
			{
			echo "<input name='hv_option_button' value='hv_option_both' type='radio' /> HV Both channels";
			}			
		}

	if ($listopt == "execopt4")
	   {		
		echo "<br>";
		if ($enable_same_colors == "same")
		{
			echo "Diferent colors: <input name='samecolors' value='same' type='checkbox' checked />";
		}
		else
		{
			echo "Diferent colors: <input name='samecolors' value='same' type='checkbox' />";
		}
	}

// 		echo $listopt . "<br>";
	?>
	<p><input onClick="return true;" name="next" type="submit" value="Next"/> 
	<input onClick="return true;" name="clear" type="submit" value="Clear"/><br>
	<input onClick="return true;" name="go" type="submit" value="Go!"/> </p>
</form>

<?php
// 	include 'plot_cablingweb_from_tmp_cabling.php';
// 	ini_set('display_errors', 'On');
// 	error_reporting(E_ALL);
	if(isset($_POST["go"])) {
		$outgrafic = $_POST["outgrafic"];
		$inpfile = $_POST["userfile"];


		$outDetidsofalias = $_POST["outDetidsofalias"];
		$grafAliastkm = $_POST["grafAliastkm"];
		$outDetidstoHv = $_POST["outDetidstoHv"];
		$grafHvtkm = $_POST["grafHvtkm"];
		$outHvAliascom = $_POST["outHvAliascom"];
		$grafModulescommonhv = $_POST["grafModulescommonhv"];
		$outHvofAlias = $_POST["outHvofAlias"];
		$outCabofAlias = $_POST["outCabofAlias"];
		$outAliastohv = $_POST["outAliastohv"];
		$outHvmodcom = $_POST["outHvmodcom"];
		$outHvAliasinfo = $_POST["outHvAliasinfo"];
		$outCabofhv = $_POST["outCabofhv"];
		$outCabmodalias = $_POST["outCabmodalias"];
		$outModofCab = $_POST["outModofCab"];
		$grafModofCabtm = $_POST["grafModofCabtm"];
		$outinfofeds = $_POST["outinfofeds"];
		$outinfofecs = $_POST["outinfofecs"];
		$outDetidsofFedstrm = $_POST["outDetidsofFedstrm"];
		$outDetidsofFecstrm = $_POST["outDetidsofFecstrm"];
		$outAliasforCabling = $_POST["outAliasforCabling"];
		$outhvofcab = $_POST["outhvofcab"];
		$grafcabling = $_POST["grafcabling"];
		$outdetids = $_POST["outdetids"];
		$outDetidsofDetIDtrm = $_POST["outDetidsofDetIDtrm"];
		$grafModofdetidtm = $_POST["grafModofdetidtm"];

		
		$outAliasModules = $_POST["outAliasModules"];
		$outInfoModuleHV = $_POST["outInfoModuleHV"];
		$grafDetIdsCab = $_POST["grafDetIdsCab"];
		$outDetIdsCab = $_POST["outDetIdsCab"];
		$outinfomodules = $_POST["outinfomodules"];
		
		$outfile = $_POST["outfile"];
		$outinfomodules = $_POST["outinfomodules"];
		
		$grafModulescommonhv = $_POST["grafModulescommonhv"];
		
		$enable_same_colors = $_POST["samecolors"];

		$fedid = $_POST["fedid"];
		$fec = $_POST["fec"];
		$detid = $_POST["detid"];
		$aliass = $_POST["aliass"];
		$power = $_POST["power"];


		if ($listopt !=  "execopth") 
		{
			if ($userfile != "")
			{
				selectProcessBash ($listopt, $option1, $option2, $option3, $option4, $option5, $option6, $option7, $option8 );
				
				$feature_string = "";
				$fedid_string = "";
				$fec_string = "";
				$detid_string = "";
				$aliass_string = "";
				$power_string = "";

				$module_string = "";
				$pairnum_string = "";
				$fechan_string = "";
				$alias_string = "";
				$subde_string = "";
				$hv_string = "";
				formString ($feature, $feature_string);
// 				formString ($fedid, $fedid_string);
				formString ($module, $module_string);
				formString ($pairnum, $pairnum_string);
				formString ($fechan, $fechan_string);
				formString ($alias, $alias_string);
				formString ($subde, $subde_string);
				formString ($hv, $hv_string);
				
				$colors[] = "green";
				$colors[] = "blue";
				$colors[] = "red";
				$colors[] = "yellow";
				$colors[] = "magenta";
				$colors[] = "light blue";
				$colors[] = "dark green";
				$colors[] = "purple";
				$colors[] = "grey";
				$colors[] = "orange";
				
			//	echo $feature_string."<br>";
				$fedid = str_replace("\r", " ", $fedid);
				$fedid = str_replace("\n", "", $fedid);
				$fec = str_replace("\r", " ", $fec);
				$fec = str_replace("\n", "", $fec);
				$detid = str_replace("\r", " ", $detid);
				$detid = str_replace("\n", "", $detid);
				$aliass = str_replace("\r", " ", $aliass);
				$aliass = str_replace("\n", "", $aliass);
				$power = str_replace("\r", " ", $power);
				$power = str_replace("\n", "", $power);
				
				$fedid_array = explode (" ", $fedid);
				$fec_array = explode (" ", $fec);
				$detid_array = explode (" ", $detid);
				$aliass_array = explode (" ", $aliass);
				
				if ($fedid != "")
				{
//				echo " if you type different FedIds numbers you get different colors for each of them <br>";
					for ($i = 0; $i < count ($fedid_array); $i++)
					{
						echo "<b>  " . $fedid_array[$i] . " = " . $colors[$i] . " </b> <br>";
					}
				}
				if ($fec != "")
				{
					for ($i = 0; $i < count ($fec_array); $i++)
					{
						echo "<b>  ". Fec ."" . $fec_array[$i] . " = " . $colors[$i] . " </b> <br>";
					}
				}
				if ($detid != "" && isset($_REQUEST['samecolors']))			if ($listopt == "") // Si se ha seleccionado una opción se muestra como un menú desplegable

//				if ($detid != "")
				{
					for ($i = 0; $i < count ($detid_array); $i++)
					{
						echo "<b>  " . $detid_array[$i] . " = " . $colors[$i] . " </b> <br>";
					}
				}				
				if ($aliass != "")
				{
					for ($i = 0; $i < count ($aliass_array); $i++)
					{
						echo "<b>  " . $aliass_array[$i] . " = " . $colors[$i] . " </b> <br>";
					}
				}
				
				
				if ($listopt == "execopt5")
				{
//					$power_string = "-v ";
					if ($power_set[0][0] != "")
					{
						$power_string = $power_string . "cms_trk_dcs_" . $power_set[0][0].":CAEN ";
					}
					if ($power_set[0][1] != "")
					{
						$power_string = $power_string . "CMS_TRACKER_SY1527_" . $power_set[0][1] . " ";
					}
					if ($power_set[0][2] != "")
					{
						$power_string = $power_string . "branchController" . $power_set[0][2] . " ";
					}
					if ($power_set[0][3] != "")
					{
						$power_string = $power_string . "easyCrate" . $power_set[0][3] . " ";
					}
					if ($power_set[0][4] != "")
					{
						$power_string = $power_string . "easyBoard" . $power_set[0][4]. " ";
					}
					if ($hv_option_button == "hv_option_1")
					{
						$power_string = $power_string . "HV0 ";
					}
					if ($hv_option_button == "hv_option_2")
					{
						$power_string = $power_string . "HV1 ";
					}					
				}
				

				if ($exeok2 == true)
				{ 
					if (10 < strlen ($userfile)) 
					{
						if ($listopt == "execopt1" ) 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $aliass $option2 $outDetidsofalias $option3 $outCabmodalias $option4 $grafAliastkm $option5 $outCabofAlias $option6 $outHvofAlias ";
						} 
						else if ($listopt == "execopt2" ) 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $option2 $fedid $option3 $outinfofeds $option4 $outModofCab $option5 $outDetidsofFedstrm $option6 $grafModofCabtm $option7 $outAliasforCabling $option8 $outhvofcab ";
						} 
						else if ($listopt == "execopt3" ) 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $option2 $fec $option3 $outinfofecs $option4 $outModofCab $option5 $outDetidsofFecstrm $option6 $grafModofCabtm $option7 $outAliasforCabling $option8 $outhvofcab ";
						} 
						else if ($listopt == "execopt4" ) 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $detid $option2 $outinfomodules $option3 $outInfoModuleHV $option4 $outAliasModules $option5 $outDetidsofDetIDtrm $option6 $grafModofdetidtm ";
						} 
						else if ($listopt == "execopt5" ) 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $power_string $option2 $outHvmodcom $option3 $outDetidstoHv $option4 $grafHvtkm $option5 $outAliastohv $option6 $outCabofhv ";
						}
						else if ($listopt == "execopt6") 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $outdetids $option2 $outModofCab $option3 $grafcabling $option4 $outAliasModules $option5 $outInfoModuleHV  ";
						} 
						else 
						{
							$command = "./cablingweb.sh --fu $userfile $option1 $feature_string $fedid $module_string $pairnum_string $fechan_string $alias_string $hv_string $option2 $subde_string $outfile";
						}
					}
					else 
					{
						if ($listopt == "execopt1" ) 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $aliass $option2 $outDetidsofalias $option3 $outCabmodalias $option4 $grafAliastkm $option5 $outCabofAlias $option6 $outHvofAlias ";
						}
						else if ($listopt == "execopt2" ) 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $option2 $fedid $option3 $outinfofeds $option4 $outModofCab $option5 $outDetidsofFedstrm $option6 $grafModofCabtm $option7 $outAliasforCabling $option8 $outhvofcab ";
						}
						else if ($listopt == "execopt3" ) 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $option2 $fec $option3 $outinfofecs $option4 $outModofCab $option5 $outDetidsofFecstrm $option6 $grafModofCabtm $option7 $outAliasforCabling $option8 $outhvofcab ";
						} 
						else if ($listopt == "execopt4" ) 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $detid $option2 $outinfomodules $option3 $outInfoModuleHV $option4 $outAliasModules $option5 $outDetidsofDetIDtrm $option6 $grafModofdetidtm  ";
						}
						else if ($listopt == "execopt5" ) 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $power_string $option2 $outHvmodcom $option3 $outDetidstoHv $option4 $grafHvtkm $option5 $outAliastohv $option6 $outCabofhv ";
						} 
						else if ($listopt == "execopt6") 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $outdetids $option2 $outModofCab $option3 $grafcabling $option4 $outAliasModules $option5 $outInfoModuleHV ";
						} 
						else 
						{
							$command = "./cablingweb.sh -f $userfile $option1 $feature_string $fedid $module_string $pairnum_string $fechan_string $alias_string $hv_string $option2 $subde_string $outfile";
						}
					}

					if (isset($_REQUEST['samecolors']))
					{
						$command = $command . " --a6 dc ";
// 						echo "dc";
					}
					else 
					{
						$command = $command . " --a6 cualquiercosa ";
// 						echo "cualquiercosa";
					}
					

//					echo $command . "<br>";
//					system($command);
					exec($command);

					exec ("rm -f temp/*");
// 					exec ("mkdir temp");
					exec ("mv DetIdCab.txt temp/");
					exec ("mv ModulestoFeds.txt $outinfomodules");
					exec ("mv Modulescommonhv.png $grafModulescommonhv");

					exec ("mv HvAliascom.txt $outHvAliascom");
					exec ("mv Modulescommonhv.png $grafModulescommonhv");
					exec ("mv HvAliasinfo.txt $outHvAliasinfo");

					exec ("mv file.txt temp/");
					exec ("mv $inpfile temp/");
					exec ("mv CablingInfo* temp/");
			
					echo "</a><br><br>";


					if ($listopt == "execopt1") {
// 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outDetidsofalias}'>Download PowerGroupName/Module </a><br><br>";						
 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outCabmodalias}'>Download PowerGroupName/Module </a><br><br>";
						echo "<a href='plot_cablingweb_from_tmp.php?file=${grafAliastkm}'><img src='plot_cablingweb_from_tmp.php?file=${grafAliastkm}' width=${plotwidth}></a><br><br>";
 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outCabofAlias}'>Download info modules </a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outHvofAlias}'>Download PSUname/module </a><br><br>";

					}
					else if ($listopt == "execopt2") {
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outinfofeds}'>Download FED/FEC/module Info </a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outModofCab}'>Download  modules </a><br><br>";

// 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outDetidsofFedstrm}'>Download DetidsofFedstrm.txt </a><br><br>";				   				   
						echo "<a href='plot_cablingweb_from_tmp.php?file=${grafModofCabtm}'><img src='plot_cablingweb_from_tmp.php?file=${grafModofCabtm}' width=${plotwidth}></a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outAliasforCabling}'>Download PowerGroupName/Module </a><br><br>";				   				   
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outhvofcab}'>Download PSUname/module </a><br><br>";				   				   
					}
					else if ($listopt == "execopt3") {
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outinfofecs}'>Download FECcrate/FECslot/module </a><br><br>";

 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outModofCab}'>Download  modules </a><br><br>";

// 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outDetidsofFecstrm}'>Download DetidsofFecstrm.txt </a><br><br>";				   				   				   
						echo "<a href='plot_cablingweb_from_tmp.php?file=${grafModofCabtm}'><img src='plot_cablingweb_from_tmp.php?file=${grafModofCabtm}' width=${plotwidth}></a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outAliasforCabling}'>Download PowerGroupName/Module </a><br><br>";				   				   
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outhvofcab}'>Download PSUname/module </a><br><br>";				   				   
					}					
					else if ($listopt == "execopt4") {
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outinfomodules}'>Download info modules </a><br><br>";						
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outInfoModuleHV}'>Download PSUname/module </a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outAliasModules}'>Download PowerGroupName/Module </a><br><br>";
// 						echo "<a href='txt_cablingweb_from_tmp.php?file=${outDetidsofDetIDtrm}'>Download outDetidsofDetIDtrm.txt </a><br><br>";
						echo "<a href='plot_cablingweb_from_tmp.php?file=${grafModofdetidtm}'><img src='plot_cablingweb_from_tmp.php?file=${grafModofdetidtm}' width=${plotwidth}></a><br><br>";

					}
					else if ($listopt == "execopt5") {
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outDetidstoHv}'>Download modules </a><br><br>";
						echo "<a href='plot_cablingweb_from_tmp.php?file=${grafHvtkm}'><img src='plot_cablingweb_from_tmp.php?file=${grafHvtkm}' width=${plotwidth}></a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outAliastohv}'>Download PowerGroupName/Module </a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outCabofhv}'>Download info modules </a><br><br>";

					}
					else if ($listopt == "execopt6") {
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outModofCab}'>Download Modules </a><br><br>";
						echo "<a href='plot_cablingweb_from_tmp.php?file=${grafcabling}'><img src='plot_cablingweb_from_tmp.php?file=${grafcabling}' width=${plotwidth}></a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outInfoModuleHV}'>Download PSUname/module </a><br><br>";
						echo "<a href='txt_cablingweb_from_tmp.php?file=${outAliasModules}'>Download PowerGroupName/Module </a><br><br>";
					}

					// write log
					$logFile = "cablingweb.log";
					$fh = fopen($logFile,'a');
					$date = date('d/m/Y H:i:s', time());
					$logstring = $date." ".$_SERVER["REMOTE_ADDR"]." ".$inpfile." ".$command."\n";
					fwrite($fh,$logstring);
					fclose($fh);
			}

//	echo "<a href='plot_cablingweb_from_tmp_cabling.php?file=temp/${outgrafic}'><img src='plot_cablingweb_from_tmp_cabling.php?file=temp/${outgrafic}' width=${plotwidth}></a>";
//				echo "<a href = 'plot_cablingweb_from_tmp_cabling.php?file = temp/${outgrafic}'><img src = 'plot_cablingweb_from_tmp_cabling.php?file = temp/${outgrafic}' width = ${plotwidth}></a><br><br>";
			}
		} else 
		{
			$fp = fopen("ayuda.txt", "r");
			$texto = fread($fp, filesize("ayuda.txt"));
			//Para mostrarlo
			$texto = nl2br($texto); 
			echo "<font face = 'monospace' $texto</font>";
			fclose ($fp);
		}
//echo "<a href = 'plot_cablingweb_from_tmp_cabling.php?file = ${outgrafic}'><img src = 'plot_cablingweb_from_tmp.php?file = ${outgrafic}' width = ${plotwidth}></a><br><br>";
	}
?>