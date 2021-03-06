<?php 
 
$method = $_SERVER['REQUEST_METHOD'];
 
// Process only when method is POST
if($method == 'POST'){
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);
 
    // Get All Parameters values
	$actionName = $json->queryResult->action;
	$confirmMessage =  $json->queryResult->parameters->ConfirmMessage;
	if(strcasecmp( $confirmMessage, 'no' ) == 0 ){
	 switch ($actionName) {
		  case 'Option1ForPriest':
		        $reTypeWord = "1";
		        break;
		  case 'Option2ForCanteenManager':
		        $reTypeWord = "2";
		        break;
		  case 'Option3ForFunctions':
		        $reTypeWord = "3";
		        break;
		  case 'CollectFeedback':
		        $reTypeWord = "feedback";
		        break;
		 case 'PoojaBooking':
		        $reTypeWord = "booking pooja";
		        break;
		case 'QuickOrder':
		        $reTypeWord = "quick order";
		        break;
		  default:
		        break;
	 }
    $speech = "You says no to start again. Please type $reTypeWord to start again.";
	$response = new \stdClass();
    $response->speech = $speech;
    $response->displayText = $speech;
    $response->source = "webhook";
    echo json_encode($response);
	exit(0);
	}
	if(strcasecmp( $actionName, 'CollectFeedback' ) != 0 ){
	$name =  $json->queryResult->parameters->Name;
	$number = $json->queryResult->parameters->ContactNumber;
	$message = $json->queryResult->parameters->Message;
	$combinedInput = "Name=".urlencode($name)."&Message=".urlencode($message)."&ContactNumber=".urlencode($number);
	}
	
	if(strcasecmp( $actionName, 'PoojaBooking' ) == 0 ){
		$poojaName = $json->queryResult->parameters->PoojaName;
		$poojaBookingDate = $json->queryResult->parameters->PoojaBookingDate;
		$poojaBookingTime = $json->queryResult->parameters->PoojaBookingTime;
		$combinedInputForPoojaBooking = "PoojaName=".urlencode($poojaName)."&PoojaBookingDate=".urlencode($poojaBookingDate)."&PoojaBookingTime=".urlencode($poojaBookingTime)."&Name=".urlencode($name)."&Message=".urlencode($message)."&ContactNumber=".urlencode($number);
	}
	
	if(strcasecmp( $actionName, 'QuickOrder' ) == 0 ){
		$c1Items = $json->queryResult->parameters->C1Items;
		$c2Items = $json->queryResult->parameters->C2Items;
		$c3Items = $json->queryResult->parameters->C3Items;
		$c4Items = $json->queryResult->parameters->C4Items;
		$otherItems = $json->queryResult->parameters->OtherItems;
		$combinedInputForQuickOrder = "Name=".urlencode($name)."&C1Items=".urlencode($c1Items)."&C2Items=".urlencode($c2Items)."&C3Items=".urlencode($c3Items)."&C4Items=".urlencode($c4Items)."&OtherItems=".urlencode($otherItems);
	}
	
	
	
     switch ($actionName) {
	    case 'Option1ForPriest':
		    $url = "https://script.google.com/macros/s/AKfycbzSENsORHDhS-qsT1wobnIoYqULjeHyrfDr24FU9kWSKQXTaw/exec?$combinedInput";		
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
			$speech = "Thank you for your input. Your submitted information has been sent to our priest and our priest will contact you soon. The information which you provided are Your Name: $name, Contact Number : $number, Message: $message. Do you have any question to ask? Please ask me now or say bye bye.";
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
			$speech = "Thank you for your input. Your submitted information has been sent to our canteen manager and our canteen manager will contact you soon. The information which you provided are Your Name: $name, Contact Number : $number, Message: $message. Do you have any question to ask? Please ask me now or say bye bye.";
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
            $speech = "Thank you. Your information has been sent to our function manager and our function manager will contact you soon. The information which you provided are Your Name: $name, Contact Number : $number, Message: $message.  Do you have any question to ask? Please ask me now or say bye bye.";
			}
			else {
			$speech = "I'm sorry and can n't save your details. Could you please try by typing 3 again? Thank you.";
			}
            break;
		case 'CollectFeedback':
		    $message = $json->queryResult->parameters->Message;
			$messageWithEncode = urlencode($message);
			$url = "https://script.google.com/macros/s/AKfycbxr0YnNZbNx-fazOXAU1MR3D-AKveizGE4iLFUJ33LYckiDCg/exec?Message=$messageWithEncode";
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
            $speech = "Thanks for your feedback/thoughts. Your feedback has been sucessfully received. The information which you provided is your feedback/thoughts : $message. Do you have any question to ask? Please ask me now or say bye bye.";
			}
			else {
			$speech = "I'm sorry and can n't save your feedback/thoughts details. Could you please try by typing feedback again? Thank you.";
			}
            break;
			
		case 'PoojaBooking':
		   	$url = "https://script.google.com/macros/s/AKfycbwxIO9AGaVYJ72UmSZF8JKAfS_duiSdgHZQxaNaiwan8wzdBM4/exec?$combinedInputForPoojaBooking";
			$payLoad = file_get_contents($url);
			$pos = strpos($payLoad,"success");
			if($pos!==false) {
            $speech = "Thank you. Your information has been sent to our booking organizer and our booking organizer will contact you soon to confirm. The information which you provided are Your Pooja Name : $poojaName, Date : $poojaBookingDate, Time: $poojaBookingTime, Name: $name, Contact Number : $number, Message: $message. Do you have any question to ask? Please ask me now or say bye bye.";
			}
			else {
			$speech = "I'm sorry and can n't save your booking details. Could you please try by typing booking pooja again? Thank you.";
			}
            break;
			
		case 'QuickOrder':
		   	$url = "https://script.google.com/macros/s/AKfycbweXjNHSIitKiRg7mbp9SwVrEZkbX5LTtQRF1jEsFh2k4qc2A/exec?$combinedInputForQuickOrder";
			$payLoad = file_get_contents($url);
			$speech = "Thank you.". $payLoad . " Your order information has been sent to our ordering representative and our ordering representative will call you soon to confirm your order to process. Your ordering details are Name : $name, Items are  : $c1Items, $c2Items, $c3Items, $c4Items, $otherItems. Do you have any question to ask? Please ask me now or say bye bye.";
			break;
         
        default:
            $speech = "I'm Sorry, I didn't get that. Please ask me something else or type help to get more information.";
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