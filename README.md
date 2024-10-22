
# Hotel Room Reservation System

This project is a demonstration of a hotel room reservation system built using Laravel and modern web technologies. It showcases a user-friendly interface for searching and booking hotel rooms.




## Technologies Used

  - **Laravel**: A PHP framework used for building the backend and handling routing, models, and controllers.
  - **Tailwind CSS**: A utility-first CSS framework used for styling the frontend.
  - **Swiper.js**: A modern slider library used to create a responsive image slider for displaying room photos.
  - **JavaScript**: Used for dynamic interactions, such as calculating total reservation costs based on user input.

## Features

  - **Room Search and Filtering**: Users can search for available rooms based on check-in and check-out dates, number of guests, and price range.
  - **Room Details Page**: Displays detailed information about each room, including a description, price per person per night, and maximum capacity.
  - **Dynamic Pricing Calculation**: Calculates the total cost of the reservation dynamically based on the selected dates and number of guests.
  - **Reservation Form**: Allows users to enter their details and book a room. Includes fields for guest name, email, check-in and check-out dates, and the number of guests.
  - **Responsive Design**: Ensures that the application is accessible and usable on various devices, including desktops, tablets, and smartphones.
  - **Multi-Language Support**: The application supports multiple languages, currently including English and Polish. Users can switch between languages for a localized experience.
  - **Dark/Light Mode**: Implements a toggle for dark and light mode, allowing users to choose their preferred color scheme for better readability and user experience.
  - **Email Confirmation**: Sends an email confirmation upon successful reservation with details and a unique cancellation code.
  - **Reservation Cancellation**: Provides a link in the confirmation email to cancel reservations up to 48 hours before check-in using a unique cancellation code.
  - **Dynamic Price Filtering**:  Allows users to sort room search results by ascending or descending price order dynamically.


## Installation

Clone the repository:

```bash
git clone https://github.com/yourusername/hotel-reservation.git
cd hotel-reservation
```
Install dependencies:
```bash
composer install
npm install
```

Set up environment variables:
Copy .env.example to .env and configure your database settings.

Run migrations and seeders:
```bash
php artisan migrate --seed
```
Start the development server:
```bash
php artisan serve

```
    
## Usage

- Visit http://localhost:8000 in your browser to access the application.
- Use the search form on the homepage to find available rooms.
- Click on a room to view details and make a reservation.





## Screenshots
![](https://i.ibb.co/rbt890R/obraz-2024-10-21-133134126.png)

![](https://i.ibb.co/DtkJpvQ/obraz-2024-10-22-174618572.png)

![](https://i.ibb.co/RybhBFY/obraz-2024-10-20-213731649.png)

![](https://i.ibb.co/WtTPq5X/obraz-2024-10-20-213821779.png)

![](https://i.ibb.co/LP1WF2s/obraz-2024-10-21-154918889.png)


## Contributing
Contributions are welcome! Please fork this repository and submit pull requests for any features or improvements you would like to add.

## License

This project is open-source and available under the [MIT](https://choosealicense.com/licenses/mit/) License. This README provides an overview of the project, its features, installation instructions, and usage guidelines. Adjust any paths or URLs as needed for your specific repository setup.