<?php
require_once('mysql_bdd_connect.php'); 
require_once('lib/PHPMailerAutoload.php');
session_start();
/*--------------------------------------------------------------------------------------*/
/*-----------------------------[Authentification]---------------------------------------*/
/*--------------------------------------------------------------------------------------*/
//login
if(isset($_POST['pseudo']) && isset($_POST['password']) && !isset($_POST['email']) ){
	
	$json = array();
	
	$requete = 'SELECT count(*) AS count, m.pseudo AS pseudo, m.groupe AS groupe

	FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string($_POST['pseudo']).'" AND pass_md5="'.mysql_escape_string($_POST['password']).'"';
    
   	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	$result = mysql_query($requete) or die(mysql_error());
	$data = mysql_fetch_array($result);
	mysql_free_result($data);
	mysql_close();
    
	if ($data[count] == 1) {
		
		if($data['groupe']=='en attente'){
			echo 'en attente';
		}
		else if($data['groupe']=='membre' || $data['groupe']=='admin'){
			$_SESSION['pseudo'] = $data['pseudo'];
			
			$requete2 = 'UPDATE 2015_membre
			SET membre_date_derniere_connexion=NOW()
			WHERE pseudo = "'.mysql_real_escape_string(trim($_SESSION['pseudo'])).'"';
			
   			$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
			$db=mysql_select_db($base,$connexion) or die (mysql_error());
			$result2 = mysql_query($requete2) or die(mysql_error());
			$data2 = mysql_fetch_array($result2);
			mysql_free_result($data2);
			mysql_close();
			
			echo 'ok';
		}
	}
	else if ($data[count] == 0) {
		echo 'nok';
	}
}
//verifiation pseudo
else if(isset($_POST['pseudo']) && !isset($_POST['password']) && !isset($_POST['email'])){
	
	$requete = 'SELECT count(*) AS count
	FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string(trim($_POST['pseudo'])).'"';
	
	$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
	$db=mysql_select_db($base,$connexion) or die (mysql_error());
	$result = mysql_query($requete) or die(mysql_error());
	$data = mysql_fetch_array($result);
	mysql_free_result($data);
	mysql_close();
	
	if ($data['count'] >= 1) {
		//$json['pseudo'] = "exist";
		echo "exist";
	}
	else if ($data['count'] == 0) {
		//$json['pseudo'] = "notexist";
		echo "notexist";
	}


}
//inscription
else if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){
	$cle = md5(microtime(TRUE)*100000);
	
	$resultMail = email($_POST['email'],$_POST['pseudo'],$cle);
	//if($resultMail == 'Message sent!'){
	
		$requete = "INSERT INTO 2015_membre VALUES ('','".$_POST['pseudo']."','".$_POST['password']."','".$_POST['email']."','".$resultMail."',NOW(),NOW(),NOW(),'".$cle."')";
		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
		$result = mysql_query($requete);
	
		if($result){
			echo "ok";
		}
		else{
			echo "nok";
		}
	
	//}
	//else{
	//	echo "nok";
//	}
	
	mysql_free_result($req);
	mysql_close();

}



function testAuthentification(){
	if(isset($_SESSION['pseudo'])){
		return true;
	}
	else{
		return false;
	}
}



function getGroupe(){
	global $host,$user,$pass,$base;
	
	
	if($_SESSION['pseudo']){
		$requete = 'SELECT m.groupe AS groupe
		FROM 2015_membre AS m WHERE pseudo="'.mysql_escape_string(trim($_SESSION['pseudo'])).'"';
	
		$connexion= mysql_connect($host,$user,$pass) or die ("connexion au serveur impossible");
		$db=mysql_select_db($base,$connexion) or die (mysql_error());
		$result = mysql_query($requete) or die(mysql_error());
		$data = mysql_fetch_array($result);
		mysql_free_result($data);
		mysql_close();
		
		return $data['groupe'];
	}
	else{
		return "";
	}
}


function email($email_destinataire,$log,$key){
$message = '
   <html>
   <head>
   <title>ES Html Report</title>
   </head>
   <body>
    <table>
    <tr>
      <th>Project Name</th>
      <th>TODo</th>
      <th>Priority</th>
      <th>Due on</th>
      <th>Assignee</th>
      <th>Created</th>
      <th>Updated</th>
      <th>Completed</th>
      <th>Assignee Status</th>
     <th>Status</th>
     </tr>

     <tr>
        <td>'.$todolists_store_row['Projects_name'].'</td>
        <td>'.$todolists_store_row['Name'].' </td>
        <td>'.$todolists_store_row['priority'].'</td>
        <td>'.$todolists_store_row['Due_on'].'</td>
        <td>'.$todolists_store_row['assignee_name'].'</td>
         <td>'.$todolists_store_row['Created_at'].'</td>
        <td>'.$todolists_store_row['Modified_at'].'</td>
        <td>'.$todolists_store_row['Completed_at'].'</td>
         <td>'.$todolists_store_row['Assignee_status'].'</td>
         <td>'.$status.'</td>
    </tr>
  </table>
</body>
  </html>
    ';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom('from@example.com', 'First Last');
//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($email_destinataire, 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer mail() test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->IsHTML(true);
$mail->Body = preg_replace('/\[\]/','',$message);
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    return "Mailer Error: " . $mail->ErrorInfo;
} else {
    return "Message sent!";
}


}


?>