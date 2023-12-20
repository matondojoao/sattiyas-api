<h1 align="justify">
Essence Shop API
</h1>

<p align="justify">
Built on Laravel, Essence Shop API empowers your e-commerce platform with essential modules such as Products, Categories, Product Images, and Authentication.

**Authentication:** Essence Shop utilizes Sanctum for secure authentication. For testing in Postman, refer to the [API Documentation](https://laravel.com/docs/9.x/sanctum#main-content) on how to authenticate using Sanctum.

**Payments:** Essence Shop integrates with Stripe for processing payments. Check out the [Stripe PHP GitHub repository](https://github.com/stripe/stripe-php) for more details on payment processing with Stripe.

**Caching:** Essence Shop employs Redis for caching to enhance performance and scalability.

---

### Modules

#### Auth
- Manages user authentication, including login, registration, and logout.

#### ResetPassword
- Handles password reset functionality, including sending reset links and resetting passwords.

#### Profile
- Manages customer profiles.

#### Wishlist
- Allows users to add and remove items from their wishlist.

#### Order
- Manages customer orders, including placing orders and retrieving order history.

#### Review
- Manages product reviews submitted by users.

### Public Access

#### Product
- Provides public access to product information.

#### Category
- Offers public access to product categories.

#### Cart
- Manages the user's shopping cart, including adding and removing items..

#### Coupon
- Manages the application of coupons by users.

#### Delivery Option
- Provides information about available delivery options.

#### Payment Method
- Provides information about available payment methods.

###  Admin Operations

#### Admin Category
- Admin functionality for creating, updating, and deleting product categories.

#### Admin Order
- Admin functionality for viewing, updating, and deleting orders.
- Generates sales reports.

#### Admin Delivery Option
- Admin functionality for managing delivery options.

#### Admin Payment Method
- Admin functionality for managing payment methods.

#### Admin Product
- Admin functionality for managing products, including creation, update, and deletion.

#### Admin Customer
- Admin functionality for managing customer information.
- Generates customers reports.

#### Stock
- Admin functionality for managing product stocks.

#### Admin Coupon
- Admin functionality for managing coupons.

#### Reports
- AAccess to various reports, including sales reports and customer reports.
---

### Technologies Used

- Laravel: A powerful PHP framework for building robust web applications.
- MySQL: A reliable relational database for data storage.
- Laravel Sanctum: For API authentication.
- Redis: In-memory data structure store for caching.

### Getting Started

1. Clone the repository: `git clone https://github.com/yourusername/laraedu-api.git`
2. Install dependencies: `composer install`
3. Set up your database and update the `.env` file.
4. Run migrations: `php artisan migrate`
5. Start the development server: `php artisan serve`

For detailed API documentation, visit <a href="https://documenter.getpostman.com/view/23770036/2s9YeK4AVb" target="_blank">API Documentation</a>.


---

### Contributors

- [Matondo João](https://github.com/matondojoao)

Feel free to contribute and make E-Learning Platform API even better!
</p>
