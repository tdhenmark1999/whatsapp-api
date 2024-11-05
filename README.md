# WhatsApp API Clone

A simple WhatsApp-like API built with Laravel to support chatroom functionalities, message sending, and user authentication using Laravel Sanctum and WebSockets.

---

## Setup and Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/whatsapp-api-clone.git
   ```
2. Navigate to the project directory:
   ```bash
   cd whatsapp-api-clone
   ```
3. Install dependencies using Composer:
   ```bash
   composer install
   ```
4. Copy the `.env.example` file to `.env` and configure your environment variables.
5. Generate an application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations to set up the database:
   ```bash
   php artisan migrate
   ```
7. Install Laravel Sanctum and set up WebSockets if required.

---

## Chatroom Endpoints

### 1. Create Chatroom
- **URL**: `POST /api/chatrooms`
- **Headers**:
  - `Authorization`: `Bearer <your_token>`
  - `Content-Type`: `application/json`
- **Body**:
  ```json
  {
    "name": "General Chatroom"
  }
  ```
- **Response**:
  - **201 Created**: Chatroom created successfully.
  - **422 Unprocessable Entity**: Validation error.
  - **500 Internal Server Error**: Failed to create chatroom.

### 2. List Chatrooms
- **URL**: `GET /api/chatrooms`
- **Headers**:
  - `Authorization`: `Bearer <your_token>`
- **Response**:
  - **200 OK**: List of chatrooms.
  - **500 Internal Server Error**: Failed to retrieve chatrooms.

### 3. Enter Chatroom
- **URL**: `POST /api/chatrooms/{id}/enter`
- **Headers**:
  - `Authorization`: `Bearer <your_token>`
- **Response**:
  - **200 OK**: Entered chatroom successfully.
  - **404 Not Found**: Chatroom not found.
  - **500 Internal Server Error**: Failed to enter chatroom.

### 4. Leave Chatroom
- **URL**: `POST /api/chatrooms/{id}/leave`
- **Headers**:
  - `Authorization`: `Bearer <your_token>`
- **Response**:
  - **200 OK**: Left chatroom successfully.
  - **404 Not Found**: Chatroom not found.
  - **500 Internal Server Error**: Failed to leave chatroom.

---

## Message Endpoints

### 1. Send Message
- **URL**: `POST /api/chatrooms/{id}/messages`
- **Headers**:
  - `Authorization`: `Bearer <your_token>`
  - `Content-Type`: `application/json`
- **Body**:
  ```json
  {
    "content": "Hello, this is a test message!",
    "attachment": "file_path" // Optional
  }
  ```
- **Response**:
  - **201 Created**: Message sent successfully.
  - **404 Not Found**: Chatroom not found.
  - **422 Unprocessable Entity**: Validation error.
  - **500 Internal Server Error**: Failed to send message.

### 2. List Messages
- **URL**: `GET /api/chatrooms/{id}/messages`
- **Headers**:
  - `Authorization`: `Bearer <your_token>`
- **Response**:
  - **200 OK**: List of messages.
  - **404 Not Found**: Chatroom not found.
  - **500 Internal Server Error**: Failed to retrieve messages.

---

## Authentication

All routes are protected by `auth:sanctum` middleware and require a valid Bearer token.

1. **Login Endpoint**: Use your application's login route to get an authentication token.
2. **Include the Token in Headers**:
   ```text
   Authorization: Bearer <your_token>
   ```

---

## File Uploads

Attachments are stored in the `attachments` directory. Ensure that your storage folder is properly configured.

---

## Error Handling

1. **Validation Errors**: Returns `422 Unprocessable Entity` with details of the failed validations.
2. **Not Found Errors**: Returns `404 Not Found` when a resource does not exist.
3. **Server Errors**: Returns `500 Internal Server Error` for unexpected issues.

---

## Notes

1. **Database Configuration**: Configure your database settings in the `.env` file.
2. **WebSockets**: Set up WebSockets for real-time messaging using `beyondcode/laravel-websockets`.
3. **Future Enhancements**: Consider adding features like notifications, read receipts, and typing indicators.

