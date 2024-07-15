# telegram-webhook
a Telegram Webhook for a direct communications bot

you get everything forwarded. to reply to a user you should
write @id [chat_id] 

use your bot token and you chat id as admin.
then set webhook by get parameter in the browser


# Telegram Direct Communication Bot

This script implements a direct communication bot using the Telegram API. The bot handles incoming GET and POST requests and performs specific actions based on the type of request it receives.

## Handling GET Requests

When the bot receives a GET request, it responds by serving a simple HTML page. This page includes:

- Basic HTML structure with a head and body section.
- The head section contains meta information and links to external stylesheets for styling.
- The body section displays a centered Telegram icon using the Font Awesome library, styled with a specific color and size.

## Handling POST Requests

When the bot receives a POST request, it processes the incoming data, which is expected to be in JSON format. The script performs the following actions:

### Configuration

- The bot token and the admin chat ID are defined as variables (`$bot_token` and `$admin_chat_id`).

### Processing Incoming Data

- The script decodes the JSON payload received in the POST request to extract message details.
- It sets the response content type to JSON.

### Output Buffering

- The bot uses output buffering to capture and prepare a response message that includes the sender's ID and first name.

### Custom Commands

- If the incoming message text is `/privacy`, the bot responds with a predefined message and sets the chat ID to the sender's ID.
- If the message contains an `@id` command, the bot extracts the new chat ID from the message and adjusts the response text accordingly.

### Sending Messages

- The bot constructs a message and sends it back to the user or to a specific chat ID using the Telegram `sendMessage` API.

### Forwarding Messages

- If the sender's ID is not the admin's ID, the bot forwards the received message to the admin using the Telegram `forwardMessage` API.

## Key Features

- **Direct Communication:** The bot facilitates direct communication between users and the admin.
- **Custom Commands:** It handles specific commands like `/privacy` and `@id` to provide custom responses and change chat behavior.
- **Message Forwarding:** Automatically forwards messages from users to the admin for review.

Overall, this script provides a streamlined way to manage direct communications over Telegram, allowing the admin to interact with users efficiently and handle specific requests through custom commands.

