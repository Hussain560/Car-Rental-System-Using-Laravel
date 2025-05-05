# Car Rental Service Project Documentation

## Purpose of This Documentation
This documentation serves as a comprehensive reference for transferring the Car Rental Service project to Laravel framework. Use this documentation to:
- Understand the current project structure
- Map PHP components to Laravel equivalents
- Plan database migrations
- Implement MVC patterns correctly
- Set up routes and controllers
- Configure authentication systems

## Project Overview
A web-based car rental system built with PHP, MySQL, and Bootstrap that allows users to browse, filter, and book vehicles.

## Project Structure
```
/Car_Rental_Service-1
├── config/
│   ├── config.php           # Configuration settings and BASE_PATH
│   └── routes.php           # Application routing configuration
├── database/               # Database scripts and migrations
├── public/
│   ├── css/               # Stylesheets
│   │   ├── admin.css      # Admin panel styles
│   │   ├── bootstrap.min.css
│   │   ├── style.css
│   │   ├── custom.css
│   │   └── wizard.css     # Form wizard styles
│   ├── js/                # JavaScript files
│   │   ├── admin.js       # Admin functionality
│   │   ├── booking.js     # Booking functionality
│   │   ├── filter.js      # Vehicle filtering
│   │   ├── validation.js  # Form validation
│   │   ├── rental-validation.js
│   │   ├── bootstrap.bundle.min.js
│   │   └── admin/         # Admin-specific scripts
│   │       ├── bookings.js      # Booking management
│   │       ├── customers.js      # Customer management
│   │       ├── employees.js      # Employee management
│   │       ├── offices.js        # Office management
│   │       ├── reports.js        # Reporting functionality
│   │       ├── vehicle-wizard.js # Vehicle creation wizard
│   │       └── wizard.js         # General wizard functionality
│   ├── images/
│   │   ├── cars/         # Vehicle images
│   │   ├── admins/       # Admin profile images
│   │   │   ├── default.png
│   │   │   ├── employee_17_Khalid_Mohammed.png
│   │   │   ├── employee_18_Sara_Hassan.png
│   │   │   └── employee_19_Omar_Yousef.jpg
│   │   ├── hero/         # Hero section images
│   │   │   └── hero-bg.jpg
│   │   ├── offices/      # Office location images
│   │   │   ├── dammam-office.jpg
│   │   │   ├── hofuf-office.jpg
│   │   │   ├── jeddah-office.jpg
│   │   │   └── riyadh-office.jpg
│   │   └── Saudi_Riyal_Symbol.svg
│   └── index.php         # Public entry point
├── src/
│   ├── controllers/      # PHP controllers
│   │   ├── admin/       # Admin controllers
│   │   │   ├── booking_controller.php    # Admin booking management
│   │   │   ├── customer_controller.php   # Customer management
│   │   │   ├── employee_controller.php   # Employee management
│   │   │   ├── export_report.php        # Report generation
│   │   │   ├── logout.php               # Admin logout handling
│   │   │   ├── maintenance_controller.php # Vehicle maintenance
│   │   │   ├── office_controller.php     # Office management
│   │   │   └── vehicle_controller.php    # Vehicle inventory
│   │   ├── AdminController.php          # Main admin functionality
│   │   ├── auth_controller.php          # Authentication handling
│   │   ├── booking_controller.php       # Public booking operations
│   │   ├── cancel_booking.php          # Booking cancellation
│   │   ├── check_availability.php      # Vehicle availability
│   │   ├── employee_controller.php     # Employee management
│   │   ├── filter_vehicles.php         # Vehicle filtering
│   │   ├── logout.php                 # Public logout
│   │   └── profile_controller.php     # User profile management
│   ├── core/            # Core framework files
│   │   └── Router.php   # Routing implementation
│   ├── templates/       # Reusable template files
│   │   ├── admin/      # Admin templates
│   │   │   ├── recent_bookings_table.php  # Recent bookings display
│   │   │   └── sidebar.php                # Admin navigation sidebar
│   │   ├── layouts/        # Layout templates
│   │   │   └── default.php                # Default page layout
│   │   ├── auth-modal.php                 # Authentication modal
│   │   ├── booking-form.php              # Booking form template
│   │   ├── featured-cars.php             # Featured vehicles display
│   │   ├── footer.php                    # Common footer
│   │   └── header.php                    # Common header
│   ├── utils/          # Utility functions
│   │   ├── auth.php         # Authentication and authorization functions
│   │   │   ├── isLoggedIn()        # Check user login status
│   │   │   ├── checkAdminSession() # Verify admin session
│   │   │   ├── loginUser()         # Handle user login
│   │   │   ├── loginAdmin()        # Process admin authentication
│   │   │   ├── requireLogin()      # Force login for protected pages
│   │   │   ├── requireAdminLogin() # Force admin login
│   │   │   ├── requireManagerRole()# Check manager permissions
│   │   │   ├── isManager()         # Verify manager status
│   │   │   ├── getUserData()       # Retrieve user information
│   │   │   ├── getAdminData()     # Get admin details
│   │   │   └── logout()           # Handle logout process
│   │   ├── check_login.php  # Login validation and security checks
│   │   ├── error_handler.php# Custom error handling and logging
│   │   └── session.php      # Session management functions
│   │       ├── getUserId()         # Get current user ID
│   │       ├── getAdminId()        # Get current admin ID
│   │       ├── checkSession()      # Validate session status
│   │       ├── setSessionMessage() # Set flash messages
│   │       └── getSessionMessage() # Retrieve flash messages
│   ├── views/           # View files and templates
│   │   ├── admin/          # Admin interface views
│   │   │   ├── admin_dashboard.php   # Admin main dashboard
│   │   │   ├── bookings.php         # Booking management interface
│   │   │   ├── customers.php        # Customer management
│   │   │   ├── employees.php        # Employee management
│   │   │   ├── login.php           # Admin login form
│   │   │   ├── maintenance.php     # Vehicle maintenance tracking
│   │   │   ├── offices.php         # Office location management
│   │   │   ├── reports.php         # Analytics and reporting
│   │   │   └── vehicles.php        # Vehicle inventory management
│   │   ├── errors/         # Error pages
│   │   │   ├── 404.php            # Not found error
│   │   │   ├── error.php          # General error handler
│   │   │   └── test.php           # Route testing page
│   │   ├── public/         # Public facing pages
│   │   │   ├── about.php          # Company information
│   │   │   ├── contact.php        # Contact form
│   │   │   ├── location.php       # Office locations
│   │   │   ├── privacy.php        # Privacy policy
│   │   │   └── terms.php          # Terms of service
│   │   └── user/           # Authenticated user views
│   │       ├── bookings.php       # User's booking history
│   │       ├── edit-profile.php   # Profile edit form
│   │       ├── home.php           # User dashboard
│   │       ├── login.php          # User login
│   │       ├── profile.php        # User profile view
│   │       ├── register.php       # Registration form
│   │       └── vehicles.php       # Vehicle browsing/booking
│   │
│   ├── db.php         # Database connection singleton
│   └── index.php      # Application entry point
```

### Admin Section (`src/views/admin/` & `src/controllers/admin/`)

1. **Vehicle Management**
   - View: `vehicles.php`
     - Vehicle inventory display
     - CRUD interface for vehicles
     - Status tracking (Available/Reserved/Maintenance)
     - Vehicle details (now shows static 'Automatic' transmission)
     - Image management
   - Controller: `vehicle_controller.php`
     - Handles CRUD operations
     - Image upload processing
     - Status updates
     - Inventory management

2. **Booking Management**
   - View: `bookings.php`
     - Booking list interface
     - Status filtering
     - Date range search
     - Export functionality
   - Controller: `booking_controller.php`
     - Status updates
     - Booking modifications
     - Export generation
     - Vehicle availability sync

3. **Maintenance Tracking**
   - View: `maintenance.php`
     - Maintenance records
     - Vehicle service history
     - Cost tracking
     - Status updates
   - Controller: `maintenance_controller.php`
     - Record creation/updates
     - Vehicle status sync
     - Cost management
     - Service scheduling

4. **Office Management**
   - View: `offices.php`
     - Office location management
     - Contact information
     - Vehicle assignment
   - Controller: `office_controller.php`
     - Location CRUD
     - Contact updates
     - Vehicle allocation

5. **Employee Management**
   - View: `employees.php`
     - Staff directory
     - Role management
     - Access control
   - Controller: `employee_controller.php`
     - Staff CRUD
     - Role assignments
     - Access permissions
     - Profile management

6. **Customer Management**
   - View: `customers.php`
     - Customer directory
     - Booking history
     - Account status
   - Controller: `customer_controller.php`
     - Account management
     - Status updates
     - Booking history tracking

7. **Reporting System**
   - View: `reports.php`
     - Revenue analytics
     - Vehicle utilization
     - Booking statistics
   - Controller: `export_report.php`
     - Report generation
     - Data export
     - Analytics processing

8. **Dashboard**
   - View: `admin_dashboard.php`
     - Overview statistics
     - Recent activities
     - Quick actions
     - Performance metrics
   - Controller: `AdminController.php`
     - Data aggregation
     - Stats calculation
     - Activity tracking

9. **Authentication**
   - View: `login.php`
     - Admin login interface
     - Session management
   - Controller: `auth_controller.php`
     - Login validation
     - Session handling
     - Access control

### User Section (`src/views/user/` & `src/controllers/`)

1. **Vehicle Browsing & Booking**
   - View: `vehicles.php`
     - Available vehicle listing
     - Filtering interface
     - Price range controls
     - Category selection
     - Real-time availability check
   - Controller: `filter_vehicles.php`
     - Vehicle filtering logic
     - Availability checking
     - Price range filtering
     - Category filtering
     - Location filtering
   - Associated Controller: `booking_controller.php`
     - Booking creation
     - Date validation
     - Price calculation
     - Availability verification

2. **User Authentication**
   - View: `login.php`
     - Login form
     - Error handling
     - Session management
   - View: `register.php`
     - Registration form
     - Input validation
     - User data collection
   - Controller: `auth_controller.php`
     - Login processing
     - Registration handling
     - Password hashing
     - Session initialization

3. **Booking Management**
   - View: `bookings.php`
     - Booking history
     - Active bookings
     - Cancellation options
     - Booking details
   - Controller: `cancel_booking.php`
     - Booking cancellation
     - Status updates
     - Vehicle availability sync
     - Refund processing

4. **Profile Management**
   - View: `profile.php`
     - User information display
     - Contact details
     - License information
   - View: `edit-profile.php`
     - Profile editing form
     - Data validation
     - Update interface
   - Controller: `profile_controller.php`
     - Profile updates
     - Data validation
     - Password changes
     - Contact updates

5. **User Dashboard**
   - View: `home.php`
     - Featured vehicles
     - Quick booking form
     - Recent bookings
     - Office locations
   - Uses multiple controllers:
     - `booking_controller.php` for quick bookings
     - `filter_vehicles.php` for featured cars
     - `check_availability.php` for real-time checks

6. **Common User Functions**
   - Controller: `logout.php`
     - Session cleanup
     - Login status update
     - Secure logout
     - Redirect handling

### Templates Section (`src/templates/`)

1. **Layout Templates**
   - View: `layouts/default.php`
     - Base page structure
     - Common head elements
     - CSS/JS includes
     - Content placeholder
     - Responsive layout setup

2. **Navigation Components**
   - View: `header.php`
     - Main navigation bar
     - User authentication state
     - Profile dropdown
     - Login/Register links
     - Dynamic menu items
   - View: `admin/sidebar.php`
     - Admin navigation menu
     - Role-based menu items
     - Active state tracking
     - Quick actions

3. **Booking Components**
   - View: `booking-form.php`
     - Booking modal interface
     - Date selection
     - Location selection
     - Cost calculation
     - Validation rules
     - Summary display
   - View: `featured-cars.php`
     - Featured vehicle carousel
     - Vehicle card display
     - Price formatting
     - Category badges
     - Image handling

4. **Admin Components**
   - View: `admin/recent_bookings_table.php`
     - Recent bookings display
     - Status management
     - Quick actions
     - Customer details
     - Booking details

5. **Common Elements**
   - View: `footer.php`
     - Site footer
     - Copyright info
     - Quick links
     - Contact details
   - View: `auth-modal.php`
     - Authentication dialogs
     - Login form
     - Registration form
     - Password reset

### Core Framework (`src/core/`)

1. **Router Class** (`Router.php`)
   - Route Resolution
     - URI parsing and cleaning
     - Path matching
     - Base path handling
     - Query string management
   - Error Handling
     - 404 handling
     - Redirect management
   - View Integration
     - Template loading
     - Dynamic routing
     - Response handling

2. **View Class** (`View.php`)
   - Template Management
     - Layout handling
     - Content buffering
     - Data extraction
     - Dynamic content
   - Asset Management
     - Path resolution
     - Base path handling
   - View Rendering
     - Template inclusion
     - Data passing
     - Layout integration

3. **Database Connection** (`db.php`)
   - Connection Management
     - Singleton pattern
     - Connection pooling 
     - Resource cleanup
   - Error Handling
     - Development/Production modes
     - Error logging
     - Graceful failures
   - Security Features
     - Connection parameters
     - Charset enforcement
     - Query preparation

4. **Core Features**
   - Dependency Management
     - Autoloading
     - Class resolution
     - Module loading
   - Configuration
     - Environment detection
     - Path management
     - Error reporting
   - Security
     - Input validation
     - Output escaping
     - Session handling
     
### Public Assets (`/public/`)

1. **Stylesheets** (`/css/`)
   - `admin.css`
     - Admin panel styling
     - Dashboard layout and grid system
     - Custom components (tables, cards, forms)
     - Responsive rules for all screen sizes
     - Dark/Light theme support
     - Custom scrollbars and animations
   - `style.css`
     - Public site styling
     - Vehicle cards and grid layouts
     - Booking forms and modals
     - Custom animations and transitions
     - Responsive navigation
     - Hero section styles
     - Category filters design
   - `wizard.css`
     - Multi-step forms with progress tracking
     - Progress indicators and breadcrumbs
     - Validation states and feedback
     - Mobile-friendly step navigation
     - Form section animations
   - `custom.css`
     - Override styles for third-party components
     - Custom color schemes
     - Print media styles
   - `bootstrap.min.css`
     - Core Bootstrap framework styles
     - Customized theme variables
     - Grid system base

2. **JavaScript** (`/js/`)
   - Public Scripts
     - `booking.js`: 
       - Booking form handling and validation
       - Date picker initialization
       - Price calculation
       - Availability checking
       - Form submission handling
     - `filter.js`: 
       - Vehicle filtering logic
       - Price range slider
       - Category filtering
       - Search functionality
       - Sort options
     - `validation.js`: 
       - Form validation rules
       - Input masking
       - Error message handling
       - Custom validators
     - `rental-validation.js`:
       - Rental-specific validation rules
       - Date range validation
       - Age verification
       - License validation
   - Admin Scripts (`/admin/`)
     - `bookings.js`: 
       - Booking management interface
       - Status updates
       - Payment processing
       - Calendar view
     - `customers.js`: 
       - Customer data management
       - Search and filtering
       - Profile updates
       - History tracking
     - `reports.js`: 
       - Analytics charts and graphs
       - Data export functions
       - Dashboard widgets
       - Real-time updates
     - `vehicle-wizard.js`: 
       - Vehicle creation workflow
       - Image upload handling
       - Category management
       - Inventory updates

3. **Images** (`/images/`)
   - Vehicle Images (`/cars/`)
     - High-resolution vehicle photos
     - Category thumbnails
     - Optimized versions for web
   - Admin Images (`/admins/`)
     - Staff profile pictures
     - Default avatars
     - Role-based icons
   - Location Images (`/offices/`)
     - Office exterior/interior photos
     - Branch location maps
     - Facility images
     - Virtual tour assets
   - Interface Assets
     - Brand logos and icons
     - UI/UX elements
     - Background patterns
     - Loading animations
   - Hero Images (`/hero/`)
     - Homepage banners
     - Promotional graphics
     - Seasonal campaign images
   - Payment Icons
    - Currency & Payment Assets
      - Saudi Riyal symbol(The new one which created in 2025) in SVG format
      - Credit card network logos (Visa, Mastercard)
      - Local payment methods 
      - Digital wallet icons

4. **Entry Point** (`index.php`)
   - Main application bootstrap
   - Route initialization
   - Environment configuration
   - Security headers
   - Asset loading

### Database (`/database/`)

1. **Schema Files**
   - `schema.sql`
     - Table definitions
     - Foreign key constraints
     - Indexes and triggers
   - `initial_data.sql`
     - Default records
     - Test data
     - Lookup tables

2. **Migrations**
   - Version control
   - Schema updates
   - Data transformations
   - Rollback scripts

3. **Backup Scripts**
   - Automated backups
   - Data recovery
   - Maintenance tasks

### Utils (`/src/utils/`)

1. **Authentication** (`auth.php`)
   - Login handling
   - Session management
   - Permission checks
   - Role validation

2. **Session Management** (`session.php`)
   - Session control
   - Flash messages
   - State persistence
   - Security checks

3. **Error Handling** (`error_handler.php`)
   - Error logging
   - Exception handling
   - Debug information
   - User notifications

4. **Validation** (`validation.php`)
   - Input sanitization
   - Data validation
   - Format checking
   - Security filters


## Database Schema

### Users Table
```sql
CREATE TABLE users (
  UserID int(11) NOT NULL,
  Username varchar(50) NOT NULL,
  Password varchar(255) NOT NULL,
  FirstName varchar(50) NOT NULL,
  LastName varchar(50) NOT NULL,
  PhoneNumber varchar(20) NOT NULL,
  Email varchar(100) NOT NULL,
  NationalID varchar(10) NOT NULL,
  Address text NOT NULL,
  CreatedAt timestamp NOT NULL DEFAULT current_timestamp(),
  UpdatedAt timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  DateOfBirth date DEFAULT NULL,
  Gender enum(Male,Female) NOT NULL DEFAULT Male,
  EmergencyPhone varchar(20) DEFAULT NULL,
  LicenseExpiryDate date DEFAULT NULL,
  LastLogin datetime DEFAULT NULL,
  AccountStatus enum(Active,Suspended,Inactive) DEFAULT Active
);
```
### Vehicles Table
```sql
CREATE TABLE vehicles (
  VehicleID INT PRIMARY KEY AUTO_INCREMENT,
  Make VARCHAR(50) NOT NULL,
  Model VARCHAR(50) NOT NULL,
  Year INT NOT NULL,
  LicensePlate VARCHAR(7) NOT NULL,
  SerialNumber VARCHAR(50) DEFAULT NULL,
  DateOfExpiry DATE DEFAULT NULL,
  Color VARCHAR(30) DEFAULT NULL,
  Category ENUM('Sedan','SUV','Crossover','Small Cars') NOT NULL,
  Status ENUM('Available','Rented','Maintenance')  NOT NULL DEFAULT 'Available',
  ImagePath VARCHAR(255) DEFAULT NULL,
  DailyRate DECIMAL(10,2) DEFAULT NULL,
  OfficeID INT DEFAULT NULL,
  PassengerCapacity INT NOT NULL DEFAULT 4,
  LuggageCapacity INT NOT NULL DEFAULT 2 COMMENT 'Number of luggage pieces',
  Doors INT NOT NULL DEFAULT 4,
  FOREIGN KEY (OfficeID) REFERENCES offices(OfficeID)
);

```

### Maintenance Table
```sql
CREATE TABLE maintenance (
  MaintenanceID INT PRIMARY KEY AUTO_INCREMENT,
  VehicleID INT NOT NULL,
  StartDate DATE NOT NULL,
  EndDate DATE DEFAULT NULL,
  MaintenanceType VARCHAR(50) NOT NULL,
  Description TEXT NOT NULL,
  Cost DECIMAL(10,2) NOT NULL,
  Status ENUM('In Progress','Completed') DEFAULT 'In Progress',
  CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (VehicleID) REFERENCES vehicles(VehicleID)
);
```

### Admins Table
```sql
CREATE TABLE admins (
  AdminID INT PRIMARY KEY AUTO_INCREMENT,
  Username VARCHAR(50) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  FirstName VARCHAR(50) NOT NULL,
  LastName VARCHAR(50) NOT NULL,
  PhoneNumber VARCHAR(15) NOT NULL,
  Email VARCHAR(100) NOT NULL,
  Role ENUM('Manager','Employee') NOT NULL DEFAULT 'Employee',
  LastLogin DATETIME DEFAULT NULL,
  CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  Status ENUM('Active','Inactive','Suspended') NOT NULL DEFAULT 'Active',
  ImagePath VARCHAR(255) DEFAULT NULL
);
```

### Bookings Table
```sql
CREATE TABLE bookings (
  BookingID int(11) NOT NULL,
  UserID int(11) NOT NULL,
  VehicleID int(11) NOT NULL,
  PickupDate date NOT NULL,
  ReturnDate date NOT NULL,
  PickupLocation varchar(100) NOT NULL,
  TotalCost decimal(10,2) NOT NULL,
  Status enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  BookingDate datetime DEFAULT current_timestamp(),
  UpdatedAt timestamp NULL DEFAULT NULL
)
```

### Offices Table
```sql
CREATE TABLE offices (
  OfficeID int(11) NOT NULL,
  Location varchar(100) DEFAULT NULL,
  PhoneNumber varchar(20) DEFAULT NULL
);
```

## Key Features

### 1. Vehicle Management
- Display all available vehicles with filtering system
  - Category filters (All Fleet, Small Cars, Sedan, SUV & Crossover)
  - Dynamic price range filtering
  - Office location selection
  - Real-time availability checking
  - Custom sort options
- Vehicle details display
  - Make, model, and year
  - Passenger and luggage capacity
  - Transmission type
  - Daily rates in SAR (Saudi Riyal)
  - Vehicle status tracking
  - Office location availability

### 2. Booking System
- Interactive booking process
  - Real-time availability verification
  - Dynamic cost calculation with SAR symbol
  - Date range validation
  - Office location selection
  - Booking confirmation modal
- Booking management
  - Status tracking (Pending, Confirmed, Completed, Cancelled)
  - Booking modification for managers
  - Cancellation with automatic vehicle status update
  - Email notifications
  - Cost recalculation on date changes

### 3. User Features
- Authentication system
  - Secure login/register process
  - Session management with timeout
  - Password hashing and validation
  - Role-based access control
- User dashboard
  - Booking history display
  - Active reservation tracking
  - Profile management
  - Booking cancellation options

### 4. Interface Components
- Modern responsive design
  - Bootstrap 5 framework
  - Custom CSS styling
  - Bootstrap Icons integration
  - Mobile-friendly layout
- Dynamic interactions
  - Modal forms for booking
  - Date picker validation
  - Status color coding
  - Loading indicators
  - Flash messages
  - Form validation
- Error handling
  - User-friendly error messages
  - Validation feedback
  - AJAX error handling
  - Form submission protection

## Technology Stack
- Frontend: HTML5, CSS3, Bootstrap, JavaScript
- Backend: PHP
- Database: MySQL
- Server: Apache

## Setup Instructions
1. Clone repository
2. Configure database settings in `config/db.php`
3. Import SQL schema from `database/schema.sql`
4. Configure Apache virtual host
5. Access application through browser

## Security Features
- Password hashing
- Input validation
- Session management
- SQL injection prevention
- XSS protection

## API Endpoints

### Vehicle Management
```
GET /src/controllers/filter_vehicles.php
Parameters:
- activeCategory: string
- minPrice: float
- maxPrice: float
- office: string
- pickup_date: date
- return_date: date
Response: JSON array of available vehicles
```

### Booking Management
```
POST /src/controllers/booking_controller.php
Parameters:
- vehicle_id: int
- pickup_date: date
- return_date: date
- pickup_location: string
Response: Redirect to bookings page

POST /src/controllers/cancel_booking.php
Parameters:
- booking_id: int
Response: Redirect to bookings page with status
```

## Security Implementation
1. SQL Injection Prevention
   - Prepared statements
   - Parameter binding
   - Input validation

2. Session Security
   - Secure session handling
   - Session timeout
   - Session fixation protection

3. Form Security
   - CSRF protection
   - Input validation
   - XSS prevention

4. Authentication
   - Password hashing
   - Login rate limiting
   - Session management

## Development Guidelines
1. Code Organization
   - MVC-like structure
   - Separation of concerns
   - Reusable components

2. Database
   - Transaction handling
   - Foreign key constraints
   - Indexing for performance

3. Error Handling
   - Consistent error messages
   - Logging system
   - User-friendly errors

4. Coding Standards
   - PSR-12 compliance
   - Documentation
   - Clean code practices

## Dependencies
- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5.0+
- Bootstrap Icons
- Modern web browser with JavaScript enabled

## User Journey Flow

### 1. User Registration & Authentication
1. **Initial Registration**
   - Navigate to registration page
   - Fill required details:
     - Personal information
     - Contact details
     - National ID
     - Driver's license information
   - Submit registration form
   - Receive confirmation email
   - Account activated

2. **Login Process**
   - Click "Login" button
   - Enter email and password
   - System validates credentials
   - Redirected to homepage with authenticated session

### 2. Vehicle Search & Selection
1. **Search Initiation**
   - Use homepage search form or navigate to vehicles page
   - Select rental parameters:
     - Pick-up location (Riyadh, Dammam, Hofuf, or Jeddah)
     - Pick-up date and time
     - Return date and time

2. **Filter & Browse**
   - Apply filters:
     - Vehicle category (Small Cars, Sedan, SUV & Crossover)
     - Price range (SAR 50-3200 per day)
     - Sort by price or name
   - View available vehicles matching criteria
   - Each vehicle card shows:
     - Vehicle image
     - Make, model, and year
     - Category and specifications
     - Daily rate in SAR
     - Location availability

### 3. Booking Process
1. **Vehicle Selection**
   - Click "Book Now" on chosen vehicle
   - System checks real-time availability
   - Opens booking modal with:
     - Vehicle details
     - Selected dates
     - Location information
     - Price breakdown

2. **Booking Confirmation**
   - Review booking details
   - Confirm rental terms and conditions
   - Click "Confirm Booking"
   - System creates pending booking
   - Vehicle marked as reserved

### 4. Payment & Confirmation
1. **Payment Processing**
   - Redirected to payment page
   - Select payment method:
     - Credit/Debit card
     - Local payment options
   - Enter payment details
   - Confirm payment

2. **Booking Finalization**
   - Payment processed
   - Booking status updated to "Confirmed"
   - Confirmation email sent with:
     - Booking reference number
     - Vehicle details
     - Pick-up instructions
     - Total cost breakdown

### 5. Post-Booking Management
1. **View Booking**
   - Access "My Bookings" section
   - View booking details:
     - Booking status
     - Vehicle information
     - Pick-up/return details
     - Payment information

2. **Modify/Cancel Booking**
   - Option to cancel if booking is "Pending"
   - Cancellation before pick-up date
   - Status updated to "Cancelled"
   - Vehicle returned to available inventory

### 6. Vehicle Pick-up & Return
1. **Pick-up Process**
   - Visit selected office location
   - Present required documents:
     - Booking confirmation
     - Valid ID
     - Driver's license
   - Vehicle inspection
   - Sign rental agreement
   - Receive vehicle keys

2. **Return Process**
   - Return vehicle to designated location
   - Vehicle inspection completed
   - Return documentation processed
   - Booking status updated to "Completed"

### 7. Post-Rental
1. **Review & Feedback**
   - Receive feedback request
   - Rate rental experience
   - Submit vehicle review
   - Provide service feedback

2. **Account History**
   - Updated rental history
   - Accumulated rental points
   - Access to future discounts
   - Profile status updated


