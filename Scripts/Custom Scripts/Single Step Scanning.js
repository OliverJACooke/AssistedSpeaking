			
			var k = 1;
			var l = 0;  
			var cell = "";
			var previousCell = "";
			var subCell = "";
			var subCellPreviouse ="";
			var mainMenuLength = mainMenuIDs.length;
			var keyPressed = false;
			var bottomOfMenu = 0;
			var topOfMenu = 0;
			var bottomOfMenu = 0;
			var topOfMenu = 0;
			
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
				
							if (k <= totalMainPhrase) {
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
								
											var page = pageNo - totalMainPhrase;
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
			
			selectedSubMenu(1);