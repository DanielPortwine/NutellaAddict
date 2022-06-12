<?php
session_start();
if (isset($_SESSION['message'])){ echo '<p id="messageBox">' . $_SESSION['message'] . '</p>'; unset($_SESSION['message']);}
?>
<html>
    <head>
        <title>Nutella Addict</title>
		<meta http-equiv="Cache-control" content="no-cache">
        <link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="images/Nutella.ico">
		<script src="script.js"></script>
		<script src="block.js"></script>
    </head>
    <body <?php if (isset($_SESSION['message'])){ echo 'onload="hideMessage()"';} else { echo 'onload="hideMessage();showHideCustom()"';} ?>>
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
        <p class="title">Map Generator</p>
        <div class="centralBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
            <p class="subtitle">Enter your desired map options:</p>
            <p class="detail">To save a map, the area must be less than 1000</p><br>
            <form class="formInput" method="post" action="mapGeneration.php">
                <input class="coordinateBox" type="text" name="x" placeholder="x" maxlength="3" autofocus required>
                <input class="coordinateBox" type="text" name="y" placeholder="y" maxlength="3" required>
                <select name="mapType" id="mapTypeBox" onchange="showHideCustom()" required>
                    <option value="1">Islands</option>
                    <option value="2">Balanced</option>
                    <option value="3">Lakes</option>
					<option value="4">Custom</option>
                </select>
				<div id="customMapBox">
					<input class="customValueBox" id="aValue" type="text" name="a" placeholder="a" maxlength="1" required>
					<input class="customValueBox" id="bValue" type="text" name="b" placeholder="b" maxlength="1" required>
					<input class="customValueBox" id="cValue" type="text" name="c" placeholder="c" maxlength="1" required>
					<input class="customValueBox" id="dValue" type="text" name="d" placeholder="d" maxlength="1" required>
					<input class="customValueBox" id="eValue" type="text" name="e" placeholder="e" maxlength="1" required>
					<input class="customValueBox" id="fValue" type="text" name="f" placeholder="f" maxlength="1" required>
					<br>
					<div id="radioButtons">
						<input id="landRadio" type="radio" name="tileToUse" value="0" required>Land
						<input id="waterRadio" type="radio" name="tileToUse" value="1">Water
					</div>
				</div>
				<br><br>
                <input class="submitButton" type="submit" name="submit" value="Go">
            </form>
        </div>
    </body>
</html>