Here’s a **`README.md`** file for your Multi-User Management System project:

---

# Multi-User Management System

This is a multi-user management system built using PHP (OOP), MVC architecture, and JWT for API-based authentication. The system supports role-based access control with two roles: `Admin` and `User`. The project demonstrates the implementation of modern backend development techniques including middleware, routing, and token-based authentication.

---

## Features

### Core Features:
1. **User Authentication (API & Web):**
   - Register a new user.
   - Login to obtain a JWT token for API authentication.
   - Logout with token invalidation.

2. **Role-Based Access Control:**
   - **Admin**:
     - Access to the `User List`.
     - Edit and delete user accounts.
   - **User**:
     - Access to the `Dashboard` to view profile details.

3. **API Endpoints:**
   - `POST /api/login`: Authenticate a user and retrieve a JWT token.
   - `POST /api/register`: Register a new user.
   - `GET /api/user-details`: Get the details of the authenticated user.
   - `GET /api/user-list`: Get a list of users (Admin only).
   - `PUT /api/edit-user?id={id}`: Edit user details (Admin only).
   - `DELETE /api/delete-user?id={id}`: Delete a user (Admin only).

4. **Middleware Support:**
   - **AuthMiddleware**: Validates if the user is authenticated.
   - **AuthAdminRoleMiddleware**: Checks if the user has sufficient permissions. Role Middleware
   - **GuestMiddleware**: Prevents authenticated users from accessing certain routes.
   - **ApiAuthMiddleware**: Validates API requests using JWT tokens.

5. **JWT Authentication:**
   - Secure token-based authentication with expiry and logout invalidation.

6. **Dynamic Routing:**
   - MVC-based routing system with flexible URL parameters.

7. **Responsive Web Views:**
   - User-friendly login, registration, and dashboard pages for web.

---

## Project Structure

```
/app
    /controllers       # Controllers for handling requests
    /core              # Core files (routing, base classes, etc.)
    /middleware        # Middleware classes for request filtering
    /models            # Models for database interaction
    /utils             # Utility classes (e.g., JWT handling)
    /views             # HTML templates for web views
/config
    config.php         # Database and global configuration

index.php          # Entry point for the application And SetUp IN Root Directory 
```

---

## Requirements

- PHP >= 7.4
- MySQL >= 5.7
- Composer
- Postman (for API testing)

---

## Setup Instructions

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/rahulv202/Multi-User-Management-System
   cd Multi-User-Management-System
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   ```
    ```bash
   composer init
   ```
    ```bash
   composer dump-autoload
   ```
   ```bash
   composer require firebase/php-jwt
   ```
Recommendations for Secret Key Management
Use Strong Keys: Generate a strong, random secret key. 
 ```bash
   openssl rand -base64 32
   ```


1. **Configure Environment:**
   - Update `config/config.php` with your database credentials.

2. **Database Migration:**
   - Database Name: `authdb`
   - Import the `users.sql` file into your MySQL database.

3. **Start the Server:**
   ```bash
   php -S localhost:8000 -t public
   ```
OR
Development Server (http://localhost:8000) started on port 8000
```bash
   php -S localhost:8000
   ```
1. **Test the System:**
   - Access the web interface at `http://localhost:8000/`.
   - Use Postman to test API endpoints.

---

## API Documentation

### **Endpoints**
#### Authentication
- `POST /api/register`
  - **Request Body**:
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password123"
    }
    ```
  - **Response**:
    ```json
    {
        "message": "Registration successful"
    }
    ```

- `POST /api/login`
  - **Request Body**:
    ```json
    {
        "email": "john@example.com",
        "password": "password123"
    }
    ```
  - **Response**:
    ```json
    {
        "token": "your.jwt.token"
    }
    ```

#### User Operations
- `GET /api/user-details`
  - **Headers**:
    ```
    Authorization: Bearer {token}
    ```
  - **Response**:
    ```json
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "user"
    }
    ```

- `GET /api/user-list` (Admin Only)
  - **Headers**:
    ```
    Authorization: Bearer {token}
    ```
  - **Response**:
    ```json
    [
        {
            "id": 1,
            "name": "Admin",
            "email": "admin@example.com",
            "role": "admin"
        },
        {
            "id": 2,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "user"
        }
    ]
    ```

#### Admin Operations
- `PUT /api/edit-user?id=2` (Admin Only)
  - **Request Body**:
    ```json
    {
        "name": "Jane Doe",
        "email": "jane@example.com"
    }
    ```

- `DELETE /api/delete-user?id=2` (Admin Only)
  - **Headers**:
    ```
    Authorization: Bearer {token}
    ```
  - **Response**:
    ```json
    {
        "message": "User deleted successfully."
    }
    ```


---
## Troubleshooting

1. **"404 Not Found" Errors**:
   - Ensure `.htaccess` is properly configured for URL rewriting.

2. **Database Connection Issues**:
   - Verify credentials in `config/config.php`.



---

## License

This project is open-source and available under the [MIT License](LICENSE).

---
