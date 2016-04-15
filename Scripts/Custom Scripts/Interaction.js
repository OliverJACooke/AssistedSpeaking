	function apply_scanning_color(cell, cellColor) {
		document.getElementById(cell).style.backgroundColor = cellColor;
	}
	
	var i = 1;
	var j = 0;
	var keyPressed = false;
	var mainMenuLength = mainMenuIDs.length;
	
	function mainLoop() {
		if (applicationSettings.interaction == "singleScanning") {
			setTimeout(function () {
				var cell = "cell" + mainMenuIDs[i];	
				var previousCell = "cell" + mainMenuIDs[j];
				
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
								subCell = "cell" + l;     
								subPreviousCell = "cell" + k; 
									
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
				
			}, applicationSettings.scanningSpeed)
		} 
		else if (applicationSettings.interaction == "touch") {
			
		}	
	}
	
	selectedSubMenu(1);
	
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
	
			
			
			
			
			
			
			// var k = 1;
			// var l = 0;  
			// var cell = "";
			// var previousCell = "";
			// var subCell = "";
			// var subCellPreviouse ="";
			// var mainMenuLength = mainMenuIDs.length;
			// var keyPressed = false;
			// var bottomOfMenu = 0;
			// var topOfMenu = 0;
			// var bottomOfMenu = 0;
			// var topOfMenu = 0;
			
			// function mainLoop () {   
				// if (applicationSettings.interaction == "Scanning") {        
					// setTimeout(function () {
						// cell = "cell" + mainMenuIDs[k];	
						// previousCell = "cell" + mainMenuIDs[l]; 
			
						// if (keyPressed == false) {
							// document.getElementById(cell).style.backgroundColor = applicationSettings.scanningColour;
			
							// if (l == mainMenuLength - 2) {
								// document.getElementById(previousCell).style.backgroundColor = "transparent"; 
								// l = 0;
							// }
				
							// if (l != 0) { 
								// document.getElementById(previousCell).style.backgroundColor = "transparent"; 
							// } 			
				
							// k++;    
							// l++; 
						
							// if (k == mainMenuLength - 1) {
								// setTimeout(function () {   
									// document.getElementById(cell).style.backgroundColor = "transparent";
								// }, scanningSpeed)	
								// k = 1;
								// l = mainMenuLength - 2;
							// }
				
							// mainLoop();            
						// }
						// else {
							// document.getElementById(previousCell).style.backgroundColor = "transparent";
				
							// document.getElementById(previousCell).click();
				
							// keyPressed = false;
					
							// if (previousCell == "cell" + mainMenuIDs[mainMenuLength - 2]) {
								// k = mainMenuLength - 1;
							// }	
				
							// if (k <= totalMainPhrase) {
								// k = 1;
								// l = 0; 
					
								// mainLoop();
							// }
							// else {
					
								// selectedSubMenu(k);
								// pageNo = k;
				
								// i = bottomOfMenu + 1;
								// j = bottomOfMenu + 0; 
					
								// subLoop();
								// mainLoop();
					
								// function subLoop () { 
									// setTimeout(function () {
										// subCell = "cell" + i;     
										// subPreviousCell = "cell" + j;
										// k = 1;
										// l = 0; 
							
										// if (keyPressed == false) {				
											// document.getElementById(subCell).style.backgroundColor = applicationSettings.scanningColour;  
					
											// if (j != 0) { 
												// document.getElementById(subPreviousCell).style.backgroundColor = "transparent"; 
											// } 			
				
											// i++;    
											// j++;            
					   
											// if (i == (topOfMenu + 1)) {
												// setTimeout(function () {  
														// document.getElementById(subCell).style.backgroundColor = "transparent"; 
												// }, scanningSpeed)
												// i = bottomOfMenu + 1;
												// j = bottomOfMenu + 0; 
											// }
				
											// subLoop();            
										// }
										// else {
											// document.getElementById(subPreviousCell).style.backgroundColor = "transparent"; 
											// document.getElementById(subPreviousCell).click();
					
											// keyPressed = false;
								
											// var page = pageNo - totalMainPhrase;
											// page = page + 1;
								
											// document.getElementById("wordArea" + page).style.display = "none";
											// document.getElementById("wordArea1").style.display = "block";
								
											// i = bottomOfMenu + 1;
											// j = bottomOfMenu + 0;
				
											// return; 
										// }
									// }, applicationSettings.scanningSpeed) 
								// } 
							// }
						// }
					// }, applicationSettings.scanningSpeed)
				// }
				// else if (applicationSettings.interaction == "Touch") {
					// document.getElementById(cell).style.backgroundColor = "transparent";
					// k = 1;
					// l = 0;
					// cell = "";
					// previousCell = "";
					// subCell = "";
					// subCellPreviouse ="";
			
				// }
			// }
			
		