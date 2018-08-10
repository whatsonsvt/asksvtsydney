<?php 
 
$method = $_SERVER['REQUEST_METHOD'];
 
// Process only when method is POST
if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);
 
    // Get All Parameters values
	$actionName = $json->result->action;
	if ( strcasecmp( $actionName, 'Feedback' ) !== 0 ){
	$name =  $json->result->parameters->Name;
	$number = $json->result->parameters->Number;
	$message = $json->result->parameters->Message;
	$emailAddress = $json->result->parameters->EmailAddress;
	$combinedInput = "Name=".urlencode($name)."&Message=".urlencode($message)."&ContactNumber=".urlencode($number)."&EmailAddress=".urlencode($emailAddress);
	}
 
    switch ($actionName) {
	    case 'Option1ForPriest':
		    $url = "https://script.google.com/macros/s/AKfycbzSENsORHDhS-qsT1wobnIoYqULjeHyrfDr24FU9kWSKQXTaw/exec?$combinedInput";		
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
			$speech = "Thank you for your input. Your submitted information has been sent to our priest and our priest will contact you soon. The information which you provided are Your Name: $name, Contact Number : $number Message: $message  Email Address : $emailAddress Do you have any question to ask? Please ask me now or say bye bye";
			}
            else {
			$speech = "I'm sorry and can n't save your details. Could you please try by typing 1 again? Thank you.";
			}
            break;
        case 'Option2ForCanteenManager':
			$url = "https://script.google.com/macros/s/AKfycbwM5_AcBG80IJv8hZ_bMilZBELO8dUKNV-E2T8KubHps3rBcQ/exec?$combinedInput";		
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
			$speech = "Thank you for your input. Your submitted information has been sent to our canteen manager and our canteen manager will contact you soon. The information which you provided are Your Name: $name, Contact Number : $number Message: $message Email Address : $emailAddress Do you have any question to ask? Please ask me now or say bye bye.";
			}
			else {
			$speech = "I'm sorry and can n't save your details. Could you please try by typing 2 again? Thank you.";
			}
			break;
 
        case 'Option3ForFunctions':
		    $url = "https://script.google.com/macros/s/AKfycbxZcCggVEX6sW7wUPNTAPcwpKCdE4P4_IGtL4XjUbfS4Dak5w/exec?$combinedInput";
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
            $speech = "Thank you. Your information has been sent to our function manager and our function manager will contact you soon. The information which you provided are Your Name: $Name, Contact Number : $Number Message: $Message Email Address : $emailAddress  Do you have any question to ask? Please ask me now or say bye bye.";
			}
			else {
			$speech = "I'm sorry and can n't save your details. Could you please try by typing 3 again? Thank you.";
			}
            break;
		case 'Feedback':
		    $message = $json->result->parameters->$Message;
			$messageWithEncode = urlencode($message);
			$url = "https://script.google.com/macros/s/AKfycbxr0YnNZbNx-fazOXAU1MR3D-AKveizGE4iLFUJ33LYckiDCg/exec?Message=$messageWithEncode";
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
            $speech = "Thanks for your feedback/thoughts. Your feedback has been sucessfully received. The information which you provided is your Feedback/thoughts : $message. Do you have any question to ask? Please ask me now or say bye bye.";
			}
			else {
			$speech = "I'm sorry and can n't save your feedback/thoughts details. Could you please try by typing feedback again? Thank you.";
			}
            break;
         
        default:
            $speech = "I'm Sorry, I didn't get that. Please ask me something else.";
            break;
    }
 
    $response = new \stdClass();
    $response->speech = $speech;
    $response->displayText = $speech;
    $response->source = "webhook";
    echo json_encode($response);
}
else
{
    echo "Permission denied";
}
 
?>