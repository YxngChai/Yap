# Yap

Yap is a full-stack social networking web application built from scratch with PHP, MySQL, HTML, CSS, and JavaScript.

The ongoing personal project was created as a practical web-development app to work with server-side PHP, MVC architecture, relational databases, authentication, CRUD operations, file uploads, AJAX, sessions, cybersecurity.


## Features

### Authentication & accounts
- User registration and login
- Session-based authentication
- Logout
- Password hashing
- Password update with current-password verification
- Account deletion with password confirmation
- CSRF token protection
- User profiles with:
  - Username
  - Name and surname
  - Birth date
  - Profile picture
  - Cover picture

### Posts
- Create posts
- Edit posts
- Delete posts
- Optional image attachments
- View individual posts
- User-specific post feeds
- Main feed ordered by newest posts
- Like/unlike posts
- Like and comment counts

### Comments
- Create comments
- Edit comments
- Delete comments
- Like/unlike comments
- Like counts

### Images & file uploads
- Profile pictures
- Cover pictures
- Post images
- Image removal
- Server-side file validation
- MIME-type detection
- Client-side image validation
- Maximum upload size
- Uploaded files are given randomized filenames
- User images and post images are removed when the associated account is deleted

### User interface
- Responsive interface
- Dialog for confirmation/modals
- AJAX interactions for actions such as post, likes and comments
- Form validation and feedback messages
- Anonymous/default profile and cover images

## Technologies

### Frontend
- HTML5
- CSS
- JavaScript
- AJAX / Fetch API
- ARIA/accessibility considerations

### Backend
- PHP
- MySQL
- PDO
- PHP sessions
- Password hashing
- CSRF protection

### Development tools
- XAMPP
- phpMyAdmin


### Models

Models contain database-related operations.

Database queries use PDO prepared statements rather than directly interpolating user input into SQL.

### Controllers

Controllers process requests and connect the models to the views.
The main entry point is:

```
public/index.php
```

It determines the HTTP method and requested route/action before dispatching the request to the appropriate controller.


### Database

Yap uses MySQL with PDO.

Posts and comments belong to users, while likes reference both a user and the item being liked.

The database structure can be exported from phpMyAdmin without exporting development data, allowing the schema to be version-controlled without exposing personal/test records.

## Security

Security is considered throughout the application, with implementation choices informed by common web-security practices and concepts covered by the OWASP Top 10.

Security measures currently implemented include:

- Password hashing using PHP's `password_hash()` and `password_verify()`
- CSRF protection for state-changing requests
- PDO prepared statements to mitigate SQL injection
- Server-side input validation
- Authentication and authorization checks
- Secure handling of uploaded files
- MIME-type validation using PHP `finfo`
- Randomized filenames for uploaded files
- Controlled file upload types and size limits
- Removal of sensitive password data from session/user data
- Validation of user-provided data before database operations

The project is a learning and portfolio application rather than a formally security-audited production system. Security practices are continuously being reviewed and improved as the application develops.


## AJAX

AJAX is used where a complete page reload would not be necessary.

Examples include:

- Liking/unliking posts and comments
- Creating/updating certain content
- Image-related actions
- Updating settings

## Account deletion

Deleting an account involves more than removing the row from `users`.

Before deleting the user, the application can identify associated uploaded images to prevents orphaned uploaded files from remaining on the server after an account is removed.


## Installation

### Requirements

- PHP
- MySQL
- Apache
- XAMPP or an equivalent PHP development environment

### 1. Clone the repository

Place the project inside your web server's document root.

For XAMPP on macOS, the project can be placed under:

```text
/Applications/XAMPP/xamppfiles/htdocs/
```

For example:

```text
/Applications/XAMPP/xamppfiles/htdocs/Yap/
```

### 2. Create the database

Import public/database/schema.sql into MySQL/phpMyAdmin.

The repository should contain the database schema without development/user content.

### 3. Configure the database

Update the database configuration in:

```text
src/config/db.php
```

with your local MySQL credentials.

### 4. Start the server

Start Apache and MySQL through XAMPP.

Then access the application through the local server, for example:

```text
http://localhost/yap/public/
```

## Development notes

Yap is a learning and portfolio project, so the codebase is intentionally being developed incrementally.

Some areas are still being improved, including:

- Further JavaScript organisation
- Additional validation
- UI/UX refinements
- Accessibility improvements
- More comprehensive automated testing
- Further separation of responsibilities between controllers, models, and views

## Future improvements

Possible future improvements include:

- Search bar for list of user
- Progressive load / Infinite scroll / "load more" feed
- Follow system
- Filter on feed to show only followed people post
- Side bar with list of followed account
- Improved accessibility
- Image optimization
- Improved routing
- Toggle to show password when typing 
- Option to automatically make a post when uploading new profile / cover picture
- Allow to make a picture with no text if it contains a valid image
- Delete profile and and cover picture to go back to default anonymous ones


