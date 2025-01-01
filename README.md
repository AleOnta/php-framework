# PHP Framework

This project is a lightweight PHP framework designed to facilitate building web applications with modern programming principles such as Dependency Injection (DI), Middleware, and the MVC architecture.

---

## Features

- **Routing**: Define and manage routes with support for dynamic parameters.
- **Middleware**: Attach middleware to routes for pre- and post-processing.
- **Dependency Injection**: Utilize a centralized DI container for managing class dependencies.
- **Controllers**: Handle incoming HTTP requests.
- **Repositories**: Abstract database interactions.
- **Services**: Encapsulate business logic.
- **Blade-like Views**: Render dynamic HTML templates with passed variables.
- **Tailwind CSS**: Styled with Tailwind for modern and responsive designs.

---

## Folder Structure

```
php-framework/
├── config/
│   ├── bootstrap.php
│   └── ...
├── public/
│   ├── index.php
│   └── ...
├── src/
├───├── app/
│   │   ├── controllers/
|   |   ├── core/
|   |   ├── helpers/
|   |   ├── middlewares/
|   |   ├── migrations/
|   |   ├── models/
│   │   ├── repositories/
|   |   ├── routes/
│   │   ├── services/
|   |   ├── utility/
|   |   ├── views/
|   |   |   ├── components/
|   |   |   └── templates/
|   |   |   └── ...
│   │   ├── Controller.php
│   │   ├── MigrationRunner.php
│   │   ├── PageBuilder.php
│   │   ├── Router.php  
│   │   └── ...
├── vendor/
├── .env
├── .gitignore
├── README.md
├── composer.json
├── composer.lock
├── package-lock.json
├── package.json
├── postcss.config.js
└── tailwind.config.js
```

### Folder Details

- **`config/`**: Contains configuration files for the application.
  - **`bootstrap.php`**: Initializes the application, including the Dependency Injection (DI) container where services are registered.
- **`public/`**: Houses publicly accessible files, including the entry point `index.php`.
- **`src/`**: Contains the main application source code.
  - **`controllers/`**: Houses controller classes that handle HTTP requests.
  - **`helpers/`**: Path for global helper functions to use around the application.
  - **`middlewares/`**: Stores Middleware classes available. 
  - **`migrations/`**: Path to the ran and available migrations used in the application development.
  - **`models/`**: Houses the application models / entities persisted in the database.
  - **`repositories/`**: Contains repository classes responsible for data persistence and retrieval.
  - **`routes/`**: Contains the index.php file where the application routes are defined.
  - **`services/`**: Includes service classes that encapsulate business logic.
  - **`utility/`**: Houses different utility classes (es. EnvLoader...)
  - **`views/`**: Contains the main .php views files.
    - **`components/`**: Path to components availables for rendering in views.
    - **`templates/`**: Path to main templates used for HTML structure.
- **`vendor/`**: Includes dependencies managed by Composer.
- **`.gitignore`**: Specifies files and directories to be ignored by Git.
- **`README.md`**: Provides an overview and documentation for the project.
- **`composer.json`**: Lists PHP dependencies and project metadata.
- **`composer.lock`**: Locks the versions of dependencies installed via Composer.
- **`package-lock.json`**: Locks the versions of Node.js dependencies.
- **`package.json`**: Lists Node.js dependencies and project metadata.
- **`postcss.config.js`**: Configuration file for PostCSS.
- **`tailwind.config.js`**: Configuration file for Tailwind CSS.

---

## Setting Up the Project

1. Clone the repository:

   ```bash
   git clone https://github.com/AleOnta/php-framework.git
   cd php-framework
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install Node.js dependencies:

   ```bash
   npm install
   ```

4. Build Tailwind CSS:

   ```bash
   npm run build
   ```

5. Start a local PHP server:

   ```bash
   php -S localhost:8000 -t public
   ```

---

## Adding New Features

### Adding a New Controller

1. Create a new controller inside the `src/Controllers/` directory. Example:

   ```php
   namespace App\Controllers;

   class ExampleController {
       public function index() {
           return "Hello, World!";
       }
   }
   ```

2. Register the controller in the DI container in `config/bootstrap.php`:

   ```php
   $container->set(App\Controllers\ExampleController::class, function ($container) {
       return new App\Controllers\ExampleController();
   });
   ```

3. Define a route in `routes/index.php`:

   ```php
   $router->get('/example', [App\Controllers\ExampleController::class, 'index']);
   ```

### Registering Dependencies

Any new class (Controller, Repository, Service) must be registered in the DI container to ensure proper dependency injection. This is managed in the `config/bootstrap.php` file.

Example:

```php
use App\Controllers\YourController;
use App\Repositories\YourRepository;
use App\Services\YourService;

$container->set(YourController::class, function($container) {
    return new YourController(
        $container->get(YourService::class),
        // other dependencies
    );
});

$container->set(YourService::class, function($container) {
    return new YourService(
        $container->get(YourRepository::class),
        // other dependencies
    );
});
```

---

## Middleware

Middleware can be applied to routes to handle pre- and post-request logic.

### Example Middleware

```php
namespace App\Middlewares;

class ExampleMiddleware {
    public function handle($request, $next) {
        // Pre-request logic
        if (!$this->checkSomething()) {
            die('Access Denied');
        }

        $next();

        // Post-request logic
    }

    private function checkSomething() {
        return true; // Replace with actual logic
    }
}
```

### Applying Middleware

Register middleware in your route definition:

```php
$router->get('/protected-route', YourController::class, 'index', [App\Middlewares\ExampleMiddleware::class]);
```

---

## Contribution Guidelines

1. Fork the repository.
2. Create a new feature branch.
3. Make changes and commit them.
4. Push your branch and create a pull request.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

