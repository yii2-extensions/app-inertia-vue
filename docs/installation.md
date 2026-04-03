# Installation guide

## System requirements

- [`PHP`](https://www.php.net/downloads) 8.1 or higher.
- [`Composer`](https://getcomposer.org/download/) for dependency management.
- [`Node.js`](https://nodejs.org/) 18 or higher with npm.
- [`Yii2`](https://github.com/yiisoft/yii2) 2.0.54+ or 22.x.

## Installation

### Clone the repository

```bash
git clone https://github.com/yii2-framework/app-inertia-vue.git
cd app-inertia-vue
```

### Install dependencies

```bash
composer install
npm install
```

### Run database migrations

```bash
php yii migrate
```

This creates the `user` table and seeds a default admin user (`admin` / `admin`).

### Start the development servers

In one terminal, start the Vite development server:

```bash
npm run dev
```

In another terminal, start the Yii2 PHP development server:

```bash
php yii serve
```

Open your browser at `http://localhost:8080`.

### Build for production

```bash
npm run build
```

## Next steps

- [Configuration Reference](configuration.md)
- [Usage Examples](examples.md)
- [Testing Guide](testing.md)
