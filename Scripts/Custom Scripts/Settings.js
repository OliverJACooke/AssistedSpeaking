		// Global settings object	
			var applicationSettings = {
				themeColour: "Standard",
				backgroundColour: "Standard",
				scanningColour: "Blue",
				interaction: "Touch",
				scanningSpeed: 1000,
				applicationVolume: 0.5,
				speechType: "UK English Female"
			};
			
		// On page load apply settings and removing loading screen
			window.onload = function() {
				applyColourTheme();
				applyBackgroundColour();
				applyScanningColour();
				applyInteractionMethod();
				applyScanningSpeed();
				
				document.getElementById("overLay1").style.display = "none";
			};
			
			//Refresh the page reloading the words
			function refreshPage() {
				location.reload();
			}
		
			function closeSettings() {
				document.getElementById("overLay2").style.display = "none";
			}
		
			function openSettings() {
				document.getElementById("overLay2").style.display = "block";
			}
			
			function pageHide(page) {
				document.getElementById("wordArea" + page).style.display = "none";
				document.getElementById("wordArea1").style.display = "block";
			}
			
	// --- Look and Feel ---
		// --- Change top header color ---
		
			colourTheme.onchange = function() {
				applyColourTheme();
			};
			
			function applyColourTheme() {
				applicationSettings.themeColour = document.getElementById("colourTheme").value;
				var headerColour;
				var speachbarColor;
			
				switch (applicationSettings.themeColour) {
					case "Standard":
						headerColour = "#44D1FF";
						speachbarColor = "#C3F1FF";
						break;
					case "Dark":
						headerColour = "#1E1A26";
						speachbarColor = "#5B6973";
						break;
					case "Light":
						headerColour = "#BACFFF";
						speachbarColor = "#C1EDFF";
						break;
					default:
						headerColour = "#1E1A26";
						speachbarColor = "#5B6973";
				}
				
				document.getElementById("header").style.backgroundColor = headerColour;
				document.getElementById("speechBar").style.backgroundColor = speachbarColor;
			}
		
		// --- Change application background color ---
			backgroundColour.onchange = function() {
				applyBackgroundColour();
			};
			
			function applyBackgroundColour() {
				var colourToUse = document.getElementById("backgroundColour").value;
				
				switch (colourToUse) {
					case "Blue":
						applicationSettings.backgroundColour = "Blue";
						break;
					case "Red":
						applicationSettings.backgroundColour = "Red";
						break;
					case "Standard":
						applicationSettings.backgroundColour = "White";
						break;
					case "Green":
						applicationSettings.backgroundColour = "Green";
						break;
					default:
						applicationSettings.backgroundColour = "White";
				}
				
				document.getElementById("wordAreaContainer").style.backgroundColor = applicationSettings.backgroundColour;
			}
		
		// --- Change application scanning square color ---
			scanningColour.onchange = function(){
				applyScanningColour();
			}
			
			function applyScanningColour() {
				var scanningColourToUse = document.getElementById("scanningColour").value;
				
				switch (scanningColourToUse) {
					case "Blue":
						applicationSettings.scanningColour = "Blue";
						break;
					case "Red":
						applicationSettings.scanningColour = "Red";
						break;
					case "Green":
						applicationSettings.scanningColour = "Green";
						break;
					default:
						applicationSettings.scanningColour = "Blue";
				}
			}
			
	// --- Interface Options ---
		// --- Change scanning options ---
			interactionMethod.onchange = function() {
				applyInteractionMethod();
			}
			
			function applyInteractionMethod() {
				var interactionToUse = document.getElementById("interactionMethod").value;
				
				switch (interactionToUse) {
					case "Scanning":
						applicationSettings.interaction = "Scanning";
						mainLoop();
						break;
					case "Touch":
						applicationSettings.interaction = "Touch";
						break;
				}
			}
			
		// --- Change scanning speed ---
			scanningSpeed.onchange = function() {
				applyScanningSpeed();
			}
			
			function applyScanningSpeed(scanningSpeedToUse) {
				var scanningSpeedToUse = document.getElementById("scanningSpeed").value;
				
				switch (scanningSpeedToUse) {
					case "Slow":
						applicationSettings.scanningSpeed = 1500;
						break;
					case "Standard":
						applicationSettings.scanningSpeed = 1000;
						break;
					case "Fast":
						applicationSettings.scanningSpeed = 750;
						break;
					case "VeryFast":
						applicationSettings.scanningSpeed = 500;
						break;
				}
			}
		
		// --- Change voice type ---
			function selectedVoiceType() {
				var voiceTypeToUse = document.getElementById("voiceType").value;
				applicationSettings.speechType = voiceTypeToUse;
			}
			
		// --- Change scanning speed ---
			voiceVolume.onchange = function() {
				applySpeechVolume();
			}
			
			function applySpeechVolume() {
				var volumeToUse = document.getElementById("voiceVolume").value;
				
				switch (volumeToUse) {
					case "Quite":
						applicationSettings.applicationVolume = 0.1;
						break;
					case "Standard":
						applicationSettings.applicationVolume = 0.5;
						break;
					case "Loud":
						applicationSettings.applicationVolume = 1;
						break;
				}
			}
			
//Single Step Scanning
			var k = 1;
			var l = 0;  
			var cell = "";
			var previousCell = "";
			var subCell = "";
			var subCellPreviouse ="";
			var mainMenuLength = mainMenuIDs.length;
	
			function mainLoop () {   
				if (applicationSettings.interaction == "Scanning")
				{        
					setTimeout(function () {
		
						cell = "cell" + mainMenuIDs[k];	
						previousCell = "cell" + mainMenuIDs[l];
			
						if (keyPressed == false) {		
							document.getElementById(cell).style.backgroundColor = applicationSettings.scanningColour;
			
							if (l == mainMenuLength - 2) {
								document.getElementById(previousCell).style.backgroundColor = "transparent"; 
								l = 0;
							}
				
							if (l != 0) { 
								document.getElementById(previousCell).style.backgroundColor = "transparent"; 
							} 			
				
							k++;    
							l++; 
						
							if (k == mainMenuLength - 1) {
								setTimeout(function () {   
									document.getElementById(cell).style.backgroundColor = "transparent";
								}, scanningSpeed)	
								k = 1;
								l = mainMenuLength - 2;
							}
				
							mainLoop();            
						}
						else {
							document.getElementById(previousCell).style.backgroundColor = "transparent";
				
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
											document.getElementById(subCell).style.backgroundColor = applicationSettings.scanningColour;  
					
											if (j != 0) { 
												document.getElementById(subPreviousCell).style.backgroundColor = "transparent"; 
											} 			
				
											i++;    
											j++;            
					   
											if (i == (topOfMenu + 1)) {
												setTimeout(function () {  
														document.getElementById(subCell).style.backgroundColor = "transparent"; 
												}, scanningSpeed)
												i = bottomOfMenu + 1;
												j = bottomOfMenu + 0; 
											}
				
											subLoop();            
										}
										else {
											document.getElementById(subPreviousCell).style.backgroundColor = "transparent"; 
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
									}, applicationSettings.scanningSpeed) 
								} 
							}
						}
					}, applicationSettings.scanningSpeed)
				}
				else if (applicationSettings.interaction == "Touch") {
					document.getElementById(cell).style.backgroundColor = "transparent";
					k = 1;
					l = 0;
					cell = "";
					previousCell = "";
					subCell = "";
					subCellPreviouse ="";
			
				}
			}
			
			