<? // Set the requirements for the newsletter email 
$name = $_REQUEST[ 'name' ];
$submittedEmail = $_REQUEST[ 'email' ];
$phone = $_REQUEST[ 'phone' ];
$address = $_REQUEST['address'];
$comments = $_REQUEST[ 'comments' ];
$url = $_POST[ 'url' ]; 
$sendTo = 'danielmadelatodesign@gmail.com';
// support@mervair.com


$botCheckBox = $_REQUEST[ 'contact_me_by_electronic_mail_but_not_really' ];

// email validation
// Remove all illegal characters from email
$email = filter_var($submittedEmail, FILTER_SANITIZE_EMAIL);

// Validate e-mail
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "";
} else {
    $error = '"<strong>'.$email.'</strong>" is not a valid email address';
}
//email validation

//domain validation
$domain = substr($email, strpos($email, '@') + 1);
if  (checkdnsrr($domain) == FALSE) {
    $error = 'The email address provided seems to be from an invalid domain. ';
}

	  $message = "A Contact Form has been filled out with the following information: \n \n" . 
	"Name: " . $name . "\n" .
	"Email: " . $email . "\n" .
	"Phone: " . $phone . "\n" .
	"Address: " . $address . "\n" .
	"Comments: " . $comments
	 ;
 
	if (!$name || !$email || !$comments || $error !== "") {
		   header( "Location: $url?message=error&error=$error" );
	} else {
		
		
	$subject = "Property Form Submission";	

		
	  mail( $sendTo, $subject,
		$message, "From: $email" );
		header( "Location: $url?message=success" );

	  }
?>