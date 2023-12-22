<h1 align="justify">
Essence Shop API
</h1>

<p align="justify">
Built on Laravel, the Essence Shop API empowers your e-commerce platform with essential modules such as Products, Categories, Product Images, and Authentication.

**Authentication:** Essence Shop uses Sanctum for secure authentication. To test it on Postman, refer to the [API Documentation](https://laravel.com/docs/9.x/sanctum#main-content) on how to authenticate using Sanctum.

**Payments:** Essence Shop integrates with Stripe for payment processing. Check out the [Stripe PHP GitHub repository](https://github.com/stripe/stripe-php) for more details on processing payments with Stripe.

**Caching:** Essence Shop uses Redis for caching to improve performance and scalability.

---

### Modules

#### Authentication (Auth)
- Manages user authentication, including login, registration, and logout.

#### Password Reset (ResetPassword)
- Handles password reset functionality, including sending reset links and password reset.

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
- Manages the user's shopping cart, including item addition and removal.

#### Coupon
- Manages user application of coupons.

#### Delivery Option
- Provides information on available delivery options.

#### Payment Method
- Provides information on available payment methods.

### Administration Operations

#### Admin Category
- Administration functionality to create, update, and delete product categories.

#### Admin Order
- Administration functionality to view, update, and delete orders.
- Generates sales reports.

#### Admin Delivery Option
- Administration functionality to manage delivery options.

#### Admin Payment Method
- Administration functionality to manage payment methods.

#### Admin Product
- Administration functionality to manage products, including creation, update, and deletion.

#### Admin Customer
- Administration functionality to manage customer information.
- Generates customer reports.

#### Stock
- Administration functionality to manage product stocks.

#### Admin Coupon
- Administration functionality to manage coupons.

#### Reports
- Access to various reports, including sales reports and customer reports.
---

### Technologies Used

- Laravel: A powerful PHP framework for building robust web applications.
- MySQL: A reliable relational database for data storage.
- Laravel Sanctum: For API authentication.
- Redis: In-memory data structure storage for caching.

### Getting Started

1. Clone the repository: `https://github.com/matondojoao/essence-shop-api.git`
2. Install dependencies: `composer install`
3. Configure your database and update the `.env` file.
4. Run migrations: `php artisan migrate`
5. Start the development server: `php artisan serve`

For detailed API documentation, visit the <a href="https://documenter.getpostman.com/view/23770036/2s9Ykq6feK" target="_blank">API Documentation</a>.

---

### Contributors

- [Matondo João](https://github.com/matondojoao)

Feel free to contribute and make the Essence Shop API even better!
</p>
