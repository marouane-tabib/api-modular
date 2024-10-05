# API Modular 🚀

## Overview

Welcome to the **API Modular**! This project is designed with a robust **modular API architecture**, leveraging [Nwidart Laravel Modules](https://github.com/nWidart/laravel-modules) to promote **separation of concerns** and enhance **maintainability**. It incorporates strong **security features** and **automated documentation**, making it a powerful solution for your API needs. 📜

Ready to get started? Check out the [Installation Guide](#installation) to set everything up, and don't forget to explore the project [Structure](#structure) for a deeper understanding.



---


## Why Choose This Project? 🤔

- **Scalability**: Easily add or modify features with a modular design that allows for independent updates. 📈
- **Security**: Robust security measures ensure that your API is protected against common vulnerabilities. 🔒
- **Comprehensive Documentation**: Automated API documentation keeps your endpoints well-documented and accessible. 📚
- **Developer-Friendly Tools**: Custom Artisan commands streamline workflows, saving time and reducing errors. ⚙️
- **Code Quality Assurance**: Tools for maintaining coding standards ensure a clean and readable codebase. ✅

---

## Key Features 🌟

### 1. Modular Architecture
- **Independent Modules**: Each module encapsulates its own functionalities, facilitating easier development, testing, and scalability. 
- **Automated Module Setup**: Use the command `php artisan module:setup <name-of-module>` to generate a new module with all necessary files, including a complete CRUD structure and routes.

### 2. Enhanced Security 
- **Security Headers**: Custom `SecurityHeaders` middleware adds necessary security headers (e.g., X-Frame-Options, X-XSS-Protection) to all responses.
- **Strong Password Validation**: Enforces secure passwords during user registration with a custom `strong_password` rule.
- **Rate Limiting**: Configured rate limits to prevent abuse:
  - **10,000 requests per day per user**.
  - Throttling for specific routes using `user_throttle` middleware.
- **Force SSL**: Ensures secure communication across the entire application.
- **Auditing Mechanism**: Logs all user actions from commands or requests, capturing context information about each action.

### 3. Authentication and Authorization
- **JWT Authentication**: Secure token-based authentication for all API routes.
- **Role-Based Access Control**: Integration with [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) for fine-grained permission management.

### 4. Automated API Documentation
- **Comprehensive Generation**: Automatically generates detailed API documentation. 
  - Run `php artisan docs:refresh` to keep documentation in sync with code changes.

### 5. Rate Limiting
- **Fair API Access**: Prevents abuse and ensures all users have equitable access to resources.

### 6. Code Quality Tools
- **PHP-CS-Fixer**: Ensures consistent code style with PSR-12 standards. Run `php artisan code:fix` to maintain coding standards.
- **Pint**: Additional linting to keep your codebase clean and maintainable.

### 7. Exception Handling
- **Uniform Error Management**: Customized error handling provides consistent and meaningful responses to API consumers, including HTTP status codes.
  - **Debug Mode**: Enable detailed debugging information by setting `APP_REST_DEBUG=true` in your `.env` file. This will display exception information to aid in debugging, making development easier.
  - **Error Logging**: Integrates with Elasticsearch and Bugsnag for comprehensive error tracking and analysis.

### 8. Soft Deletes & Searchable Models
- **Data Recovery**: Implemented soft deletes ensure records can be recovered for all models in the application.
- **Efficient Searching**: Trait-based search functionality for quick and efficient record filtering.

### 9. Scheduled Backups
- **Data Security**: Automated backups using [Spatie Laravel Backup](https://github.com/spatie/laravel-backup) ensure that data is regularly backed up and can be restored when needed. Daily backups can be configured in `routes/console.php`.

---
```Structure
└── 📁Modules
    └── 📁User
        └── 📁app
        │    └── 📁Http
        │    │    └── 📁Controllers
        │    │    │    └── ...
        │    │    └── 📁Requests
        │    │        └── ...
        │    └── 📁Models
        │    │    └── User.php
        │    └── 📁Providers
        │    │    └── ...
        │    └── 📁Repositories
        │    │    └── UserRepository.php
        │    └── 📁Services
        │    │    └── UserService.php
        └── 📁config
        │    └── .gitkeep
        │    └── config.php
        └── 📁database
        │    └── 📁factories
        │    │    └── ...
        │    └── 📁migrations
        │    │    └── ...
        │    └── 📁seeders
        │    │    └── ...
        └── 📁routes
        │    └── api_v1.php
        └── 📁tests
        │    └── 📁Feature
        │    │    └── .gitkeep
        │    └── 📁Unit
        │        └── .gitkeep
        └── composer.json
        └── module.json
```
---


## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/marouane-tabib/api-modular
   cd api-modular

2. **Set up environment variables**:
   ```bash
   cp .env.example .env

3. **Install dependencies**:
   ```bash
   composer install

4. **Generate application key**:
   ```bash
   php artisan key:generate

5. **Run migrations and seed the database**:
   ```bash
   php artisan migrate --seed

8. **Generate API documentation (if command time long, run composer autoload)**:
   ```bash
   php artisan module:setup <modules>

   example:
   php artisan module:setup Asset Entity

7. **Generate API documentation**:
   ```bash
   php artisan docs:refresh
---

## Author

Developed and maintained by [@marouane-tabib](https://www.github.com/marouane-tabib) 🚀.

For any feedback, suggestions, or inquiries, feel free to reach out via email at **tabibmarouane6@gmail.com**. I'm always open to contributions and improvements to ensure this project grows with the community’s input. 

Submit issues or pull requests, and let’s make this project better together!

Happy coding! 😎

