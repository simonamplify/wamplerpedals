<?php
/**
 * Check to see if all fields that are required have been submitted
 *
 * @return boolean
 */
function isValid(){
    if(
        $_POST['recaptchaResponse'] != '' &&
        $_POST['email'] != ''
    ) {
        return true;
    }
    return false;
}

// Declare variables to prepare for form submission
$success_output = '';
$error_output = '';

if (isValid()) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; // URL to the reCAPTCHA server
    $recaptcha_secret = '6Ldo_N4UAAAAACZpDuv6uGB_q2jPXObAFgwSd01Z'; // Secret key
    $recaptcha_response = $_POST['recaptchaResponse']; // Response from reCAPTCHA server, added to the form during processing
    $recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response); // Send request to the server
    $recaptcha_decoded = json_decode($recaptcha); // Decode the JSON response
    if ($recaptcha_decoded->success == true && $recaptcha_decoded->score >= 0.5 && $recaptcha_decoded->action == "getresponse"){ // If the response is valid
        $success_output = 'Human check complete. Submitting...'; // Success message
    } else {
        $error_output = 'Something went wrong. Please refresh the page and try again.'; // Error message
    }
} else {
    $error_output = 'Something went wrong. Please refresh the page and try again.'; // Error message
}
// Output error or success message
$output = [
    'error' => $error_output,
    'success' => $success_output
];

// Return the output in JSON format
echo json_encode($output);