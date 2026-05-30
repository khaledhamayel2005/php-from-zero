# CRUD Operations

Simple PHP CRUD app for the `users` table.

## Database

Use your local MySQL database settings from `config.php`.

Expected table:

```sql
CREATE TABLE users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	fname VARCHAR(100) NOT NULL,
	lname VARCHAR(100) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Files

- `index.php` shows all users.
- `add.php` inserts a new user.
- `edit.php` updates an existing user.
- `delete.php` removes a user.
- `config.php` stores database connection settings.
- `style.css` styles the pages.

## Run

Open the folder in your local server and start from `index.php`.
# CRUD Operations

This project is for learning how to create, read, update, and delete records with PHP and MySQL.

## Planned Files

- `index.php` - shows the table and action buttons.
- `add.php` - shows the add form and handles new records.
- `edit.php` - loads an existing record into a form.
- `delete.php` - removes a record by id.
- `config.php` - stores the database connection.
- `style.css` - styles the CRUD layout.

## File Notes

- Start each file with a short English comment explaining what it does.
- Keep SQL queries inside prepared statements.
