# DFM Hospital Inventory Management System

## 1. Purpose and scope

DFM Hospital Inventory Management System is a Laravel web application for managing patient records, patient diagnoses, medicine inventory and dispensing, staff accounts, doctor records, assistance requests, dashboards, and printable reports. The interface is built with Blade templates, Bootstrap, and JavaScript.

This guide describes the current repository implementation, not a proposed replacement. A few unfinished areas and observed constraints are called out explicitly in [Known limitations and implementation notes](#11-known-limitations-and-implementation-notes).

## 2. Technology and repository map

| Area | Implementation |
| --- | --- |
| Server application | PHP 8.1+, Laravel 10 |
| Web routes | `routes/web.php`; the routes are loaded in Laravel's `web` middleware group |
| Views | Blade templates under `resources/views/` |
| Persistence | Laravel migrations under `database/migrations/`; database connection is configured in `.env` |
| Browser assets | Vite, Sass, Bootstrap 5, Bootstrap Icons, jQuery, Alpine.js, Chart.js, and Flatpickr |
| PDF output | `barryvdh/laravel-dompdf` |
| Interactive tables | Livewire and PowerGrid are installed; project-specific Livewire components are in `app/Livewire/` |
| Tests | PHPUnit feature and unit tests under `tests/` |

Useful source locations:

- `app/Http/Controllers/` — request handling and feature workflows.
- `app/Http/Middleware/IsUserType.php` — application role gate (`user.type`).
- `app/Models/` — Eloquent models.
- `app/Notifications/` and `app/Listeners/` — in-app patient and login activity notifications.
- `resources/views/components/` — reusable interface components such as sidebar, topbar, alerts, and patient/medicine cards.
- `resources/views/pdf/` and `resources/views/printables/` — PDF and print layouts.
- `resources/sass/`, `resources/css/`, and `resources/js/` — theme, layout, and browser interactions.

## 3. Roles and access control

Users are stored in `users` and have a `type` of `ADMIN`, `PHARMACIST`, or `RECEPTIONIST`. The exact role string is used for route access and for selecting the post-login dashboard.

| Role | Main capabilities |
| --- | --- |
| **ADMIN** | Shared dashboard; patient, medicine, and report access; staff account administration; doctor records; assistance requests; overall reports. |
| **PHARMACIST** | Medicine inventory and batches, medicine dispensing, dispensing history, medicine reports, and profile access. |
| **RECEPTIONIST** | Patient records and diagnoses, patient certificates, barangay views, patient reports, and profile access. |

Most application routes are inside the `auth` group. Feature route groups add `user.type` middleware to limit requests by role. Navigation items are also conditionally rendered in `resources/views/components/sidebar.blade.php`, but the middleware is the actual access boundary.

Authentication uses the username (`users.name`) and password. Passwords are hashed by the `User` model's `hashed` cast. Login redirects to `/dashboardPharmacist` for pharmacists, `/dashboardReceptionist` for receptionists, and `/dashboard` for administrators. Logout is a `DELETE /logoutUser` request.

## 4. Main features and workflows

### 4.1 Login, profiles, and user administration

- Open `/login` and submit username and password to `POST /loginUser`.
- On successful authentication, the session is regenerated and the user is sent to the dashboard for their role.
- Authenticated users can view their profile at `/user/{user}`.
- Administrators can search, list, create, update, and delete non-admin user accounts. Account type is assigned when an account is created or updated.
- The account update flow includes password confirmation. The changed password is saved through the model's password-hashing cast.
- Login/logout listeners update `users.is_login`, which the profile view uses for an activity indicator.

### 4.2 Patient records and diagnoses

Receptionists and administrators can:

- Create a patient record with a generated case number, identity and contact details, demographics, address/barangay, and physical measurements.
- Optionally create an initial diagnosis/case at patient registration.
- Browse a paginated patient list, search/sort records, filter or summarize by barangay, and open patient details.
- View diagnosis history and recorded medicine dispensing for the patient.
- Add subsequent diagnoses to an existing patient through `POST /addNewDiagnosis`.
- Generate patient and barangay reports and patient information PDFs.

Patient identity data is in `patients`. Repeated diagnosis/admission data is in `patient_cases`; these records are associated by `case_no`. A patient can therefore have multiple patient-case entries.

### 4.3 Medical and death certificates

From `/patient-certificates`, authorized staff search patients by case number or name and select a patient. The print action validates the certificate type and required fields, then streams a portrait A4 PDF:

- **Medical certificate** — requires a purpose and includes the latest available patient case information.
- **Death certificate** — requires death date/time/place, cause, and certifier identity/license details.

The certificate PDFs are generated from `resources/views/pdf/medical_certificate.blade.php` and `resources/views/pdf/death_certificate.blade.php`.

### 4.4 Medicine inventory and batches

Pharmacists and administrators can:

- List medicine records, inspect details, search by name, and filter records by expiration or batch.
- Add a medicine record with its identifier, name, manufacturer, type, quantity, package/unit details, photo, batch number, description, and expiration date.
- Add a batch containing multiple medicine records.
- Edit or delete a medicine record.
- Import medicine data from CSV and export a CSV template/data download.
- Review expiring, expired, non-expired, low-stock, and batch-filtered listings.

The main inventory count is `medicines.quantity`. `batch_medicines` records batch/stock and expiration metadata associated with a medicine identifier. A batch is not a separate stock ledger in the current schema.

### 4.5 Medicine dispensing

Dispensing is a pharmacist/administrator workflow:

1. Open `/despenseMedicine`.
2. Select a patient by case number, a doctor by license number, and one or more medicines; enter the quantity for each and the diagnosis.
3. Submit to `POST /despenseMedicineReciept` to validate the selection and show a receipt preview.
4. Confirm from the preview; the form submits to `POST /recordDespenseMedicine`.
5. The application validates the patient, doctor, medicine identifiers, distinct selected medicines, and positive integer quantities. It locks each medicine row, checks available stock, subtracts dispensed quantities, and creates a dispensing record for each medicine inside one database transaction.
6. On success, return to the dispensing screen. An insufficient-stock or invalid request fails validation; a failure during a multi-item dispense rolls back all inventory and dispensing-record changes.

Each `despense_medicines` record stores the dispenser's username, patient case number, medicine identifier, diagnosis, quantity, doctor license number, and timestamps. `GET /despenseMedicineList` shows recorded dispenses. The listing and medicine reports provide history and summary views.

**Operational rule:** dispense quantities must be positive whole numbers and stock must be available. Keep the preview and final confirmation steps; only final confirmation changes stock.

### 4.6 Doctors

Doctor records include full name, license number, and optional description. The application provides a paginated list, search, creation, detail/history view, and deletion. Doctor license numbers are selected during dispensing and written to the dispensing record.

Doctor management routes are currently in the administrator route group, although the sidebar's doctor link is also rendered for receptionists. See [Known limitations and implementation notes](#11-known-limitations-and-implementation-notes).

### 4.7 Assistance requests

Administrators can list requests linked to patient case numbers, search/filter them, start a request for a patient, and update a request's status. New requests are created as `PENDING`; the update flow records the selected status. The request fields are type, status, case number, and request date.

### 4.8 Dashboards and reports

- **Shared/admin dashboard (`/dashboard`)** — totals for users, patients, medicine records and quantity; stock bands; gender totals; dispensing activity; and expiration summaries.
- **Receptionist dashboard (`/dashboardReceptionist`)** — patient totals, recent patients, diagnoses, gender breakdown, and age groups.
- **Pharmacist dashboard (`/dashboardPharmacist`)** — medicine totals and quantities, dispensing summary, and stock bands.
- **Admin overall reports (`/reports`)** — cross-domain report view.
- **Patient reports** — patient, diagnosis, gender, age, and barangay information, including printable reports.
- **Medicine reports** — inventory, dispensing, and printable medicine summaries.
- **PDF/print output** — generated from Dompdf templates in `resources/views/pdf/` and `resources/views/printables/`.

Charts and dashboard cards use values provided by `ReportsController`; browser-side chart assets are included through Vite.

### 4.9 Notifications

New-patient registration sends a Laravel database notification to the users. A notification dropdown appears in the topbar, and routes support marking notifications as read and following a notification link. The notifications table uses Laravel's UUID and polymorphic-notifiable structure.

## 5. Data model

The following is the conceptual model represented by the migrations. These relations are primarily linked by identifiers and case numbers; the schema does not declare database foreign-key constraints for most links.

| Table | Purpose and key data |
| --- | --- |
| `users` | User name, email, hashed password, role/type, login indicator, and timestamps. |
| `patients` | One patient identity/profile per case number, with name, DOB/age, demographic, address, and physical fields. |
| `patient_cases` | Diagnosis/treatment/admission entries, linked to patients using `case_no`. |
| `medicines` | Medicine identity, manufacturer/type, package and measurement, available quantity, photo, batch, description, and expiration. |
| `batch_medicines` | Batch identifier/title, medicine identifier, stock date, and expiration date. |
| `despense_medicines` | Dispensing event line: dispenser, patient case, medicine, diagnosis, quantity, doctor, and timestamps. |
| `doctors` | Doctor full name, license number, and optional description. |
| `assistance_requests` | Patient case, request type, status, and request date. |
| `notifications` | Laravel database notifications, including notifiable identity and read time. |
| `barangay_list` | Region/barangay choices for patient-area views. |

Related Laravel tables also include password-reset tokens, failed jobs, and Sanctum personal access tokens.

## 6. Route and page guide

The full route declarations are in `routes/web.php`. Important entry points include:

| URL | Use | Role |
| --- | --- | --- |
| `/` | Public welcome page | Public |
| `/From_Leal` (`POST`) | Legacy utility page handler; not part of the normal hospital workflow | Public; review before deployment |

Operational routes:

| URL | Use | Role |
| --- | --- | --- |
| `/login`, `POST /loginUser` | Sign in | Public |
| `/dashboard` | Shared/admin dashboard | Authenticated |
| `/dashboardReceptionist` | Receptionist dashboard | Receptionist, admin |
| `/dashboardPharmacist` | Pharmacist dashboard | Pharmacist, admin |
| `/patient` and `/patient/{patient}` | Patient index and details | Receptionist, admin |
| `/patient-certificates` | Certificate patient search | Receptionist, admin |
| `/medicine` and `/medicine/{medicine}` | Medicine inventory | Pharmacist, admin |
| `/MedicineByBatch`, `POST /storeByBatch` | Batch entry | Pharmacist, admin |
| `/despenseMedicine` | Dispense medicines | Pharmacist, admin |
| `POST /despenseMedicineReciept` | Preview dispense receipt | Pharmacist, admin |
| `POST /recordDespenseMedicine` | Commit dispense and reduce stock | Pharmacist, admin |
| `/despenseMedicineList` | Dispensing history | Pharmacist, admin |
| `/doctors` | Doctor list/management | Admin routes |
| `/assistanceRequest` | Assistance request management | Admin |
| `/reports` | Overall reporting | Admin |
| `/medicineRecordsReport` | Medicine report | Pharmacist, admin |
| `/patientRecordsReport` | Patient report | Receptionist, admin |
| `/user` | User administration | Admin |
| `/user/{user}` | Profile view | Authenticated roles |
| `DELETE /logoutUser` | Sign out | Authenticated |

## 7. User interface and visual conventions

The shared authenticated shell (`resources/views/layouts/app.blade.php`) has a fixed-width, scrollable left sidebar, a topbar, and a white rounded content surface. The sidebar changes its sections by role. The topbar includes a sidebar toggle, notifications, current username/role, and logout.

The login screen is a separate centered composition. Most data-entry and detail pages use Bootstrap forms, cards, tables, badges, modals, and pagination. Some pages refresh portions of a list or detail area through AJAX. Certificate, receipt, report, and other print views use separate layouts.

The style foundation is Bootstrap's primary blue (`#0d6efd`) with Bootstrap semantic states (success `#198754`, warning `#ffc107`, danger `#dc3545`, info `#0dcaf0`), white content cards, and gray neutral text/surfaces. Sass sets a light body-background variable (`#f8fafc`). Bootstrap Icons are used for navigation and actions. Sidebar navigation groups are collapsible.

## 8. Development setup

Requirements: PHP 8.1+, Composer, Node.js/npm, and a Laravel-supported database.

1. Install PHP dependencies: `composer install`.
2. Install browser dependencies: `npm install`.
3. Create `.env` from `.env.example`, configure the database, and set the application key with `php artisan key:generate`.
4. Create tables with `php artisan migrate`.
5. Build assets with `npm run build` (or run `npm run dev` during development).
6. Run the web app with `php artisan serve`.
7. Run tests with `php artisan test`.

Use real application accounts to sign in; seeders or installation scripts should be consulted for environment-specific bootstrap accounts. Do not commit `.env`, passwords, database credentials, or real patient data.

## 9. Source map

| Concern | Main sources |
| --- | --- |
| Routes and access | `routes/web.php`, `app/Http/Kernel.php`, `app/Http/Middleware/IsUserType.php` |
| Login/profile/users | `app/Http/Controllers/AuthenticationController.php`, `app/Http/Controllers/UserController.php`, `app/Models/User.php` |
| Patients/cases/certificates | `app/Http/Controllers/PatientController.php`, `app/Http/Controllers/PatientCertificateController.php`, `app/Models/Patient.php`, `app/Models/PatientCase.php` |
| Medicine and dispensing | `app/Http/Controllers/MedicineController.php`, `app/Models/Medicine.php`, `app/Models/BatchMedicine.php`, `app/Models/DespenseMedicine.php` |
| Doctors/assistance | `app/Http/Controllers/DoctorController.php`, `app/Http/Controllers/RequestAssistanceController.php` |
| Dashboards/reports | `app/Http/Controllers/ReportsController.php` |
| Notifications/login activity | `app/Notifications/NewPatient.php`, `app/Listeners/`, `app/Providers/EventServiceProvider.php` |
| UI | `resources/views/`, `resources/sass/`, `resources/css/`, `resources/js/` |
| Schema | `database/migrations/` |

## 10. Testing notes

Feature coverage currently includes patient certificate search/PDF output and pharmacy workflows. Pharmacy tests exercise password updates followed by pharmacist login, successful stock subtraction and dispense recording, receipt-preview input validation, and rollback when a multi-medicine dispense cannot be fully fulfilled. Run the complete suite with `php artisan test`.

## 11. Known limitations and implementation notes

These are important considerations for maintenance and future porting; this guide does not silently treat them as completed features:

- The database stores operational data using text identifiers such as `case_no`, `medicine_id`, and doctor license number. Many associations are application-level joins rather than declared foreign keys.
- `patient_cases` and `assistance_requests` have dedicated controllers, but not every conventional resource action is exposed or implemented. `PatientCaseController` is not registered as a web resource route.
- Assistance-request `show`/`destroy` controller actions are placeholders; request creation and status update are the useful workflow paths.
- Doctor edit/update controller methods are placeholders. Doctor routes are in the admin access group, while the sidebar also renders the doctor-list link for receptionists; align the UI and route policy before relying on receptionist doctor management.
- The CSV import UI/controller has paths in place, but the import controller returns parsed rows for a review view rather than persisting those rows as inventory.
- The medicine receipt PDF controller currently returns a test PDF rather than a completed medicine-receipt PDF flow; dispensing uses a Blade preview and confirmation form.
- A standalone desktop client, a dedicated application API, offline synchronization, and multi-device conflict handling are not implemented in this repository.
- Dashboard aggregates are computed in application code and should be validated against the intended clinical/reporting definitions before being used for formal decision-making.
- The project uses legacy field names and spellings (for example `despense`, `mesurement`, `pakage_type` in form inputs). Treat those as existing interfaces until a deliberate migration updates the database, validation, views, and reports together.

For additions to the system, update the routes, access rules, controller validation, persistence behavior, Blade views, and feature tests as one workflow. For a desktop adaptation, use the separate [Desktop Port](./Desktop%20Port.md) guide.
