<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Guides DashBoard</title>
	<link rel="stylesheet" href="../App_Themes/bootstrap.min.css">
	<script src="../Scripts/jquery-1.12.3.min.js"></script>
  	<script src="../Scripts/bootstrap.min.js"></script>
</head>
    
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="../Main/Default.php">
					<img class="img-responsive" src="../Images/YouSpeakTxtLarge.png" alt="YouSpeak Large" width="130"/>
				</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="../Main/Home.php">Home</a></li>
				<li><a href="../Main/Default.php">Application</a></li>
				
			</ul>
			<div id="navbar" class="nav navbar-nav navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="../Main/Dashboard.php">Dashboard</a></li>
					<li class="active"><a href="../Main/Guides.php">Guides</a></li>
					<li><a href="../Main/UpdateWordBank.php">New Words</a></li>
					<li><a href="../Main/CodeBehind.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<h1><b>Guides</b></h1><hr><hr>
		<p> Welcome to YouSpeak's Guide Dashboard. If you've found yourself here then you're probably in need of help, and that's exactly what this area of the application aims to do. Within this section, you'll find information on general and advanced use of YouSpeak, as well as the information necessary to configure the application should you require it.</p><hr><hr>
		<h2>Application Basics</h2>
		<p>The main page, and primary function, of the YouSpeak application is the Speech Tool. This is where you'll spend most of your time, so it's a good idea to have an understanding of how it works, and how to use it.</p><hr><hr>
		<h3>Navigation and Speech Bar</h3>

		<p>At the top of the tool you'll see the navigation bar. From this bar you can access the Settings, as well as the Dashboard of the application, amongst other pages. Additional links may appear as the functionality the application increases, so watch this space for future updates!</p><br>
		<p>The area below the navigation bar is the speech bar. Providing that the application is set to <i>Push to Talk</i>, each selected word will appear in this location to create a phrase. More information will be provided on configuration later in this guide.</p><br>
		<img class="img-responsive" src="../images/nav_bar_example.png" alt="Navigation Bar"/><hr><hr>

<h3>Speech Command, Deletion and Settings</h3>

		<p>Towards the top right of the speech application page, you can see three icons. The topmost Cog icon provides access to the application settings, which will be discussed at a later point. Below this, two icons can be seen. The bin icon can be used to clear the speech bar of words, whilst the speech icon will speak the current phrase.<p><br>
		<img class="img-responsive" src="../images/speech_button_example.png" alt="Speech Area"/><hr><hr>

		<h3>Word Bank</h3>

		<p>The most important area of the speech application page is the word bank, which contains all the words and categories you'll use everyday to speak. This area can found below both the navigation and speech bar.</p>

		<p>The Word Bank is split into words and categories. The two can be distinguished easily, as categories are surrounded by a black box whilst words are not, and consequently have no border.</p><br>

		<img class="img-responsive" src="../images/word_bank_example.png" alt="Word Bank"/><hr><hr>
		
		<h2>Application Configuration and Adjustment</h2>
		</p>YouSpeak provides you with a number of configuration options to adjust and change the application should you need to. We hope the application is suited to your needs, but we also realise that your needs may change and vary on a regular basis. Consequently, this section will detail some of the options available to customise your YouSpeak experience.</p><hr><hr>
		<h3>Accessing the Settings Interface</h3>
		<p>Firstly, before we analyse the available configuration options, let's look at where we can access the settings interface. Take a look at the top right of the main application page and you should see the following settings Cog Icon.</p>
		
		<img class="img-responsive" src="../images/settings_icon.png" alt="Settings Cog Icon"/><br>
		<p>Try clicking, or tapping, the Cog Icon to open the Settings Interface.</p><hr><hr>
		<h3>Settings Interface Explained</h3>
		<p>Once opened, the Settings Interface should like something like this:<p><br>

		<img class="img-responsive" src="../images/settings_example.png" alt="Settings Menu"/><br>
		<p>This Settings menu is split into two sections, <i>Look and Feel</i> and <i>Speech and Interaction</i>. The <i>Look and Feel</i> column allows you to customise exactly that; the look and feel of the application. This may be useful if you're looking for a change, or just feel like making the application more specific to you. On the other hand, the <i>Speech and Interaction</i> column provides a greater level of control over the application and its behaviour. </p>
		<hr><hr>
		<h4>Look and Feel</h4>
		<p>You may find that the <i>Look and Feel</i> area of the settings interface is self-explanatory. Firstly, you can adjust the <i>Colour Theme</i> of the speech application page, which will adjust the colour of both the navigation and speech bar. Secondly, the <i>Background Colour</i> setting can be used to change the background colour of the word bank area. Finally, the scanning colour will adjust the colour used to highlight the word currently selected by the scanning functionality.</p><br>

		<img class="img-responsive" src="../images/look_and_feel.png" alt="Look and Feel"/><br><hr><hr>

		<h4>Speech and Interaction</h4>
		<p>The Speech and Interaction configuration column allows you to adjust YouSpeak's behaviour, but may require a little more understanding to use.</p><br>

		<h4>Speech Settings</h4>
		<p>The first option titled <i>Speech Settings</i> enables you to change the way in which YouSpeak responds to your interaction. This setting has three options which are:</p><br>
		<ol><li><i>Push to Talk</i></li><li><i>Select to Talk</i></li><li><i>Push and Select to Talk</i></li></ol><br>

		<p><b>Push To Talk</b>: As words are selected they are added into the speech bar, but are not automatically spoken by YouSpeak. To say the phrase, you must push, or tap the speech icon.</p><br>

		<p><b>Select To Talk</b>: Words are automatically spoken as and when they are selected. Consequently, they are not added into the speech bar to create a phrase.</b><br><br>

		<p><b>Push and Select to Talk</b>: A hybrid of the previous two options, this option will speak a word as and when it is selected, but will also append it into the speech bar so that it can be spoken within a phrase.</p><br>

		<h4>Interaction Method</h4>
		<p>The second option is the <i>Interaction Method</i> which allows you to determine how Words and Categories are selected. This setting also has three options which are:<p><br> 
		<ol><li><i>Touch</i></li><li><i>Single Scanning</i></li><li><i>Row Scanning</i></li></ol><br>


		<p><b>Touch</b>: Words and Categories are manually selected by clicking, or tapping the desired icon.</p><br>

		<p><b>Single Scanning</b>: Single-step scanning is used iterate through the word bank and select words or categories.</p><br>

		<p><b>Row Scanning</b>: Row scanning is used to iterate through the rows within the Word Bank.</p><br>

		<h4>Scanning Speed</h4>
		<p>Providing that the Interaction method is set to either Single or Row scanning, this option can be used to set the scanning speed.</p><br>

		<h4>Voice Type</h4>
		<p>This option allows you to set the voice type used by YouSpeak when talking. There are a number of options available, with more due to be added in the future.</p><br>

		<h4>Volume</h4>
		<p>The final option of the <i>Speech and Interaction</i> column allows you to adjust the speech volume of YouSpeak.</p><hr><hr>

		<h2>Additional and Advanced Configuration</h2>
		<p>For additional and more advanced configuration, you are able to add and delete words and word categories from the Word Bank. Whilst we feel the complete Word Bank will provide you with all of the words you need to speak each day, the option to add or delete Word Bank entries will allow for verbose configuration. To do this, select the <i>New Words</i> option witin the Dashboard area, as shown below, and follow the instructions within that page</p><br>

		<img class="img-responsive" src="../images/new_words_option.png" alt="New Words Option"/><br><hr><hr>

	</div>
	
</body>
</html>
