# MySQL Table Data Manager (PHP/Web GUI)

This project provides a simple web-based graphical user interface (GUI) to view, update, and delete data within a MySQL database table. It's built using PHP and designed for easy deployment within a local development environment like XAMPP.

## Features

* **View Data:** Browse the contents of a specified MySQL table.
* **Update Data:** Modify existing records within the table.
* **Delete Data:** Remove records from the table.
* **Web-Based GUI:** Interact with your data through a user-friendly web interface.
* **PHP Backend:** Logic is handled by PHP scripts.

## Requirements

* **Web Server:** Apache (included in XAMPP)
* **PHP:** Version 7.0 or higher (included in XAMPP)
* **MySQL Database:** A MySQL database instance
* **Git:** For cloning the repository

## Installation

1. **Clone the repository:**

    For Windows:
    ```bash
    cd c:\xampp\htdocs\
    ```
    For Linux:
    ```bash
    cd /opt/lampp/
    ```
   Clone this repository: 
   ```bash
   git clone https://github.com/akarshit-1609/Show_and_Edit_MySql_Data_on_Browser_with_PHP_code.git
   ```

## Usage

* Configure MySql Authentication:

    **In ./sql/connect.php**
    ```bash
    $server_mysql = "Your hostname";
    $username_mysql = "Your username";
    $password_mysql = "Your password";
    ```
    **In the Web Browser:**

    type url:
    ```url
    http://localhost/<repository_name>/
    ```
    Hence now you can use.