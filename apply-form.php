<?php 
$errors = '';
$myemail = 'info@nexgeninfra.com';//<-----Put Your email address here.
if(empty($_POST['name'])  || 
   empty($_POST['email']) ||
   empty($_FILES["fileToUpload"]["name"]))
{
    $errors .= "\n Error: all fields are required";
}

$name = $_POST['name']; 
$email_address = $_POST['email']; 
$target_dir = "uploadsResume/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$appliedrole = $_POST['AppliedRole'];
// Check if file already exists
if (file_exists($target_file)) {
    $errors .= "\n Error : Resume already exists in our system.";
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $errors .= "\n Error : File is too large. Allowed file size limit is 500KB.";
}
// Allow certain file formats
if($imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "txt"
&& $imageFileType != "pdf" ) {
    $errors .= "\n Error : Only DOC, DOCX, PDF & TXT files are allowed.";
}

if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
$email_address))
{
    $errors .= "\n Error: Invalid email address";
}

if( empty($errors))
{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {        
    } else {
        echo "Sorry, there was an error uploading your resume.";
    }

	$to = $myemail; 
	$email_subject = "Received resume form : $name . for career opportunity in : $appliedrole .";
	$email_body = "You have received a new Resume. ".
	" Here are the details:\n Name: $name \n Email: $email_address Resume Path : ". basename( $_FILES["fileToUpload"]["name"]) ; 
	
	$headers = "From: $myemail\n"; 
	$headers .= "Reply-To: $email_address";
	
	mail($to,$email_subject,$email_body,$headers);
	//redirect to the 'thank you' page
	//header('Location: contact-thank-you.html');
	echo "Your resume ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
} else {
	echo "Sorry, there was an error uploading your resume.". $errors;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Contact form handler</title>
</head>

<body>
<!-- This page is displayed only if there is some error -->
<?php
echo nl2br($errors);
?>


</body>
</html>