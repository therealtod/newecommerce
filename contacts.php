<?php
session_start() 
?>
<?php
$my_email = "giuseppe.palazzotto@gmail.com"; //email a cui spedire il modulo
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contatti - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
    <div align="center" id="mainWrapper">
        <?php include_once("./template_header.php"); ?>
        <div id="pageContent">
            <table width="100%" border="0 cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top">&nbsp;</td>
                    <td valign="top">
                        <p>
                           <?php
if (isset($_REQUEST['email'])) {
	//send email
	$email = $_REQUEST['email'] ;
	$subject = $_REQUEST['subject'] ;
	$message = $_REQUEST['message'] ;

	echo "<table class='table' width='50%'>
		<tr class='table_header'>
			<td>Contact Form</td>
		</tr>
		<tr class='row1'>
			<td>";
				if ($email == "") {
					echo "ERRORE: Devi inserire un indirizzo email<br>";
					echo "<input type='button' value='Back' onclick='goBack()' />";
					exit;
				}
				if ($subject == "") {
					echo "ERRORE: Devi inserire un soggetto<br>";
					echo "<input type='button' value='Back' onclick='goBack()' />";
					exit;
				}
				if ($message == "") {
					echo "ERRORE: Devi inserire un messaggio<br>";
					echo "<input type='button' value='Back' onclick='goBack()' />";
					exit;
				}

			mail($my_email, $subject,
			$message, "From:" . $email);
			echo "Grazie per averci contattato.<br>Il tuo messaggio è stato inviato.
			</td>
		</tr>
	</table>";
 
} else {

	echo "<form method='post' action='contacts.php'>
		<table class='table' width='40%'>
			<tr class='table_header'>
				<td colspan='2'><h3>Contattaci</h3></td>
			</tr>
			<tr class='row1'>
				<td>Email:</td>
				<td>
					<input name='email' type='text' />
				</td>
			</tr>
			<tr class='row1'>
				<td>Soggetto:</td>
				<td>
					<input name='subject' type='text' />
				</td>
			</tr>
			<tr class='row1'>
				<td valign='top'>Messaggio:</td>
				<td>
					<textarea name='message' rows='8' cols='40'></textarea>
				</td>
			</tr>
			<tr class='row1'>
				<td>&nbsp;</td>
				<td>
					<input type='submit' value='Send Message' />
				</td>
			</tr>
		</table>
	</form>";
}
?>
                            
                            
                            Email: siacommerce@outlook.com
                        </p>
                        <p>
                            Telefono 1234556789
                        </p>
                    </td>
                    <td valign="top"></td>
                </tr>
            </table>

        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>