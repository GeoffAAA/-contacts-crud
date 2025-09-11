# Contacts Dashboard

A modern, full-stack CRUD application built with Laravel 12 and Livewire 3, featuring real-time updates, search, pagination, and a polished UI.

## 🚀 Project Overview

**Contacts Dashboard** is a contact management application that demonstrates modern Laravel development practices with Livewire 3 for reactive components. The app provides a complete CRUD interface for managing contacts with real-time updates, search functionality, and pagination.

### Key Features
- ✅ **Full CRUD Operations** - Create, read, update, and delete contacts
- ✅ **Real-time Search** - Instant filtering across name, email, and phone fields with clear button
- ✅ **Pagination** - Server-side pagination for large datasets
- ✅ **Livewire 3 Compliance** - Modern reactive components with v3 syntax
- ✅ **Authentication** - Complete auth flow with Breeze and security headers
- ✅ **User Data Isolation** - Each user can only access their own contacts
- ✅ **Responsive Design** - Mobile-friendly with Tailwind CSS
- ✅ **Modern UI** - Gradient backgrounds, cards, and clean spacing
- ✅ **Comprehensive Testing** - 66 tests covering all functionality

## 🛠 Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Livewire 3 + Blade templating
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Authentication**: Laravel Breeze

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js & NPM (for asset building)
- SQLite (included) or MySQL/PostgreSQL

## 🚀 Installation & Setup

### Quick Start (SQLite, no DB setup)
```bash
# Clone
git clone <repository-url>
cd contacts-crud

# PHP deps
composer install

# Env
cp .env.example .env
php artisan key:generate

# Use SQLite (no server needed)
mkdir -p database
# Windows PowerShell (create empty file)
ni database\database.sqlite -ItemType File -Force

# Update .env
# DB_CONNECTION=sqlite
# (ensure any other DB_* lines are commented out)

# Migrate
php artisan migrate

# Run servers (two terminals)
# Terminal 1 (PHP)
php artisan serve --host=127.0.0.1 --port=8000
# Terminal 2 (Vite)
npx vite
```

> Windows tip: Prefer `npx vite` over `npm run dev` to avoid the app picker prompt.

### 1. Clone the Repository
```bash
git clone <repository-url>
cd contacts-crud
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies (optional if using only npx vite)
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Option A: SQLite (recommended for local)
ni database\database.sqlite -ItemType File -Force
# Then set DB_CONNECTION=sqlite in .env

# Option B: MySQL/PostgreSQL
# Fill DB_* in .env with your local credentials

# Run migrations
php artisan migrate
```

### 5. Build/Serve Assets
```bash
# Build for production
npx vite build

# Or run dev server (auto-rebuild)
npx vite
```

### 6. Serve the Application
```bash
# Start Laravel development server
php artisan serve --host=127.0.0.1 --port=8000

# Visit http://127.0.0.1:8000
```

## 🔐 Authentication

The app includes a complete authentication system with:

- **Login** - Email/password authentication
- **Registration** - New user account creation
- **Password Reset** - Email-based password recovery
- **Email Verification** - Verification routes are included; the dashboard requires a verified email

### Auth Screens
All authentication screens feature:
- Gradient background matching the dashboard theme
- Centered card layout with backdrop blur
- Modern form styling with focus states
- Responsive design for all screen sizes
- Dynamic welcome messages ("Welcome" vs "Welcome Back")
- Security headers to prevent caching and autofill
- App branding with "Contacts Dashboard" title

### Forgot Password (no SMTP needed in dev)
- With `MAIL_MAILER=log` (recommended for local), the reset email is written to `storage/logs/laravel.log`.
- Submit your email on Forgot Password, then open the latest log and use the reset URL.
- To send real emails later, configure SMTP (e.g., Mailtrap/SendGrid) in `.env` — no code changes needed.

## 📊 CRUD Functionality

### Contact Management
- **Create**: Add new contacts with name, email, and phone
- **Read**: View all contacts in a paginated table
- **Update**: Edit existing contacts via modal
- **Delete**: Remove contacts with confirmation

### Search & Pagination
- **Real-time Search**: Debounced search across all contact fields with live updates
- **Clear Search Button**: Easy reset of search filters
- **Search Results Indicator**: Shows count of matching contacts
- **Server-side Pagination**: 10 contacts per page
- **Instant Updates**: No page reloads required

### Livewire Real-time Updates
- Form submissions trigger immediate list refreshes
- Search updates results without page reload
- Modal state management for create/edit operations
- Event-driven communication between components

## 🎨 UI/Design

### Design System
- **Gradient Backgrounds**: Subtle indigo-to-emerald gradients
- **Card-based Layout**: Elevated white cards with backdrop blur
- **Consistent Spacing**: Tailwind's spacing scale throughout
- **Modern Typography**: Clean, readable font hierarchy

### Branding
- Custom "Contacts Dashboard" branding across auth and app screens
- Default Laravel welcome page exists but is not used by app routing
- Consistent color scheme across all pages
- Professional, polished appearance

### Responsive Design
- Mobile-first approach
- Flexible layouts that adapt to screen size
- Touch-friendly interface elements
- Optimized for desktop and mobile use

## 🏗 Code Structure

```
app/
├── Livewire/Contacts/
│   ├── Index.php          # Main contacts list component
│   └── Form.php           # Contact form modal component
├── Models/
│   └── Contact.php        # Contact Eloquent model
├── Http/Middleware/
│   └── SecurityHeaders.php # Custom security middleware
└── ...

database/
├── migrations/
│   ├── create_contacts_table.php
│   ├── add_user_id_to_contacts_table.php
│   └── add_unique_email_per_user_to_contacts_table.php
├── factories/
│   └── ContactFactory.php  # Test data factory
└── ...

resources/
├── views/
│   ├── livewire/contacts/
│   │   ├── index.blade.php    # Contacts list view
│   │   └── form.blade.php     # Contact form modal
│   ├── layouts/
│   │   ├── app.blade.php      # Main app layout
│   │   ├── guest.blade.php    # Auth pages layout
│   │   └── navigation.blade.php # Navigation component
│   └── auth/                  # Authentication views
└── ...

tests/
├── Feature/
│   ├── ContactTest.php        # Contact CRUD tests
│   ├── LivewireContactTest.php # Livewire component tests
│   └── AuthenticationTest.php # Auth and security tests
├── Unit/
│   └── ContactModelTest.php   # Model unit tests
└── ...

routes/
└── web.php                 # Application routes
```

### Key Livewire Components

#### Contacts\Index
- Manages the contacts list and pagination
- Handles real-time search functionality with clear button
- Controls modal state for create/edit
- Listens for form completion events
- User data isolation (only shows user's own contacts)
- Search results indicator

#### Contacts\Form
- Handles contact creation and editing
- Real-time validation with user-specific email uniqueness
- Dispatches events to refresh parent component (Livewire v3)
- Modal-based interface
- Automatic user_id assignment for security

## 🧪 Testing & Maintenance

### Testing
```bash
# Run all tests
php artisan test

# Run specific test files
php artisan test tests/Feature/LivewireContactTest.php
php artisan test tests/Feature/ContactTest.php
php artisan test tests/Feature/AuthenticationTest.php
```

### Troubleshooting
- If UI changes don’t appear, ensure Vite is running: `npx vite`.
- If Livewire modals don’t open, hard refresh (Ctrl+F5) and check browser console.
- If routes/controllers change, clear caches: `php artisan optimize:clear`.
- If using DB sessions/cache locally, prefer file drivers in `.env`:
  - `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`.

### Test Coverage
The application includes comprehensive test coverage:
- **Unit Tests**: Model relationships and validation
- **Feature Tests**: CRUD operations and user isolation
- **Livewire Tests**: Component interactions and real-time features
- **Authentication Tests**: Login, logout, and security headers
- **Security Tests**: User data isolation and authorization

### Extending the App

#### Adding New Fields
1. Update the migration: `database/migrations/create_contacts_table.php`
2. Add to model fillable: `app/Models/Contact.php`
3. Update form component: `app/Livewire/Contacts/Form.php`
4. Update views: `resources/views/livewire/contacts/`

#### Adding New Entities
1. Create model and migration: `php artisan make:model Entity -m`
2. Create Livewire components: `php artisan make:livewire entities.index`
3. Follow the same pattern as contacts

#### Styling Changes
- Modify Tailwind classes in Blade templates
- Update color scheme in `resources/css/app.css`
- Rebuild assets: `npx vite build`

## 📝 Additional Notes

### Livewire v3 Specifics
- Uses `#[Layout('layouts.app')]` attribute instead of `->layout()`
- Events via `$this->dispatch()` instead of `$this->emit()`
- Listeners via `#[On('eventName')]` instead of `$listeners` array
- Pagination with `WithPagination` trait

- Dashboard and profile routes protected with authentication (auth); auth pages are public
- User data isolation (contacts are user-specific)
- Form validation on both client and server side
- CSRF protection enabled
- SQL injection protection via Eloquent ORM
- XSS protection via Blade templating
- Custom security headers middleware
- Browser autofill prevention on auth forms
- Session management for dynamic welcome messages

### Performance
- Server-side pagination for large datasets
- Debounced search to reduce database queries
- Optimized database queries with proper indexing
- Asset optimization via Vite

- Search case-sensitivity depends on your database collation (SQLite default is case-insensitive)
- No bulk operations (can be added as enhancement)
- No export functionality (can be added as enhancement)
- No soft deletes (can be added as enhancement)
- No contact categories/tags (can be added as enhancement)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Built with ❤️ using Laravel 12 and Livewire 3**