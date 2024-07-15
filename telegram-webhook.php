<?php

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Start building the HTML response for a GET request
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>Telegram Webhook</title>';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';
    echo '<style>body { background-color: white; color: #119af5; }</style>';
    echo '</head>';
    echo '<body>';
    echo '<center><i class="fab fa-telegram" style="font-size:148px; color: #119af5;"></i></center>';
    echo '</body>';
    echo '</html>';

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request method is POST
    
    // Add your bot token here
    $bot_token = 'xxx';

    // Add your admin chat ID here
    $admin_chat_id = 'xxx';
    $chat_id = $admin_chat_id;

    // Decode the JSON input from the request
    $inputData = json_decode(file_get_contents('php://input'), true);
    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Start output buffering
    ob_start();

    // Uncomment for debugging: dump the input data
    // var_dump($inputData);
    
    // Echo the user ID and first name from the incoming message
    echo '@id '.$inputData['message']['from']['id'] ."\n";
    echo 'Hello '.$inputData['message']['from']['first_name'] ."\n";

    // Get the contents of the output buffer
    $text = ob_get_clean();

    // Check if the incoming message text is '/privacy'
    if ($inputData['message']['text'] == '/privacy')
    {
        // Set a custom response for the '/privacy' command
        $text = 'This is nothing else than a 1to1 chat with the admin';
        // Change the chat ID to the sender's ID
        $chat_id = $inputData['message']['from']['id'];
    }
    
    // Check if the message text contains '@id '
    if (strpos($inputData['message']['text'], '@id ') !== false)
    {
        // Split the message by lines
        $exploded_message = explode("\n", $inputData['message']['text']);
        // Get the first line and split by spaces
        $first_line = explode(" ", $exploded_message[0]);
        // Set the chat ID from the first line
        $chat_id = $first_line[1];
        // Remove the first line from the array
        unset($exploded_message[0]);
        // Reassemble the message text
        $text = implode("\n", $exploded_message);
    }

    // Prepare to send a message to the chat
    $url = "https://api.telegram.org/bot".$bot_token."/sendMessage";
    $data = [
        'chat_id' =>  $chat_id,
        'text' => $text,
    ];

    // Set up the HTTP context options for the POST request
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    // Create the context for the HTTP request
    $context  = stream_context_create($options);
    // Send the request and get the result
    $result = file_get_contents($url, false, $context);

    // Check if the sender's ID exists
    if ($inputData['message']['from']['id']) {
        // Prepare to forward the message to the admin
        $url = "https://api.telegram.org/bot" . $bot_token . "/forwardMessage";
        $data = [
            'chat_id' => $admin_chat_id,
            'from_chat_id' => $inputData['message']['from']['id'],
            'message_id' => $inputData['message']['message_id'],
        ];

        // Set up the HTTP context options for the POST request
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        // Create the context for the HTTP request
        $context = stream_context_create($options);
        // Send the request and get the result
        $result = file_get_contents($url, false, $context);
    }
}
?>
