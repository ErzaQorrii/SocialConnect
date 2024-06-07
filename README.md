# Project Name: SocialConnect

## 1. Setting Up the Project

### Prerequisites

1. PHP ^8.1
2. Composer
3. MySQL

### Steps to Set Up the Project

**Steps to Set Up the Project**

1. Clone the Repository
    ```bash
    git clone https://github.com/yourusername/socialconnect.git
    cd server
    

2. Install Dependencies
    composer install
    

3. Set Up Environment Variables
    Edit the `.env` file to configure your database connection:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    

4. Generate Application Key
    
    php artisan key:generate
    

5. Run Migrations
  
    php artisan migrate
    

6. Run the Application
   
    php artisan serve
    

## 2. Authentication with Sanctum and CSRF Token

For authentication, we used Laravel Sanctum along with CSRF tokens to ensure secure and stateful authentication for the frontend SPA.

- **Laravel Sanctum**: Provides a simple way to authenticate Single Page Applications (SPAs) using cookie-based session authentication.
- **CSRF Tokens**: Protect against cross-site request forgery attacks by ensuring that each request comes from the authenticated user's browser.

The workflow involves:

1. **User Login**: The SPA sends login credentials to the backend.
2. **CSRF Token Fetch**: The SPA fetches a CSRF token before making state-changing requests.
3. **Authenticated Requests**: The SPA includes the CSRF token in the headers for state-changing requests.

This setup ensures that the user is authenticated securely, and all requests are verified to prevent unauthorized actions.

## 3. Documentation on ORM Implementation and Database Migrations with Laravel

### 1. Choosing an ORM

For our project SocialConnect, which is built with Laravel for server-side development, we have chosen to use Laravel Eloquent, the integrated ORM of Laravel. Eloquent allows us to interact with the database in a streamlined and efficient manner, provides full support for all features of MySQL, and integrates seamlessly with Laravel's architecture.

### 2. Integrating the ORM into the Project

The Laravel ORM, Eloquent, is automatically integrated when creating a Laravel application. We configured the database connection details in the project's `.env` file to ensure all ORM data is accurately connected to our MySQL database.

### 3. Implementing Database Migrations

To manage the database structure, we used Laravel's migrations. This was accomplished using Artisan commands that allow easy creation and execution of migrations:

- To create a new migration: `php artisan make:migration create_users_table`
- To run migrations: `php artisan migrate`

These commands help us maintain a history of database changes and revert changes if necessary.

## This image shows the database structure, tables and the relations between data tables.
![DDL Diagram](/images/db.png)


### 4. Eloquent Models

In the SocialConnect project, we have created a series of Eloquent models to represent the various entities within our application. Each model corresponds to a table in the MySQL database and is utilized to interact with the data within that table. The following are some of the primary models we have implemented thus far:

- `User`: Represents users of the application and handles data related to user accounts.
- `Post`: Manages posts made by users.
- `Comment`: Handles comments on posts.
- `Like`: Represents the likes made on posts or comments.
- `Photo`: Manages the photos uploaded by users.
- `Story`: Handles the stories shared by users.
- `Group`: Represents groups created within the application.
- `Friendship`: Manages the friendship relations between users.
- `Follower`: Represents the followers of a user.

These models are essential for the fundamental operations of SocialConnect and have methods to perform standard CRUD operations. They also define relationships to enable the retrieval of related data efficiently, such as a user's posts or the comments on a post.

As we continue to develop SocialConnect, we anticipate adding more models to our application to represent additional features and entities as needed. These future models will follow the same rigorous standards of efficiency and integration as the current ones.

### 5. Using the ORM in the Project

We utilized Eloquent to create, read, update, and delete data in our database. Eloquent models for each table were used to efficiently manipulate data using the CRUD operations provided by the ORM.

### 6. Testing with Swagger

To ensure that all endpoints function correctly and to provide a clear and interactive API documentation for our developers and users, we've utilized Swagger. Swagger offers an elegant solution to both test and document our API endpoints. With its interactive UI, we can easily perform HTTP requests to our API, review the responses, and quickly identify any issues.

To access the Swagger UI and test the endpoints, you can navigate to the `/api/documentation` route in your web browser once the application server is running. This interactive documentation allows for real-time testing of all the API's capabilities, including those that interact with the Eloquent models such as `User`, `Post`, `Comment`, etc.
