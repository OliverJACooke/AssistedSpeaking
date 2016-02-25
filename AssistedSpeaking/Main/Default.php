<?php
	error_reporting(E_ERROR); //Turn off PHP error reporting
	
	
	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="../App_Themes/StyleSheet.css" rel="stylesheet" />
    <script src="../Scripts/ResponsiveVoice.js"></script>
    <script src="../Scripts/AngularJS.js"></script>
    <title>Assisted Speaking</title>
    
    <script>
    //Config Variables
    	
    	function pageHide($pageNumber) {
    		document.getElementById("wordArea" + $pageNumber).style.display = "none";
    		document.getElementById("wordArea1").style.display = "block";
    	}
    	
    	function refreshPage() {
    		location.reload();
		}

		var app = angular.module("myApp", []);

		app.controller('myCtrl', function ($scope) {
		//PAGE LOAD
		//---------
			//Config Variables - AngualrJS
			$scope.speechSettings = [
				{display : "Push to Talk", setting : "pushTalk"},
				{display : "Select to Talk", setting : "selectTalk"},
				{display : "Push and Select to Talk", setting : "pushSelectTalk"}
			];
			
			//Clear the speech bar
			$scope.choice4 = "";
			$scope.choice4Data = "";
			$scope.choice3 = "";
			$scope.choice3Data = "";
			$scope.choice2 = "";
			$scope.choice2Data = "";
			$scope.choice1 = "";
			$scope.choice1Data = "";

			//Load the app functions
			
			<?php 
					$selectMainWords="SELECT WordID, PhraseName, Phrase FROM Words WHERE GroupID=0";
					$mainWordsResults = mysqli_query($con, $selectMainWords);
					
					$pageUse = 2;
					$i = 1;
					if (mysqli_num_rows($mainWordsResults) > 0) 
					{
						while($row = mysqli_fetch_assoc($mainWordsResults)) 
						{
							$phraseName = $row["PhraseName"];
							$mainPhrase = $row["Phrase"];
							
							print '$scope.page1'.$i.' = "'.$phraseName.'";';
	 						print '$scope.page1Data'.$i.' = "'.$mainPhrase.'";';
	 						$i++;
						}	
					}
					
					$selectGroups="SELECT GroupID, GroupName FROM WordGroup";
					$groupResults = mysqli_query($con, $selectGroups);
					
					if (mysqli_num_rows($groupResults) > 0) 
					{
						while($row = mysqli_fetch_assoc($groupResults)) 
						{
							$groupID = $row["GroupID"];
							$groupName = $row["GroupName"];
		
	 						print '$scope.page1'.$i.' = "'.$groupName.'";';
	 						print '$scope.page1Data'.$i.' = "NewPage '.$pageUse.'";';
	 						
	 						$selectWords="SELECT WordID, GroupID, PhraseName, Phrase FROM Words WHERE GroupID=".$groupID;
	 						$wordResults = mysqli_query($con, $selectWords);
	 						
	 						if (mysqli_num_rows($wordResults) > 0)
	 						{	
	 							$j = 1;
	 							while($row = mysqli_fetch_assoc($wordResults))
	 							{
	 								$groupID = $row["GroupID"];
	 								$phraseName = $row["PhraseName"];
									$phrase = $row["Phrase"];
									
									print '$scope.page'.($pageUse).''.$j.' =  "'.$phraseName.'";';
									print '$scope.page'.($pageUse).'Data'.$j.'= "'.$phrase.'";';
									
									$j++;
	 							}
	 							$pageUse++;
	 						}
	 						$i++;
 						}			
					}
					mysqli_close($con);
			?>
			
			document.getElementById("loading").style.display = "none";
		//-------------
		//PAGE LOAD END
			
            //LOAD SPEECH BAR Function
            //------------------------
			$scope.loadWords = function (value) {
                var selectedValue = value.target.attributes.value.value;
                var selectedData = value.target.attributes.data.value;
                var selectedDataArray = selectedData.split(" ");
                
                if (selectedDataArray[0] != "NewPage")
                {
                	if ($scope.speechSetting.setting == "selectTalk")
                	{
                		$scope.choice1 = selectedValue;
                 	  	$scope.choice1Data = selectedData;
                   	
                 	  	$scope.DataWords();
              		 }
               	
               		if ($scope.speechSetting.setting == "pushTalk" || $scope.speechSetting.setting == "pushSelectTalk")
                	{     	
                		if ($scope.speechSetting.setting == "pushSelectTalk")
                		{
                			responsiveVoice.speak(selectedData);
                		}
                	
                		if (!$scope.choice1)
                		{
                   			$scope.choice1 = selectedValue;
                   			$scope.choice1Data = selectedData;
                		} 
                		else if (!$scope.choice2)
                		{
                    		$scope.choice2 = selectedValue;
                    		$scope.choice2Data = selectedData;
                		} 
                		else if (!$scope.choice3)
               	 		{
               	    	 	$scope.choice3 = selectedValue;
                		    $scope.choice3Data = selectedData;
                		}
                		else if (!$scope.choiceFour)
                		{
                  		  $scope.choice4 = selectedValue;
                  		  $scope.choice4Data = selectedData;
                		}
                	}
                }
                else
                {
                	var $int = parseInt(selectedDataArray[1]);
                	var $display = "wordArea" + $int;
                	document.getElementById("wordArea1").style.display = "none";
                	document.getElementById($display).style.display = "block";
                }
            }

			//SPEAK Function
			//--------------
            $scope.DataWords = function () {
                responsiveVoice.speak($scope.choice1Data + " " + $scope.choice2Data + " " + $scope.choice3Data + " " + $scope.choice4Data);
            }
			
			//CLEAR SPEACH BAR Function
			//-------------------------
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
        });
	//End Button Configuration
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
                	<table class="wordAreaTable">
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page11}}" data="{{page1Data1}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page12}}" data="{{page1Data2}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page13}}" data="{{page1Data3}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page14}}" data="{{page1Data4}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page15}}" data="{{page1Data5}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page16}}" data="{{page1Data6}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page17}}" data="{{page1Data7}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page18}}" data="{{page1Data8}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page19}}" data="{{page1Data9}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page110}}" data="{{page1Data10}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page111}}" data="{{page1Data11}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page112}}" data="{{page1Data12}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page113}}" data="{{page1Data13}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page114}}" data="{{page1Data14}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page115}}" data="{{page1Data15}}" />
							</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page116}}" data="{{page1Data16}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page117}}" data="{{page1Data17}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page118}}" data="{{page1Data18}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page119}}" data="{{page1Data19}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page120}}" data="{{page1Data20}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page121}}" data="{{page1Data21}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page122}}" data="{{page1Data22}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page123}}" data="{{page1Data23}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page124}}" data="{{page1Data24}}" />
                        	</td>
                   		</tr>
                	</table>
            	</div>
            	<div ID="wordArea2" style="display:none">
                	<table class="wordAreaTable">
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page21}}" data="{{page2Data1}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page22}}" data="{{page2Data2}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page23}}" data="{{page2Data3}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page24}}" data="{{page2Data4}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page25}}" data="{{page2Data5}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page26}}" data="{{page2Data6}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page27}}" data="{{page2Data7}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page28}}" data="{{page2Data8}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page29}}" data="{{page2Data9}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page210}}" data="{{page2Data10}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page211}}" data="{{page2Data11}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page212}}" data="{{page2Data12}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page213}}" data="{{page2Data13}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page214}}" data="{{page2Data14}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page215}}" data="{{page2Data15}}" />
							</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page216}}" data="{{page2Data16}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page217}}" data="{{page2Data17}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page218}}" data="{{page2Data18}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page219}}" data="{{page2Data19}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page220}}" data="{{page2Data20}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page221}}" data="{{page2Data21}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page222}}" data="{{page2Data22}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page223}}" data="{{page2Data23}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" value="Back" onclick="pageHide(2)" />
                        	</td>
                   		</tr>
                	</table>
            	</div>
            	<div ID="wordArea3" style="display:none">
                	<table class="wordAreaTable">
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page31}}" data="{{page3Data1}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page32}}" data="{{page3Data2}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page33}}" data="{{page3Data3}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page34}}" data="{{page3Data4}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page35}}" data="{{page3Data5}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page36}}" data="{{page3Data6}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page37}}" data="{{page3Data7}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page38}}" data="{{page3Data8}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page39}}" data="{{page3Data9}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page310}}" data="{{page3Data10}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page311}}" data="{{page3Data11}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page312}}" data="{{page3Data12}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page313}}" data="{{page3Data13}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page314}}" data="{{page3Data14}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page315}}" data="{{page3Data15}}" />
							</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page316}}" data="{{page3Data16}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page317}}" data="{{page3Data17}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page318}}" data="{{page3Data18}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page319}}" data="{{page3Data19}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page320}}" data="{{page3Data20}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page321}}" data="{{page3Data21}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page322}}" data="{{page3Data22}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page323}}" data="{{page3Data23}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" value="Back" onclick="pageHide(3)" />
                        	</td>
                   		</tr>
                	</table>
            	</div>
            	<div ID="wordArea4" style="display:none">
                	<table class="wordAreaTable">
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page41}}" data="{{page4Data1}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page42}}" data="{{page4Data2}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page43}}" data="{{page4Data3}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page44}}" data="{{page4Data4}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page45}}" data="{{page4Data5}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page46}}" data="{{page4Data6}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page47}}" data="{{page4Data7}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page48}}" data="{{page4Data8}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page49}}" data="{{page4Data9}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page410}}" data="{{page4Data10}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page411}}" data="{{page4Data11}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page412}}" data="{{page4Data12}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page413}}" data="{{page4Data13}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page414}}" data="{{page4Data14}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page415}}" data="{{page4Data15}}" />
							</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page416}}" data="{{page4Data16}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page417}}" data="{{page4Data17}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page418}}" data="{{page4Data18}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page419}}" data="{{page4Data19}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page420}}" data="{{page4Data20}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page421}}" data="{{page4Data21}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page422}}" data="{{page4Data22}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page423}}" data="{{page4Data23}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" value="Back" onclick="pageHide(4)" />
                        	</td>
                   		</tr>
                	</table>
            	</div>
            	<div ID="wordArea5" style="display:none">
                	<table class="wordAreaTable">
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page51}}" data="{{page5Data1}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page52}}" data="{{page5Data2}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page53}}" data="{{page5Data3}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page54}}" data="{{page5Data4}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page55}}" data="{{page5Data5}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page56}}" data="{{page5Data6}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page57}}" data="{{page5Data7}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page58}}" data="{{page5Data8}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page59}}" data="{{page5Data9}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page510}}" data="{{page5Data10}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page511}}" data="{{page5Data11}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page512}}" data="{{page5Data12}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page513}}" data="{{page5Data13}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page514}}" data="{{page5Data14}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page515}}" data="{{page5Data15}}" />
							</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page516}}" data="{{page5Data16}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page517}}" data="{{page5Data17}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page518}}" data="{{page5Data18}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page519}}" data="{{page5Data19}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page520}}" data="{{page5Data20}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page521}}" data="{{page5Data21}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page522}}" data="{{page5Data22}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page523}}" data="{{page5Data23}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" value="Back" onclick="pageHide(5)" />
                        	</td>
                   		</tr>
                	</table>
            	</div>
            	<div ID="wordArea6" style="display:none">
                	<table class="wordAreaTable">
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page61}}" data="{{page6Data1}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page62}}" data="{{page6Data2}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page63}}" data="{{page6Data3}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page64}}" data="{{page6Data4}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page65}}" data="{{page6Data5}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page66}}" data="{{page6Data6}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page67}}" data="{{page6Data7}}" />
                        	</td>
                        	<td>
                           		<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page68}}" data="{{page6Data8}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page69}}" data="{{page6Data9}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page610}}" data="{{page6Data10}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page611}}" data="{{page6Data11}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page612}}" data="{{page6Data12}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page613}}" data="{{page6Data13}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page614}}" data="{{page6Data14}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page615}}" data="{{page6Data15}}" />
							</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page616}}" data="{{page6Data16}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page617}}" data="{{page6Data17}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page618}}" data="{{page6Data18}}" />
                        	</td>
                    	</tr>
                    	<tr>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page619}}" data="{{page6Data19}}" />
                        	</td>
                        	<td>
                            	<input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page620}}" data="{{page6Data20}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page621}}" data="{{page6Data21}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page622}}" data="{{page6Data22}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" ng-click="loadWords($event)" value="{{page623}}" data="{{page6Data23}}" />
                        	</td>
                        	<td>
                                <input type="button" class="wordButton" value="Back" onclick="pageHide(6)" />
                        	</td>
                   		</tr>
                	</table>
            	</div>
            </div>
        </form>
    </div>
</body>
</html>
