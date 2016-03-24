<?php
	error_reporting(E_ERROR); //Turn off PHP error reporting
	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="../App_Themes/StyleSheet.css" rel="stylesheet" /> <!-- Custom Style Sheet-->
    <script src="../Scripts/ResponsiveVoice.js"></script> <!-- Text to Speech JS-->
    <script src="../Scripts/AngularJS.js"></script> <!-- AngularJS-->
    <title>Assisted Speaking</title>
    
    <script>
//--- Standard JS ---  	
		<?php
			$buttonArray = array();
			$subMenuArray = array();
			$subMenuWordTotal = array();
		?>

    	//Displays sub menus of words
    	function pageHide($pageNumber) {
    		document.getElementById("wordArea" + $pageNumber).style.display = "none";
    		document.getElementById("wordArea1").style.display = "block";
    	}
    	
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
					$selectMainWords="SELECT WordID, PhraseName, Phrase FROM Words WHERE GroupID=0";
					$mainWordsResults = mysqli_query($con, $selectMainWords);
					
					//Loop variable for button use
					$i = 1;
					$m = 0;
					$buttonNum = 0;
					$buttonSubNum = 0;
					
					//Check for returned values
					if (mysqli_num_rows($mainWordsResults) > 0) 
					{
						//Loop through returned rows
						while($row = mysqli_fetch_assoc($mainWordsResults)) 
						{
							//Insert currently selected into variables
							$phraseName = $row["PhraseName"];
							$mainPhrase = $row["Phrase"];
							
							//Print select variables into AngularJS, based on button position $i
							print '$scope.page1'.$i.' = "'.$phraseName.'";';
	 						print '$scope.page1Data'.$i.' = "'.$mainPhrase.'";';
	 						
	 						$buttonArray[$buttonNum] = "<input type='button' class='wordButton' ng-click='loadWords(\$event)' value='{{page1".$i."}}' data='{{page1Data".$i."}}' />";
	 						
	 						//Increment main page button used
	 						$i++;
	 						$buttonNum++;
						}	
						$phraseNo = $i;
					}
					
					//Select all word groups
					$selectGroups="SELECT GroupID, GroupName FROM WordGroup";
					$groupResults = mysqli_query($con, $selectGroups);
					
					//Check for returned values
					if (mysqli_num_rows($groupResults) > 0) 
					{
						//Loop through returned rows
						while($row = mysqli_fetch_assoc($groupResults)) 
						{
							//Insert currently selected into variables
							$groupID = $row["GroupID"];
							$groupName = $row["GroupName"];
		
							//Print select variables into AngularJS, based on button position $i
	 						print '$scope.page1'.$i.' = "'.$groupName.'";';
	 						print '$scope.page1Data'.$i.' = "NewPage '.$pageUse.'";';
	 						
	 						$buttonArray[$buttonNum] = "<input type='button' class='wordButton' ng-click='loadWords(\$event)' value='{{page1".$i."}}' data='{{page1Data".$i."}}' />";
	 						
	 						//Select words associated with the currently selected group
	 						$selectWords="SELECT WordID, GroupID, PhraseName, Phrase FROM Words WHERE GroupID=".$groupID;
	 						$wordResults = mysqli_query($con, $selectWords);
	 						
	 						//Check for returned values
	 						if (mysqli_num_rows($wordResults) > 0)
	 						{	
	 							//Loop variable for sub menu button use
	 							$j = 1;
	 		
	 							//Loop through returned rows
	 							while($row = mysqli_fetch_assoc($wordResults))
	 							{
	 								//Insert currently selected into variables
	 								$groupID = $row["GroupID"];
	 								$phraseName = $row["PhraseName"];
									$phrase = $row["Phrase"];
									
									//Print select variables into AngualarJS, based on sub menu button position $j
									print '$scope.page'.$pageUse.''.$j.' =  "'.$phraseName.'";';
									print '$scope.page'.$pageUse.'Data'.$j.'= "'.$phrase.'";';
									
									$subMenuArray[$buttonSubNum] = "<input type='button' class='wordButton' ng-click='loadWords(\$event)' value='{{page".$pageUse."".$j."}}' data='{{page".$pageUse."Data".$j."}}' />";
											
									//Increment button used
									$j++;
									$buttonSubNum++;
	 							}
	 							//Increment page used
	 							$subMenuWordTotal[$m] = $j;
	 							$m++;
	 							$pageUse++;
	 						}
	 						//Increment main page button postion
	 						$i++;
	 						$buttonNum++;
 						}			
					}
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
                responsiveVoice.speak($scope.choice1Data + " " + $scope.choice2Data + " " + $scope.choice3Data + " " + $scope.choice4Data);
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
						$cellNo = count($buttonArray);
						$i = 0;

						print '<table class="wordAreaTable">';
						print 	'<tr>';
							while ($i < $cellNo) {
								print '<td>';
								print 	$buttonArray[$i];
								print '</td>';
								
								if (($i != 0) && ($i % 5 == 0)) {
									print '</tr>';
									print '<tr>';
								}
								
								$i++;
							}
						print		'</tr>';
						print 	'</table>';
						print '</div>';
						
						$tableNo = count($subMenuWordTotal);
						$subCellNo = count($subMenuArray);
						$table = 2;
						$rows = 1;
						$j = 0;
						$l = 0;
						
							while ($j < $tableNo) {
								print '<div ID="wordArea'.($j+2).'" style="display:none">';
								print 	'<table class="wordAreaTable">';
								print 		'<tr>';
								
								$k = 1;
								while ($k < $subMenuWordTotal[$j]) {
									print '<td>';
									print 	$subMenuArray[$l];
									print '</td>';
									
									if ($k % 6 == 0) {
										print '</tr>';
										print '<tr>';
										$rows++;
									}
									
									$k++;
									$l++;
								}
								
								print 			'<td>';
								print				'<input type="button" class="wordButton" value="Back" onclick="pageHide('.($j+2).')" />';
								print			'</td>';
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
</body>
</html>