# Ready to Use Admin Panel

Welcome to the **Ready to Use Admin Panel**! This admin panel comes pre-configured with **Spatie Permissions**, allowing you to easily manage roles and permissions for your application. It also includes a comprehensive settings system to manage various site configurations seamlessly.

## Features

- **Dashboard**: Access a centralized dashboard to view important metrics and information.
- **Profile Update**: Easily update your profile information.
- **Admins Management**: Manage admin users efficiently.
- **Admin Roles and Permissions**: Assign roles and define permissions for admin users.
- **Spatie Permissions Integration**: Easily manage roles and permissions using Spatie's powerful permissions package.
- **Settings**: Configure various site settings including general and social configurations.
- **Dynamic Settings Management**: Manage both general and social settings from an intuitive interface.
- **Form Field Type Detection**: Settings fields are automatically rendered as `<textarea>` or `<input>` fields based on the type of data being handled.

## Spatie Permissions

This admin panel leverages the Spatie Permissions package to provide role-based access control. To secure a Livewire component, you can use the following authorization method within the component:

```php
$this->authorize('update:admin', Auth::guard($this->guardName)->user());
```

You can use permissions like:

```php
@can('view:admin', 'guard_name')
    <!-- Content for users who have the 'view:admin' permission -->
@endcan
```

With Spatie Permissions, you can easily define and control what different roles can access in the admin panel.

## Settings Management

The admin panel includes a settings management system that allows you to configure various aspects of your site. Settings are grouped into **General** and **Social** categories:

- **General Settings**: These settings have keys like `site_general_name` or `site_general_textarea_description`. They are displayed under the **General** tab.
- **Social Settings**: These settings have keys like `site_social_facebook` and are displayed under the **Social** tab.

### Field Type Detection

- If a setting key contains `textarea`, it will be rendered as a `<textarea>` field in the admin panel.
- Otherwise, it will be rendered as an `<input>` field, providing a straightforward user experience for data entry.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/SyedMuradAliShah/web.laravel.admin-flare.git
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Run migrations to set up the database:
   ```bash
   php artisan migrate --seed
   ``


## To run it

1. Run NPM:
   ```bash
   npm run dev
   ```
2. Serve artisan:
   ```bash
   php artisan serve
   ``

## Usage

1. Navigate to the admin panel.
2. Use the **Settings** tab to manage general or social settings.
3. Use **Admin** to create or update admins.
4. Use **Role Management** to assign or update roles and permissions.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contribution

Feel free to submit pull requests or report issues. Contributions are always welcome!

## Support

If you need help, please create an issue or reach out to the repository maintainer.

