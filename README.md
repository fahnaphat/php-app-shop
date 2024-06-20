## Demo: Online shopping web application
This web application is developed using PHP and MySQL. You can try it out using the provided Docker container.

## Installation
 1. Clone the repository:
```sh 
  git clone https://github.com/fahnaphat/php-app-shop.git 
  ```
  
 2. Build and run the Docker container:
```sh 
  docker-compose up --build 
  ```
  
 3. Open your web browser and navigate to `http://localhost:8001` to access the phpmyadmin.

| service | username | password |
|--|--|--|
| phpmyadmin | phpmyadmin | mypassword |

 4. Import the SQL file into the mydbshop database.
> [!NOTE]
> Import the attached `mydbshop.sql` file in this repository.

## Usage

 The application should be up and running on `http://localhost:8083/home.php`.
 - you can log in as an Administrator using:
	 - username: `admin`
	 - password: `Admin@1234`
> As an administrator, you will be able to add, edit, and delete products.

 - you can log in as a Customer using:
	 - username: `Peter`
	 - password: `Pete@007`
> As a customer, you will be able to add products to the cart and view the items in the cart.
