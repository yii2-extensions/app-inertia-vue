# Configuration reference

## Overview

This template centralizes runtime configuration in `config/params.php` (application parameters), `config/web.php` and
`config/console.php` (component wiring), `config/db.php` (database DSN), and environment variables consumed by
`public/index.php`. The sections below describe each surface and how to override its defaults.

## Environment variables

Defined in `public/index.php`:

- `YII_ENV`: Set via `getenv('YII_ENV')`, defaults to `prod`. Values: `dev`, `test`, `prod`.
- `YII_DEBUG`: Automatically `true` when `YII_ENV` is not `prod`.

## Application parameters

All parameters are in `config/params.php`.

### Admin credentials

Used by the migration to seed the initial admin user:

| Parameter        | Default             | Description    |
| ---------------- | ------------------- | -------------- |
| `admin.username` | `admin`             | Admin username |
| `admin.password` | `admin`             | Admin password |
| `admin.email`    | `admin@example.com` | Admin email    |

**Important:** Change these before running migrations in shared or production environments.

### Email

| Parameter      | Default               | Description                          |
| -------------- | --------------------- | ------------------------------------ |
| `supportEmail` | `support@example.com` | From address for account email flows |

### User

| Parameter                       | Default | Description                             |
| ------------------------------- | ------- | --------------------------------------- |
| `user.passwordMinLength`        | `8`     | Minimum password length for signup      |
| `user.passwordResetTokenExpire` | `3600`  | Password reset token lifetime (seconds) |

## Database

Default: SQLite at `runtime/db.sqlite`. Configuration in `config/db.php`.

To use MySQL or PostgreSQL, update the DSN:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2_app',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

## Mail

Default: file-based transport (emails saved to `runtime/mail/`). Configuration in `config/web.php`.

To enable SMTP delivery, set `useFileTransport` to `false` and configure your SMTP settings.

## Dark mode

Controlled by `resources/js/Components/ThemeToggle.vue`:

- Respects system preference via `prefers-color-scheme`.
- Persists user choice to `localStorage` as `theme` key.
- Applies the `dark` class on the `<html>` element.
- System preference changes propagate when no localStorage override exists.

## Next steps

- 💡 [Usage Examples](examples.md)
- 🧪 [Testing Guide](testing.md)
