<?php
	error_reporting(E_ERROR); //Turn off PHP error reporting
	$con = mysqli_connect("188.121.44.165","AssistedSpeak","a55!sT3D","AssistedSpeak"); //Connection string
	
	if(isset($_POST['LogOut'])) {
		setcookie("LoggedIn", "", time() - 3600);
		header("Location: ../Main/Default.php");
	}
	
	//if (!isset($_COOKIE["LoggedIn"])) {
	//	header("Location: ../Main/Login.php");
	//}
?>

<html><!-- manifest="../cache.manifest">-->
	<head>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="../Scripts/ResponsiveVoice.js"></script> <!-- Text to Speech JS-->
		<script src="../Scripts/AngularJS.js"></script> <!-- AngularJS-->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="../App_Themes/StyleSheet.css" rel="stylesheet" /> <!-- Custom Style Sheet-->
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<title>Assisted Speaking</title>
	
		<script>
			
	//--- Standard JS ---  	
			<?php
				$mainMenuArrayImage = array();
				$subMenuArrayImage = array();
				$subMenuWordImageTotal = array();
				$totalImageButtons = array();
				$mainMenuWordImageTotal = 0;
			?>
	//--- AngularJS ---
			//AngularJS module creation
			var app = angular.module("myApp", []);
			//Angular Controller
			app.controller('myCtrl', function ($scope) {	
		
	//--- Page Set Up ---
				//Bind talk settings to drop down
				$scope.speechSettings = [
					{display : "Push to Talk", setting : "pushTalk"},
					{display : "Select to Talk", setting : "selectTalk"},
					{display : "Push and Select to Talk", setting : "pushSelectTalk"}
				];
			
				// -- Clear speech bar ---
				$scope.deleteWords = function () {
						$scope.choice10 = "";
						$scope.choice10Data = "";
						$scope.choice9 = "";
						$scope.choice9Data = "";
						$scope.choice8 = "";
						$scope.choice8Data = "";
						$scope.choice7 = "";
						$scope.choice7Data = "";
						$scope.choice6 = "";
						$scope.choice6Data = "";
						$scope.choice5 = "";
						$scope.choice5Data = "";
						$scope.choice4 = "";
						$scope.choice4Data = "";
						$scope.choice3 = "";
						$scope.choice3Data = "";
						$scope.choice2 = "";
						$scope.choice2Data = "";
						$scope.choice1 = "";
						$scope.choice1Data = "";
				}   
			
				$scope.deleteWords();
			
	//--- Load words into AngularJS through PHP ---
				<?php 
			
						$buttonArray = array();
						//Variable to keep track of blank sub page
						$pageUse = 2;
					
						//Selects words that are to be displayed on the main page
						$selectMainWords="SELECT WordID, PhraseName, Phrase, Image FROM Words WHERE GroupID=0";
						$mainWordsResults = mysqli_query($con, $selectMainWords);
					
						//Loop variable for button use
						$i = 1;
						$k = 0;
						$m = 0;
						$buttonNum = 0;
						$buttonSubNum = 0;
					
						//Check for returned values
						if (mysqli_num_rows($mainWordsResults) > 0) 
						{
							//Loop through returned rows
							while($row = mysqli_fetch_assoc($mainWordsResults)) 
							{
								$k++;
								//Insert currently selected into variables
								$phraseName = $row["PhraseName"];
								$mainPhrase = $row["Phrase"];
								$phraseImage = $row["Image"];
							
								//Print select variables into AngularJS, based on button position $i
								print '$scope.page1'.$i.' = "'.$phraseName.'";';
								print '$scope.page1Data'.$i.' = "'.$mainPhrase.'";';
							
								print '$scope.page1Image'.$i.' = "'.$phraseImage.'";';
							
								$mainMenuArrayImage[$buttonNum] = "<div class='col-xs-1 text-center' id='cell".$k."' ng-click='loadWords(\$event)' value='{{page1".$i."}}' data='{{page1Data".$i."}}'> \n"
																. "<img class='img-responsive center-block' src='{{page1Image".$i."}}' alt='{{page1".$i."}}'/> \n" 
																. "<h4>{{page1".$i."}}</h4> \n"
																. "</div> \n";
							
								$totalImageButtons[$i] = $i;
								//Increment main page button used
								$i++;
							
								$buttonNum++;
							}	
							$phraseNo = $i;
						}
					
						//Select all word groups
						$selectGroups="SELECT GroupID, GroupName, Image FROM WordGroup";
						$groupResults = mysqli_query($con, $selectGroups);
					
						//Check for returned values
						if (mysqli_num_rows($groupResults) > 0) 
						{
							//Loop through returned rows
							while($row = mysqli_fetch_assoc($groupResults)) 
							{
								$k++;
								//Insert currently selected into variables
								$groupID = $row["GroupID"];
								$groupName = $row["GroupName"];
		
								$groupImage = $row["Image"];
		
								//Print select variables into AngularJS, based on button position $i
								print '$scope.page1'.$i.' = "'.$groupName.'";';
								print '$scope.page1Data'.$i.' = "NewPage '.$pageUse.'";';
							
								print '$scope.page1Image'.$i.' = "'.$groupImage.'";';
							
								$mainMenuArrayImage[$buttonNum] = "<div class='col-xs-1 text-center' id='cell".$k."' ng-click='loadWords(\$event)' value='{{page1".$i."}}' data='{{page1Data".$i."}}' style='border:2px solid black;'> \n"
															  	. "<img class='img-responsive center-block' src='{{page1Image".$i."}}' alt='{{page1".$i."}}'/> \n"
															  	. "<h4>{{page1".$i."}}</h4> \n"
															  	. "</div> \n";
							
								$totalImageButtons[$i] = $i;
								//
								//Select words associated with the currently selected group
								$selectWords="SELECT WordID, GroupID, PhraseName, Phrase, Image FROM Words WHERE GroupID=".$groupID;
								$wordResults = mysqli_query($con, $selectWords);
							
								//Check for returned values
								if (mysqli_num_rows($wordResults) > 0)
								{	
									//Loop variable for sub menu button use
									$j = 1;
			
									//Loop through returned rows
									while($row = mysqli_fetch_assoc($wordResults))
									{
										$k++;
										//Insert currently selected into variables
										$groupID = $row["GroupID"];
										$phraseName = $row["PhraseName"];
										$phrase = $row["Phrase"];
									
										$phraseImage = $row["Image"];
									
										//Print select variables into AngualarJS, based on sub menu button position $j
										print '$scope.page'.$pageUse.''.$j.' =  "'.$phraseName.'";';
										print '$scope.page'.$pageUse.'Data'.$j.'= "'.$phrase.'";';
									
										print '$scope.page'.$pageUse.'Image'.$j.' = "'.$phraseImage.'";';
										
										$subMenuArrayImage[$buttonSubNum] = "<div class='col-xs-1 text-center' id='cell".$k."' ng-click='loadWords(\$event)' value='{{page".$pageUse."".$j."}}' data='{{page".$pageUse."Data".$j."}}'> \n" 
																		  . "<img class='img-responsive center-block' src='{{page".$pageUse."Image".$j."}}' alt='{{page".$pageUse."".$j."}}'/> \n" 
																		  . "<h4>{{page".$pageUse."".$j."}}</h4> \n"
																		  . "</div> \n";	
										//Increment button used
										$j++;
										$buttonSubNum++;
									}
									
									$subMenuArrayImage[($buttonSubNum)] = "<div class='col-xs-1 text-center' id='cell".($k+1)."' onclick='pageHide(".($m+2).")'> \n"
																		. "<img class='img-responsive center-block' src='../Images/backButton.png' alt='Back Button'/> \n"
																		. "<h4>Back</h4> \n"
																		. "</div> \n";
									$j++;
									$buttonSubNum++;
									$k++;
									//Increment page used
									$subMenuWordImageTotal[$m] = $j;
									$totalImageButtons[$i] = $totalImageButtons[($i-1)] + $j;
									$m++;
									$pageUse++;
								}
								//Increment main page button postion
								$i++;
								$buttonNum++;
							
							}			
						}
					
						$mainMenuWordImageTotal = $i;
					
						//Close SQL connection once words are loaded
						mysqli_close($con);
				?>
				//Hide loading screen
			
				
	//--- App buttons on click ---
				$scope.loadWords = function (value) {
					// Gather value of selected button
					var selectedValue = value.target.attributes.value.value;
					var selectedData = value.target.attributes.data.value;
					var selectedId = value.target.attributes.data.value
				
					//String will be split into an array, only applicable for group linked buttons
					var selectedDataArray = selectedData.split(" ");
				
					//Check to see if the button is linked to a new page
					if (selectedDataArray[0] != "NewPage")
					{
						//Check the speech settings is select to talk
						if ($scope.speechSetting.setting == "selectTalk")
						{
							//Load the selected word into the speech bar
							$scope.choice1 = selectedValue;
							$scope.choice1Data = selectedData;
						
							//Call function to read the speech bar
							$scope.DataWords();
						}
						//Check the speech settings are push to talk or push to talk and select to talk
						else if ($scope.speechSetting.setting == "pushTalk" || $scope.speechSetting.setting == "pushSelectTalk")
						{     	
							//Check the speech settings are push to talk and select to talk
							if ($scope.speechSetting.setting == "pushSelectTalk")
							{
								//Read the currently selected word
								responsiveVoice.speak(selectedData);
							}
					
							//Check if there isnt a value in speech bar section one
							if (!$scope.choice1)
							{
								//Load the selected value into the speech bar section one
								$scope.choice1 = selectedValue;
								$scope.choice1Data = selectedData;
							} 
							//Check if there isnt a value in speech bar section two
							else if (!$scope.choice2)
							{
								//Load the selected value into the speech bar section two
								$scope.choice2 = selectedValue;
								$scope.choice2Data = selectedData;
							} 
							//Check if there isnt a value in speech bar section three
							else if (!$scope.choice3)
							{
								//Load the selected value into the speech bar section three
								$scope.choice3 = selectedValue;
								$scope.choice3Data = selectedData;
							}
							else if (!$scope.choice4)
							{
								//Load the selected value into the speech bar section three
								$scope.choice4 = selectedValue;
								$scope.choice4Data = selectedData;
							}
							//Check if there isnt a value in speech bar section four
							else if (!$scope.choice5)
							{
								//Load the selected value into the speech bar section four
								$scope.choice5 = selectedValue;
								$scope.choice5Data = selectedData;
							}
							else if (!$scope.choice6)
							{
								//Load the selected value into the speech bar section four
								$scope.choice6 = selectedValue;
								$scope.choice6Data = selectedData;
							}
							else if (!$scope.choice7)
							{
								//Load the selected value into the speech bar section four
								$scope.choice7 = selectedValue;
								$scope.choice7Data = selectedData;
							}
							else if (!$scope.choice8)
							{
								//Load the selected value into the speech bar section four
								$scope.choice8 = selectedValue;
								$scope.choice8Data = selectedData;
							}
							else if (!$scope.choice9)
							{
								//Load the selected value into the speech bar section four
								$scope.choice9 = selectedValue;
								$scope.choice9Data = selectedData;
							}
							else if (!$scope.choice10)
							{
								//Load the selected value into the speech bar section four
								$scope.choice10 = selectedValue;
								$scope.choice10Data = selectedData;
							}
						}
					}
					else
					{
						//Get the page number of the selected button
						var $pageUse = parseInt(selectedDataArray[1]);
					
						//Merge the number with the ID of the sub menu
						var $display = "wordArea" + $pageUse;
					
						//Hide the main word area
						document.getElementById("wordArea1").style.display = "none";
					
						//Display the selected word area
						document.getElementById($display).style.display = "block";
					}  
				}
	// --- Read speech bar ---
				$scope.DataWords = function () {
					//Read all the values in the speech bar
					word1 = $scope.choice1Data;
					word2 = $scope.choice2Data;
					word3 = $scope.choice3Data;
					word4 = $scope.choice4Data;
					word5 = $scope.choice5Data;
					word6 = $scope.choice6Data;
					word7 = $scope.choice7Data;
					word8 = $scope.choice8Data;
					word9 = $scope.choice9Data;
					word10 = $scope.choice10Data;
					
					if (word1 == null) {
						word1 = " ";
					}
				
					if (word2 == null) {
						word2 = " ";
					}
				
					if (word3 == null) {
						word3 = " ";
					}
				
					if (word4 == null) {
						word4 = " ";
					}
					
					if (word5 == null) {
						word5 = " ";
					}
					if (word6 == null) {
						word6 = " ";
					}
					if (word7 == null) {
						word7 = " ";
					}
					
					if (word8 == null) {
						word8 = " ";
					}
					
					if (word9 == null) {
						word9 = " ";
					}
					
					if (word10 == null) {
						word10 = " ";
					}
					responsiveVoice.speak((word1 + " " + word2 + " " + word3 + " " + word4 + " " + word5 + " " + word6 + " " + word7 + " " + word8 + " " + word9 + " " + word10), applicationSettings.speechType, {volume: applicationSettings.applicationVolume});
					
					$scope.deleteWords();
				}        
			});
		</script>
		
	</head>
	<body ng-app="myApp" ng-controller="myCtrl">
		<div id="overLay1">
			<image type="image"  src="../Images/loading.gif"/>
			<h1 style="color: gray;"> Please wait as we load things up. </h1>
			<?php
			if (mysqli_connect_errno())
			{
			?>
				<h3>We are having trouble connecting to our database, please find an internet connection.</h3>
			<?php
			}
			?>
		</div>
		<div id="overLay2">
			<div class="container-fluid">
				<div class="row headerPadding">
					<div class="col-xs-1">
						<input class="btn btn-default" type="button" onclick="refreshPage()" value="Refresh" />
					</div>
					<div class="col-xs-1">
						<form action="../Main/Default.php" method="post">
							<input class="btn btn-default" type="submit" name="LogOut" ID="LogOut" value="Log Out" />
						</form>
					</div>
					<div class="col-xs-offset-3 col-xs-2">
						<h1>Settings</h1>
					</div>
					<a onclick="closeSettings()">
						<div class="col-xs-offset-4 col-xs-1">
							<image class="img-responsive" type="image" src="../Images/close.png"/>
						</div>
					</a>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-xs-3">
						<h3>Look and Feel</h3>
					</div>
					<div class="col-xs-offset-3 col-xs-4">
						<h3>Speech and Interaction</h3>
					</div>
				</div>
				<div class="settingsSplit">
					<div class="leftSplit">
						<h5>
							Colour Theme
						</h5>
						<p>
							Changes your applications top header colour.
						</p>
					</div>
					<div class="rightSplit">
						<select id="colourTheme">
							<option value="Standard">Standard</option>
							<option value="Dark">Dark</option>
							<option value="Light">Light</option>
						</select>
					</div>
					<div class="leftSplit">
						<h5>
							Background Colour
						</h5>
						<p>
							Changes your applications background colour.
						</p>
					</div>
					<div class="rightSplit">
						<select id="backgroundColour">
							<option value="Standard" >Standard</option>
							<option value="Red">Red</option>
							<option value="Blue">Blue</option>
							<option value="Green">Green</option>
						</select>
					</div>
					<div class="leftSplit">
						<h5>
							Scanning Colour
						</h5>
						<p>
							Changes the colour of your scanning box
						</p>
					</div>
					<div class="rightSplit">
						<select id="scanningColour">
							<option value="Blue">Blue</option>
							<option value="Red">Red</option>
							<option value="Green">Green</option>
						</select>
					</div>
				</div>
				<div class="settingsSplit">
					<div class="leftSplit">
						<h5>
							Speech Settings
						</h5>
						<p>
							Alters the way the words are spoken.
						</p>
					</div>
					<div class="rightSplit">
						<select ng-model="speechSetting" ng-options="x.display for x in speechSettings" ng-init="speechSetting = speechSettings[0]" ng-change="deleteWords()" ></select>
					</div>
					<div class="leftSplit">
						<h5>
							Interaction Method
						</h5>
						<p>
							Changes the way you interact with the app.
						</p>
					</div>
					<div class="rightSplit">
						<select id="interactionMethod">
							<option value="Touch">Touch</option>
							<option value="Scanning">Scanning</option>
						</select>
					</div>
					<div class="leftSplit">
						<h5>
							Scanning Speed
						</h5>
						<p>
							Change the speed in which the system scans.
						</p>
					</div>
					<div class="rightSplit">
						<select id="scanningSpeed">
							<option value="Standard">Standard</option>
							<option value="Slow">Slow</option>
							<option value="Fast">Fast</option>
							<option value="VeryFast">Very Fast</option>
						</select>
					</div>
					<div class="leftSplit">
						<h5>
							Voice Type
						</h5>
						<p>
							Select male or female and speakers accent.
						</p>
					</div>
					<div class="rightSplit">
						<select id="voiceType" onchange="selectedVoiceType()">
							<option value="UK English Female">UK English Female</option>
							<option value="UK English Male">UK English Male</option>
							<option value="US English Female">US English Female</option>
							<option value="US English Male">US English Male</option>
							<option value="French Female">French Female</option>
							<option value="French Male">French Male</option>
						</select>
					</div>
					<div class="leftSplit">
						<h5>
							Volume
						</h5>
						<p>
							Change the volume level of the speech.
						</p>
					</div>
					<div class="rightSplit">
						<select id="voiceVolume">
							<option value="Standard">Standard</option>	
							<option value="Quite">Quite</option>
							<option value="Loud">Loud</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar navbar-default header-padding" id="header">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#"><img class="img-responsive" src="../Images/YouSpeakTxtLarge.png" alt="YouSpeak Large" width="140"/></a>						
				</div>
				<ul class="nav navbar-nav">
					<li><a href="../main/UpdateWordBank.php">New Words</a></li>
					
				</ul>
				<div id="navbar" class="nav navbar-nav navbar-right">
					<a onclick="openSettings()">
						<img class="img-responsive" src="../Images/Settings.png" alt="Settings" width="50"/>
					</a>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div id="speechBar" class="row headerPadding">
				<div class="col-xs-1">
					<h3 id="choice1">
						{{choice1}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice2">
						{{choice2}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice3">
						{{choice3}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice4">
						{{choice4}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice5">
						{{choice5}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice6">
						{{choice6}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice7">
						{{choice7}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice8">
						{{choice8}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice9">
						{{choice9}}
					</h3>
				</div>
				<div class="col-xs-1">
					<h3 id="choice10">
						{{choice10}}
					</h3>
				</div>
					<div id="speechButton" class="col-xs-1" ng-click="DataWords()">
						<input class="img-responsive" type="image" src="../Images/speak.png"  />
					</div>
					<div class="col-xs-1" ng-click="deleteWords()" >
						<input class="img-responsive" type="image" src="../Images/back.png" />
					</div>
			</div>
		</div>
		<div ID="wordAreaContainer" class="container-fluid">
				<?php
					//$cellNo = count($buttonArray);
					$cellNo = count($mainMenuArrayImage);
					$i = 0;
				
					print "\n <div ID='wordArea1'> \n";
					print 	"<div class='row'> \n";
						while ($i < $cellNo) {
							print $mainMenuArrayImage[$i];
				
							if (($i != 0) && ($i % 11 == 0)) {
								print "</div> \n";
								print "<div class='row'> \n";
							}
					
							$i++;
						}
					print	"</div> \n";
					print 	"</div> \n";
					print 	"</div> \n";
			
					$tableNo = count($subMenuWordImageTotal);
					$subCellNo = count($subMenuArrayImage);
					$table = 2;
					$rows = 1;
					$j = 0;
					$l = 0;
				
						while ($j < $tableNo) {
							print "\n <div ID='wordArea".($j+2)."' style='display:none'> \n";
							print 		"<div class='row'> \n";
					
							$k = 1;
							while ($k < $subMenuWordImageTotal[$j]) {
								print 	$subMenuArrayImage[$l];
						
								if ($k % 11 == 0) {
									print "</div> \n";
									print "<div class='row'> \n";
									$rows++;
								}
						
								$k++;
								$l++;
							}
							print	  		"</div> \n";
							print 	"	</div> \n";
							$j++;
						}
				?>
				
		</div>
		<script>
			//--- Table 1 Point Scanning ---
			var keyPressed = false;
			var cellCount = <?php print (array_sum($subMenuWordImageTotal) + $phraseNo); ?>;
			var mainButtons = <?php print count($mainMenuArrayImage);?>;
			var bottomOfMenu = 0;
			var topOfMenu = 0;
			var mainMenuIDs = [];
			var phraseNo = <?php print $phraseNo; ?>;
	
			function selectedSubMenu(mainSelectedSubMenu){
			<?php 
				$i = 1;
				$j = 0;
				$runningTotal = 0;
				$runningBottom = 0;
				$mainButtons = $phraseNo;
				$mainMenuID = "";
		
				print "switch(mainSelectedSubMenu) { ";
				while ($i <= count($mainMenuArrayImage) + 1) {
					if ($mainButtons == 0) {
						$runningTopTotal = $runningTopTotal + $subMenuWordImageTotal[$j];
						$runningBottomTotal = $runningBottomTotal + $subMenuWordImageTotal[$j - 1];
				
				
						print "case ".$i.": ";
						print "bottomOfMenu = ".$runningBottomTotal.";";
						print "topOfMenu = ".$runningTopTotal."; ";
						print "break; ";
						$j++;
					}
					else {
						$runningTopTotal++;
						$runningBottomTotal++;
				
						print "case ".$i.": "; 
						print "bottomOfMenu = ".$runningBottomTotal.";";
						print "topOfMenu = ".$runningTopTotal."; ";
						print "break; ";
				
						$mainButtons--;
					}
			
					$mainMenuID[$i] = $runningTopTotal;
					$i++;
			
			
				}
				print "} ";
			?>
			}
	
			<?php	
				$k = 1;
		
				while($k <= count($mainMenuID)) {
					print "mainMenuIDs[".$k."] = ".$mainMenuID[$k]."; ";
					$k++;
				}
			?>	
			
		</script>
		<script src="../Scripts/Custom Scripts/Settings.js"> </script>
	</body>
</html>