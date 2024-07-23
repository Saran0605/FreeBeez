<?php
// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if WhatsApp number and job ID are provided
    if (isset($_POST["whatsappNumber"]) && isset($_POST["jobId"])) {
        // Retrieve WhatsApp number and job ID from the POST data
        $whatsappNumber = $_POST["whatsappNumber"];
        $jobId = $_POST["jobId"];

        // Here you would implement the logic to send the WhatsApp message
        // For example, you can use a third-party API like Twilio or any other service
        // This is just a placeholder code
        // Replace this with your actual code to send the WhatsApp message

        // Example code (requires a valid Twilio account)
        // Replace 'TWILIO_ACCOUNT_SID', 'TWILIO_AUTH_TOKEN', and 'TWILIO_PHONE_NUMBER' with your Twilio credentials
        // Also, replace 'YOUR_WHATSAPP_NUMBER' with the recipient's WhatsApp number
        $twilio_sid = 'TWILIO_ACCOUNT_SID';
        $twilio_token = 'TWILIO_AUTH_TOKEN';
        $twilio_whatsapp_number = 'TWILIO_PHONE_NUMBER';
        $recipient_whatsapp_number = 'YOUR_WHATSAPP_NUMBER';
        
        // Your message content
        $message = "You have accepted the job with ID: $jobId. We will send you the details shortly.";

        // Initialize Twilio client
        $client = new Twilio\Rest\Client($twilio_sid, $twilio_token);

        // Send WhatsApp message
        $client->messages->create(
            "whatsapp:$recipient_whatsapp_number",
            array(
                'from' => "whatsapp:$twilio_whatsapp_number",
                'body' => $message
            )
        );

        // Return a success response
        echo json_encode(array("status" => "success", "message" => "WhatsApp message sent successfully"));
    } else {
        // Return an error response if WhatsApp number or job ID is missing
        echo json_encode(array("status" => "error", "message" => "WhatsApp number or job ID is missing"));
    }
} else {
    // Return an error response for invalid request method
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
