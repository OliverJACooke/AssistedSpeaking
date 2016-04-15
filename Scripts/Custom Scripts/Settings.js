		// Global settings object	
			var applicationSettings = {
				themeColour: "Standard",
				backgroundColour: "White",
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
			
			document.body.onkeyup = function(e){
				if (applicationSettings.interaction == "Scanning") {
					if(e.keyCode == 32) {
						keyPressed = true;  
					}
					else {
						keyPressed = false;
					}   
				}
			
				if(e.keyCode == 13) {
					 angular.element(document.getElementById('speechButton')).scope().DataWords();
				}
			}
//Row scanning