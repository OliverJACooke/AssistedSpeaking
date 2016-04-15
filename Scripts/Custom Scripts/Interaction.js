	function apply_scanning_color(cell, cellColor) {
		document.getElementById(cell).style.backgroundColor = cellColor;
	}
	
	var i = 1;
	var j = 0;
	var keyPressed = false;
	var mainMenuLength = mainMenuIDs.length;
	var cell = "";
	var previousCell = "";
	
	function mainLoop() {
		if (applicationSettings.interaction == "singleScanning") {
			setTimeout(function () {
				cell = "cell" + mainMenuIDs[i];	
				previousCell = "cell" + mainMenuIDs[j];
				
				if (keyPressed == false) {
					
					apply_scanning_color(cell, applicationSettings.scanningColour);
					
					if (j == mainMenuLength - 2) {
						document.getElementById(previousCell).style.backgroundColor = "transparent"; 
						j = 0;
					}
					
					if (j != 0) { 
						apply_scanning_color(previousCell, "Transparent"); 
					}
					
					i++;
					j++;
					
					if (i == mainMenuLength - 1) {
						apply_scanning_color(previousCell, "Transparent");
						i = 1;
						j = mainMenuLength - 2;
					}
					
					mainLoop();
				}
				else {
					document.getElementById(previousCell).style.backgroundColor = "transparent";
					document.getElementById(previousCell).click();
				
					keyPressed = false;
					
					if (previousCell == "cell" + mainMenuIDs[mainMenuLength - 2]) {
						i = mainMenuLength - 1;
					}	
				
					if (i <= totalMainPhrase) {
						i = 1;
						j = 0; 
						mainLoop();
						
					} 
					else {
						apply_scanning_color(cell, "Transparent"); 
						selectedSubMenu(i);
						pageNo = i;
				
						var k = bottomOfMenu - 1;
						var l = bottomOfMenu; 
						
						function subLoop(){
							setTimeout(function () {
								var subCell = "cell" + l;     
								var subPreviousCell = "cell" + k; 
									
								i = 1;
								j = 0;
								if (keyPressed == false) {				
									apply_scanning_color(subCell, applicationSettings.scanningColour); 
										
									if (l != 0) { 
										apply_scanning_color(subPreviousCell, "Transparent"); 
									} 			
									
									k++;    
									l++;            
										   
									if (k == (topOfMenu + 1)) {
										setTimeout(function () {  
											apply_scanning_color(subPreviousCell, "Transparent"); 
										}, applicationSettings.scanningSpeed)
										
										k = bottomOfMenu - 1;
										l = bottomOfMenu; 
									}
									subLoop();            
								} else {
									apply_scanning_color(subPreviousCell, "Transparent");  
									document.getElementById(subPreviousCell).click();
										
									keyPressed = false;
													
									var page = pageNo - totalMainPhrase;
									page = page + 1;
													
									document.getElementById("wordArea" + page).style.display = "none";
									document.getElementById("wordArea1").style.display = "block";
									
									return; 
								}
							}, applicationSettings.scanningSpeed) 
						} 
						subLoop();
						mainLoop();
					}
				}
			}, applicationSettings.scanningSpeed)
		}
		else if (applicationSettings.interaction == "rowScanning") {
			setTimeout(function () {
				var rowsValue = document.getElementById("wordArea1").getElementsByTagName("div").length / 12;
				var numberOfRows = Math.ceil(rowsValue);
				
				if (keyPressed == false) {
					if (i == numberOfRows + 1) {
						document.getElementById(j).style.backgroundColor = "transparent";
						i = 1;
						j = 0;
					}
				
					document.getElementById(i).style.backgroundColor = "blue";
					
					if(j != 0) {
						document.getElementById(j).style.backgroundColor = "transparent";
					}
					
					i++;					
					j++;
					
					
					mainLoop();
				} else {
					keyPressed = true;
					
					i = 1;
					j = 0;
					
					
				}
				
				
			}, applicationSettings.scanningSpeed)
		} 
		else if (applicationSettings.interaction == "touch") {
			if (cell != "") {
				apply_scanning_color(cell, "Transparent"); 
				document.getElementById(j).style.backgroundColor = "transparent";
				i = 1;
				j = 0;
			}
		}	
	}
	
	selectedSubMenu(1);
	
	function onTouchDisabledClick() {
		keyPressed = true;
	}
	
	document.body.onkeyup = function(e){
		if (applicationSettings.interaction == "singleScanning") {
			if(e.keyCode == 32) {
				keyPressed = true;  		
			}
			else {
				keyPressed = false;
			}   
		}
		
		if (e.keyCode == 13) {
			angular.element(document.getElementById('speechButton')).scope().DataWords();
		}
	}