<?php
include("html/header.html");
include("config.php");
ini_set("max_execution_time", 60);  
include("phpmailer/class.phpmailer.php");                                                 // Appel de mon class.phpmailer
include("phpmailer/class.smtp.php");

function random_str($nbr) {
    $str = "";
    $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSUTVWXYZ0123456789";
    $nb_chars = strlen($chaine);

    for($i=0; $i<$nbr; $i++)
    {
        $str .= $chaine[ rand(0, ($nb_chars-1)) ];
    }

    return $str;
}

if(isset( $_POST['email'],$_POST['date'])){
$email = $_POST['email'];
$dn= mysqli_query($link,'select id,date_naissance from users where email ="'.$email.'"');
$rep = mysqli_fetch_assoc($dn);

if ($rep['date_naissance']== $_POST['date']){
		$chaine = random_str(7);
		$dn2 = mysqli_query($link,'UPDATE users SET password="'.$chaine.'" WHERE id="'.$rep['id'].'"');
		$mail = new PHPMailer();
		$mail->SMTPDebug = 2;
		$mail->IsSMTP();               
		$mail->Mailer = "smtp";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587; 
														  
		$mail->From       = "hdovan95@gmail.com";
		$mail->FromName   = "Admin Adalys";
		$mail->Subject    = "Nouveau Mot de passe";
		$mail->AltBody    = "This is the body when user views in plain text format"; 
		$mail->WordWrap   = 50; // set word wrap
		$mail->Body	= 'Votre nouveau mot de passe est "'.$chaine.'"';
		$mail->AddAddress($_POST['email']);
																
		if(!$mail->send()) 
		{
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
			echo "Message has been sent successfully";
			
		}
	}
}
?>
<body class="login-bg">
		<div class="login-body">
			<div class="login-heading">
				<h1>Password oublié</h1>
			</div>
			<div class="login-info">
				<form action="pass_forgot.php" method="post">
					<input type="text" class="user" name="email" placeholder="Email" required="">
					<input type="date" name="date" required=""/>
					<input type="submit" name="Send" value="Send">
				</form>
			</div>
		</div>
<?php include("html/footer.html"); ?>