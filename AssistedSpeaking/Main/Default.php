<?php
	error_reporting(E_ERROR); //Turn off PHP error reporting
	$con = mysqli_connect("188.121.44.165","AssistedSpeak","a55!sT3D","AssistedSpeak"); //Connection string
?>

<html manifest="../cache.manifest">
<head>
    <link href="../App_Themes/StyleSheet.css" rel="stylesheet" /> <!-- Custom Style Sheet-->
    <script src="../Scripts/ResponsiveVoice.js"></script> <!-- Text to Speech JS-->
    <script src="../Scripts/AngularJS.js"></script> <!-- AngularJS-->
    <script src="../Scripts/jquery-2.2.2.js"></script> <!-- JQuery-->
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
    	
    	//Refresh the page reloading the words
    	function refreshPage() {
    		location.reload();
		}
		

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
                    $scope.choice4 = "";
                    $scope.choice4Data = "";
                    $scope.choice3 = "";
                    $scope.choice3Data = "";
                    $scope.choice2 = "";
                    $scope.choice2Data = "";
                    $scope.choice1 = "";
                    $scope.choice1Data = "";
            }   
            
            $scope.deleteWords
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
	 						
	 						$mainMenuArrayImage[$buttonNum] = "<td><div id='cell".$k."' class='wordImageButton' ng-click='loadWords(\$event)' value='{{page1".$i."}}' data='{{page1Data".$i."}}'> <img src='{{page1Image".$i."}}' alt='{{page1".$i."}}'/> <h3>{{page1".$i."}}</h3> </div></td>";
	 						
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
	 						
	 						$mainMenuArrayImage[$buttonNum] = "<td><div id='cell".$k."' class='wordImageButton' ng-click='loadWords(\$event)' value='{{page1".$i."}}' data='{{page1Data".$i."}}' style='border:2px solid black;'><img src='{{page1Image".$i."}}' alt='{{page1".$i."}}'/> <h3>{{page1".$i."}}</h3></div></td>";
	 						
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
									
									//$subMenuArray[$buttonSubNum] = "<input type='button' class='wordButton' ng-click='loadWords(\$event)' value='{{page".$pageUse."".$j."}}' data='{{page".$pageUse."Data".$j."}}' />";
										
									$subMenuArrayImage[$buttonSubNum] = "<td><div id='cell".$k."' class='wordImageButton' ng-click='loadWords(\$event)' value='{{page".$pageUse."".$j."}}' data='{{page".$pageUse."Data".$j."}}'> <img src='{{page".$pageUse."Image".$j."}}' alt='{{page".$pageUse."".$j."}}'/> <h3>{{page".$pageUse."".$j."}}</h3> </div></td>";	
									
									
	 								
									//Increment button used
									$j++;
									$buttonSubNum++;
	 							}
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
			
			document.getElementById("loading").style.display = "none";

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
                		//Check if there isnt a value in speech bar section four
                		else if (!$scope.choiceFour)
                		{
                			//Load the selected value into the speech bar section four
                  		 	$scope.choice4 = selectedValue;
                  		 	$scope.choice4Data = selectedData;
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
            	
                responsiveVoice.speak(word1 + " " + word2 + " " + word3 + " " + word4);
            }        
        });
        
	</script>
</head>
<body ng-app="myApp" ng-controller="myCtrl">
	<div id="loading">
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
	<div class="mainContainer">
    	<div class="header">
            <h1>AssistedSpeaking v0.1</h1>
            <select ng-model="speechSetting" ng-options="x.display for x in speechSettings" ng-init="speechSetting = speechSettings[0]" ng-change="deleteWords()" ></select>
            <button onclick="refreshPage()">
            	Refresh Words
            </button>
        </div>
        <form id="mainSpeechForm">
            <table class="speechBar">
                <tr>
                    <td>
                        <h2 id="choice1" data-="{{choice1Data}}" >
                            {{choice1}}
                        </h2>                        
                    </td>
                    <td>
                        <h2 id="choice2">
                            {{choice2}}
                        </h2>
                    </td>
					<td>
                  		<h2 id="choice3" >
                            {{choice3}}
                        </h2>
                    </td>
                    <td>
                        <h2 id="choiceFour" >
                            {{choice4}}
                       	</h2>
                    </td>
                    <td class="speechButton" ng-click="DataWords()">
                		<input type="image" src="../Images/speak.png"  />
                    </td>
                    <td class="speechButton" ng-click="deleteWords()" >
                        <input type="image" src="../Images/back.png" />
                    </td>
                </tr>
            </table>
            <div class="wordAreaContainer">
            	<div ID="wordArea1" style="display:block">
            		<?php
						//$cellNo = count($buttonArray);
						$cellNo = count($mainMenuArrayImage);
						$i = 0;

						//print_r(array_values($subMenuWordImageTotal));

						print '<table class="wordAreaTable">';
						print 	'<tr>';
							while ($i < $cellNo) {
								print $mainMenuArrayImage[$i];
							
								if (($i != 0) && ($i % 5 == 0)) {
									print '</tr>';
									print '<tr>';
								}
								
								$i++;
							}
						print		'</tr>';
						print 	'</table>';
						print '</div>';
						
						$tableNo = count($subMenuWordImageTotal);
						$subCellNo = count($subMenuArrayImage);
						$table = 2;
						$rows = 1;
						$j = 0;
						$l = 0;
						
							while ($j < $tableNo) {
								print '<div ID="wordArea'.($j+2).'" style="display:none">';
								print 	'<table class="wordAreaTable">';
								print 		'<tr>';
								
								$k = 1;
								while ($k < $subMenuWordImageTotal[$j]) {
									print 	$subMenuArrayImage[$l];
									
									if ($k % 6 == 0) {
										print '</tr>';
										print '<tr>';
										$rows++;
									}
									
									$k++;
									$l++;
								}
								
								//print 			'<td>';
								//print				'<input type="button" class="wordButton" value="Back" onclick="pageHide('.($j+2).')" />';
								//print			'</td>';
								print		'</tr>';
								print 	'</table>';
								print '</div>';
								$j++;
							}
					?>
				</div>
            </div>
        </form>
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
	
	document.body.onkeyup = function(e){
    	if(e.keyCode == 32) {
    		keyPressed = true;
		}
    	else {
      		keyPressed = false;
      	}   
    }
     
    var k = 1;
	var l = 0;  
	var cell = "";
	var previousCell = "";
    var subCell = "";
    var subCellPreviouse ="";
    var mainMenuLength = mainMenuIDs.length;
    
	function mainLoop () {           
   		setTimeout(function () {
   			cell = "cell" + mainMenuIDs[k];	
      		previousCell = "cell" + mainMenuIDs[l];
      		
   			if (keyPressed == false) {		
   				document.getElementById(cell).style.backgroundColor = "blue";
   			
   				
   			
   				if (l == mainMenuLength - 2) {
      				l = 0;
      			}
				
				if (l != 0) { 
		 			document.getElementById(previousCell).style.backgroundColor = "white"; 
				} 			
  				
  				k++;    
      			l++; 
      			           
      		    if (k == mainMenuLength - 1) {
      				setTimeout(function () {   
						document.getElementById(cell).style.backgroundColor = "white";
					}, 1000)	
      				k = 1;
      				l = mainMenuLength - 2;
      			}
      			
     			mainLoop();            
			}
			else {
    			document.getElementById(previousCell).style.backgroundColor = "white";
    			
     			document.getElementById(previousCell).click();
     			
     			keyPressed = false;
      				
      			if (previousCell == "cell" + mainMenuIDs[mainMenuLength - 2]) {
      				k = mainMenuLength - 1;
      			}	
      			
     			if (k <= phraseNo) {
     				k = 1;
      				l = 0; 
      				
     				mainLoop();
     			}
     			else {
     				
     				selectedSubMenu(k);
     				pageNo = k;
     			
     				i = bottomOfMenu + 1;
					j = bottomOfMenu + 0; 
					
					subLoop();
					mainLoop();
					
					function subLoop () { 
      					setTimeout(function () {
   							subCell = "cell" + i;     
      						subPreviousCell = "cell" + j;
      						k = 1;
      						l = 0; 
      						
   							if (keyPressed == false) {				
								document.getElementById(subCell).style.backgroundColor = "blue";  
					
								if (j != 0) { 
		 							document.getElementById(subPreviousCell).style.backgroundColor = "white"; 
								} 			
  				
  								i++;    
      							j++;            
      		     	   
      							if (i == (topOfMenu + 1)) {
      								setTimeout(function () {  
											document.getElementById(subCell).style.backgroundColor = "white"; 
      								}, 1000)
      								i = bottomOfMenu + 1;
      								j = bottomOfMenu + 0; 
      							}
      			
     							subLoop();            
							}
							else {
    							document.getElementById(subPreviousCell).style.backgroundColor = "white"; 
     							document.getElementById(subPreviousCell).click();
      				
     							keyPressed = false;
     							
     							var page = pageNo - phraseNo;
     							page = page + 1;
     							
     							document.getElementById("wordArea" + page).style.display = "none";
    							document.getElementById("wordArea1").style.display = "block";
     							
      							i = bottomOfMenu + 1;
								j = bottomOfMenu + 0;
     			
      							return; 
							}
   						}, 1000) 
   					} 
   				}
			}
   		}, 1000)
	}
    
	selectedSubMenu(1);
	
	mainLoop();
	
</script>
</body>
</html>