<?php

// =============================================
// CONFIGURATIONS
// =============================================

// Headers
// you can add more than one email address
$to_email_addresses       = array( 'david.rozando+dummy@gmail.com' => 'EOS Contact Form Test' );
$cc_email_addresses       = array( 'david.rozando+dummy@gmail.com' => 'EOS Contact Form Test' );
$bcc_email_addresses      = array( 'david.rozando+dummy@gmail.com' => 'EOS Contact Form Test' );
$reply_to_email_addresses = array( 'david.rozando+dummy@gmail.com' => 'EOS Contact Form Test' );

// Body
$subject_prefix = '';

// SMTP
// SMTP is not supported. Please contact me to get specific helps.
// $is_smtp = false;

// Validation messages
$error_messages  = array(
	'name'    => 'Please enter your name.',
	'email'   => 'Please enter your email address correctly.',
	'subject' => 'Subject is required.',
	'message' => 'Message is required.',
	'else'    => 'An error occured.',
);
$success_message  = 'Email sent successfully!';

// =============================================
// BEGIN SEND EMAIL PROCESS
// =============================================

// Form's values
$name = isset( $_REQUEST['name'] ) ? $_REQUEST['name'] : '';
$email = isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : '';
$subject = isset( $_REQUEST['subject'] ) ? $_REQUEST['subject'] : '';
$message = isset( $_REQUEST['message'] ) ? $_REQUEST['message'] : '';

// Validation
$errors = array();
if ( empty( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) $errors[] = $error_messages['email'];
if ( empty( $name ) ) $errors[] = $error_messages['name'];
if ( empty( $subject ) ) $errors[] = $error_messages['subject'];
if ( empty( $message ) ) $errors[] = $error_messages['message'];

if ( count( $errors ) ) {
	$result['status'] = 'error';
	$result['message'] = implode( '<br />', $errors );

	// Send output
	if ( ! empty( $_REQUEST[ 'ajax' ] ) ) {
		// called via AJAX
		echo json_encode( $result );
	} else {
		// no AJAX
		echo 'Error: ' . '<br />' . $result['message'];
	}

	return;
}

// Initiate PHPMailer
require_once( 'class.phpmailer.php' );
$mail = new PHPMailer();

// headers
$mail->From = $email;
$mail->FromName = $name;
foreach ( $to_email_addresses as $e => $n ) $mail->addAddress( $e, $n );
foreach ( $cc_email_addresses as $e => $n ) $mail->addCC( $e, $n );
foreach ( $bcc_email_addresses as $e => $n ) $mail->addBCC( $e, $n );
foreach ( $reply_to_email_addresses as $e => $n ) $mail->addReplyTo( $e, $n );

// body
$mail->Subject = $subject_prefix . $subject;
$mail->Body    = $message;

// send
if ( ! $mail->send() ) {
	$result['status'] = 'error';
	$result['message'] = $error_messages['else'];
} else {
	$result['status'] = 'success';
	$result['message'] = $success_message;
}

// Send output
if ( ! empty( $_REQUEST[ 'ajax' ] ) ) {
	// called via AJAX
	echo json_encode( $result );
} else {
	// no AJAX
	if ( $result['status'] == 'error' ) {
		echo 'Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Success';
	}
}