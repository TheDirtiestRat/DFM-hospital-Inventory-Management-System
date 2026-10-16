# Desktop Port

## 1. Purpose

This guide defines a practical, UI-focused plan for adapting DFM Hospital Inventory Management System into a desktop application. It maps the current web application into desktop screens, describes the existing theme, and identifies implementation decisions that must be made before development.

This repository currently contains a Laravel web application, not a desktop application. It has no dedicated desktop API, desktop installer, local data synchronization, or offline mode. Do not assume those capabilities exist.

For current workflows and source layout, see [System Documentation](./SYSTEM_DOCUMENTATION.md).

## 2. Recommended porting principle

Preserve the existing role-based workflows, terminology, patient and medicine identifiers, validation, and stock rules. Treat the desktop app as a new client, not as a second independently editable database.

### Preferred first milestone: managed desktop shell

For the lowest-risk initial port, package a desktop shell that opens the authenticated Laravel application in a controlled WebView. This reuses the current routes, session handling, Blade screens, access middleware, and inventory transactions while adding desktop packaging and window behavior.

Requirements for a WebView-based release:

- Use a trusted, configured HTTPS application origin. Do not allow arbitrary remote URLs or renderer navigation.
- Keep credentials and session cookies inside the WebView's protected storage; do not log passwords or tokens.
- Restrict the shell's native bridge to explicitly approved operations; web content should not receive unrestricted filesystem or process access.
- Provide a safe logout and session-expiry experience.
- Confirm the target environment can reach the server. A WebView shell does **not** make the system available offline.

### Alternative: native desktop UI client

If a fully native interface is required, build an explicit backend API and keep the Laravel server/database authoritative. The current `routes/api.php` does not provide the feature API required by this design.

Before implementation, define API authentication, role authorization, request validation, pagination/filtering, conflict handling, certificate/PDF generation, and release/versioning. Use HTTPS and least-privilege scopes. Do not connect a distributed desktop client directly to a shared production database.

An offline-first desktop app is a separate product scope: it needs a defined synchronization protocol, safe conflict resolution, local encryption, patient-data retention/erase policies, and a rule preventing stale stock from being dispensed. Decide whether offline dispensing is permitted before designing this mode.

## 3. Desktop application navigation and window

### Main authenticated shell

```text
┌────────────────────────────────────────────────────────────────────────────┐
│ DFM Hospital   [menu]                                  [notifications]     │
│                                                     [Name · Role] [Logout] │
├──────────────────────┬───────────────────────────────────────────────────┤
│ Dashboard            │ Breadcrumb / page title          [primary action] │
│ PATIENTS*             │                                                   │
│   Patient list        │ Main content: filters, cards, tables, or form     │
│   Add patient         │                                                   │
│   By barangay         │                                                   │
│   Certificates        │                                                   │
│ MEDICINES*            │                                                   │
│   Inventory           │                                                   │
│   Add / batch         │                                                   │
│   Dispense            │                                                   │
│   Dispensing history  │                                                   │
│ REPORTS*              │                                                   │
│ UTILITIES             │                                                   │
│   Users / profile     │                                                   │
└──────────────────────┴───────────────────────────────────────────────────┘
* Show navigation sections only when authorized.
```

### Window behavior

- Use a resizable application window with a minimum size that keeps important forms and tables usable.
- Keep the sidebar persistent on desktop; allow collapse to icons or a temporary drawer at narrow window sizes.
- Put primary actions in a predictable page-header location. Keep filtering and secondary actions above their table.
- Use a scrollable content region, but avoid nested scroll containers where possible.
- Open detail, edit, and confirmation tasks in an in-window panel/modal or a clearly titled child window; preserve the parent list's filters and scroll position.
- Show loading, empty, success, validation-error, and network-error states explicitly.
- Provide keyboard navigation, visible focus, accessible labels, and confirmations for destructive actions.

## 4. Screen layouts

### 4.1 Sign-in

```text
┌──────────────────────────────────────────┐
│                 DFM logo                 │
│    DFM Hospital Inventory Management     │
│                                          │
│    Username [_______________________]    │
│    Password [_______________________]    │
│                                          │
│    [ Sign in ]                            │
│    Inline error / connection status       │
└──────────────────────────────────────────┘
```

- Retain the existing centered sign-in composition and blue action button.
- Do not expose role selection on sign-in; the authenticated account's role determines permissions and landing page.
- After successful sign-in, land on the dashboard for the authenticated role.
- Never display or store a plaintext password after submission.

### 4.2 Role dashboards

Use a consistent title and KPI-card grid, followed by readable charts or recent-activity tables. Adapt the content to role:

| Role | Desktop dashboard content |
| --- | --- |
| Administrator | Overall counts for users, patients, medicine records/quantity; stock and expiration indicators; patient and dispensing summaries; links to all authorized sections. |
| Pharmacist | Medicine count and stock totals separated by dispensing unit; good, low, and out-of-stock counts; recently/commonly dispensed inventory; direct actions for dispense, add stock, and view dispensing history. |
| Receptionist | Patient total and recent registrations; diagnosis and gender summaries; patient age groups; direct actions for patient search, add patient, and certificates. |

Do not change existing report definitions when rearranging the UI; reconcile calculations with reporting requirements separately.

### 4.3 Patient workspace

**List layout:** page title and “Add patient” action; search and filters (barangay and supported patient filters); paginated table with case number, name, age, barangay, and latest case/diagnosis; actions for view and certificate.

**Patient detail layout:** patient identity and demographic summary at top; tabs/panels for diagnosis history, assistance requests, and dispensed medicines; a clearly labeled action to add a diagnosis. Keep the patient case number visible for lookup and printing.

**Registration layout:** group inputs into Patient identity, Demographic/contact, Physical measurements, and Optional initial diagnosis/case. Mark required fields, validate in place, and preserve values after a server-side validation error.

### 4.4 Medicine inventory

**List layout:** medicine name/identifier search; filters for batch, expiration, and stock; a paginated table with identifier, name, type, package/unit, quantity, batch, and expiration; add medicine, batch entry, import, export, edit, and detail actions.

For stock entry, distinguish the supplier package (for example, a box) from the countable dispensing unit (for example, a tablet or mL). Collect package count and units per package, display the calculated available individual-unit quantity before saving, and display strength/content separately with a standard measurement unit. Keep quantity totals separated by dispensing unit on dashboards and reports; never sum tablets and mL into one unlabeled number.

Use clear state badges:

- **In stock** — quantity above the configured low-stock threshold.
- **Low stock** — quantity at or below the existing 100-unit dashboard threshold (confirm whether this threshold should become configurable).
- **Out of stock** — quantity is zero.
- **Expired / expiring** — distinguish actual expiration from the application’s upcoming-expiration filters.

Do not let a visual badge imply that expired inventory is automatically excluded from dispense. Confirm the required policy and enforce it server-side if it should be blocked.

### 4.5 Dispense workflow

Make this a guided and explicit transaction:

```text
┌─────────────────────────────────────┬─────────────────────────────────────┐
│ 1. Patient and prescriber           │ 2. Select medicines                 │
│ Patient case [search/select]        │ Search/filter inventory             │
│ Patient identity and latest case    │ Medicine | available | quantity     │
│ Doctor license [select]             │ [Add] / selected medicine cart      │
│ Diagnosis [select/enter]             │                                     │
├─────────────────────────────────────┴─────────────────────────────────────┤
│ Selected items | requested quantity | available stock | remove            │
│ [Review dispensing receipt]                                                │
└────────────────────────────────────────────────────────────────────────────┘

Review → confirm → one atomic server transaction → success/receipt.
```

- Show the selected patient's name and case number to prevent misidentification.
- For each medicine, show current quantity, requested quantity, and unit. Reject blank, zero, negative, fractional, duplicate, or over-stock selections.
- Receipt review is not a stock change. Commit only on explicit confirmation.
- Use one server-authoritative transaction for all selected medicines and dispense records. If any item fails, none of the stock changes should remain.
- On success, show the recorded items and quantities. On insufficient stock, identify the item and refresh stock before retrying.
- Prevent accidental double submission while the transaction is pending. For a native API client, add an idempotency mechanism before network retries can repeat a dispense.
- Present server validation and network failures as errors, never as a success-shaped receipt.

### 4.6 Doctors, assistance, users, and profile

- **Doctors:** searchable list with name/license, detail/history view, and admin-only management actions consistent with the backend's actual access policy.
- **Assistance:** request list with patient, request type/date, and status; admin review screen for status decisions and patient context.
- **Users:** admin-only table and create/update forms for username, email, role, and confirmed password. Profile view shows account activity without exposing password data.
- **Notifications:** topbar/inbox dropdown with unread state, message, target navigation, and mark-as-read action.

Ensure every visible action is authorized by the server, even if the client hides it based on role.

### 4.7 Reports, certificates, and printing

- Keep report filters above their result/chart area, and provide a clear print/export action where supported.
- For certificates, allow preparation directly from patient search results or patient details, choose medical or death certificate, show only the corresponding required fields, validate, then preview/print PDF. Do not make access depend on a modal.
- Keep paper-oriented content in a print view that excludes navigation and desktop chrome.
- Preserve the existing A4 portrait certificate output until the required form is reviewed.

## 5. Visual theme and color tokens

The web app uses Bootstrap conventions. Use the following as the compatibility palette for a desktop redesign. Semantic colors should be reserved for meaning, not decoration.

| Token | Current reference | Desktop usage |
| --- | --- | --- |
| Primary | Bootstrap blue `#0d6efd` | Primary buttons, selected navigation, links, topbar accents. |
| Page background | Sass variable `#f8fafc`; Bootstrap neutral surfaces are also present | Main window background behind cards. |
| Surface | White `#ffffff` | Tables, cards, forms, dialogs, and content panels. |
| Main text | Bootstrap dark `#212529` | Body copy, labels, table values. |
| Muted text | Bootstrap gray `#6c757d` | Supporting details, timestamps, helper copy. |
| Border/divider | Bootstrap gray `#dee2e6` | Separators, input borders, table rules. |
| Success | Bootstrap green `#198754` | Completed/success feedback. |
| Warning | Bootstrap yellow `#ffc107` | Low-stock and caution states; pair with readable dark text. |
| Danger | Bootstrap red `#dc3545` | Errors, destructive actions, expired stock where policy requires. |
| Info | Bootstrap cyan `#0dcaf0` | Informational status and neutral guidance. |

The existing interface uses Bootstrap primary-blue controls and white rounded content surfaces, with Bootstrap Icons. Preserve these cues so current users recognize the desktop UI. Avoid adopting unrelated theme colors found in unused legacy styles. Verify contrast for all text, badges, focus indicators, and disabled states.

### Typography and spacing

- Use the operating system's legible sans-serif UI font; the Sass base sets a generic sans-serif family.
- Maintain a clear hierarchy: page title, section title, field label, value/help text.
- Reuse consistent spacing and control heights. Keep data tables compact enough for inventory work while maintaining readable row spacing.
- Use rounded panels modestly, reflecting the existing Bootstrap `rounded-*` surfaces without applying excessive decoration.
- Prefer icons with text labels for critical actions such as Dispense, Delete, and Print.

## 6. Interaction and state requirements

Every data screen should support loading, empty, populated, validation-error, permission-denied, offline/server-unavailable, and success states. For mutations:

1. Validate locally for fast feedback.
2. Submit to the server and treat server validation as authoritative.
3. Disable duplicate submission while waiting; retain entered values on failure.
4. Confirm destructive actions and show a completion message after success.
5. Refresh affected counts/lists after committed changes.

For patient and medicine search, debounce text input where appropriate, preserve filters when opening/closing details, and make empty search results distinct from a failed request.

## 7. Desktop security and data protection

Patient records and dispensing history are sensitive. A port should:

- Enforce role authorization at the backend on every operation; UI role checks are not security controls.
- Use TLS for remote connections, secure session/token storage, and least-privilege authentication.
- Avoid storing real patient information in logs, crash reports, analytics, or test fixtures.
- Protect local caches and exported files; define logout cache clearing and retention behavior.
- Restrict file import/export paths and validate file types/size/content before processing.
- Keep an audit trail of dispensing and administrative changes. Do not silently rewrite inventory counts.
- Make backups and restore procedures part of deployment and support documentation.

## 8. Port milestones

1. **Confirm product decisions:** target OS, backend hosting, always-online versus offline behavior, concurrent users, printing needs, installation/update method, and support model.
2. **Inventory workflows:** map each existing route to a screen and role; agree on report definitions and unfinished workflows.
3. **Choose architecture:** managed WebView shell for reuse, or native UI plus a documented API. Keep the Laravel database authoritative in either case.
4. **Build the visual shell:** sign-in, authenticated navigation, page content surface, notifications, role switching only through account/session changes.
5. **Port workflows incrementally:** patients/cases and certificates; medicine inventory; atomic dispensing; doctors/assistance; reports and account management.
6. **Validate parity and safety:** access-control tests, quantity/rollback tests, API/network failure tests, PDF/print checks, keyboard/accessibility tests, and supported-screen-size checks.
7. **Package and operate:** code signing, secure configuration, installer/update strategy, logging/privacy review, backups, support process, and release verification.

## 9. Decisions required before implementation

The following are not specified by this repository and should be decided with the system owner:

- Which desktop platforms and minimum OS versions are in scope?
- Must the desktop client work when disconnected from the Laravel server?
- If offline use is required, may dispensing occur using cached stock, or must dispensing remain online?
- Will the desktop client reuse the Laravel web UI in a WebView, or use a native UI backed by a new API?
- Where will the authoritative server/database be hosted, and how will desktop clients authenticate?
- Which reports, role permissions, and partially implemented features are required for the first release?
- Which printers, paper sizes, and local file import/export locations must be supported?
- What audit, retention, backup, and device-loss requirements apply to patient data?

## 10. Source references for current behavior and styles

- Shared shell/sidebar/topbar: `resources/views/layouts/app.blade.php`, `resources/views/components/sidebar.blade.php`, `resources/views/components/topbar.blade.php`.
- Login and role redirects: `resources/views/authentication/login.blade.php`, `app/Http/Controllers/AuthenticationController.php`.
- Route policies: `routes/web.php`, `app/Http/Middleware/IsUserType.php`.
- Patient forms/details/certificates: `resources/views/patient/`, `app/Http/Controllers/PatientController.php`, `app/Http/Controllers/PatientCertificateController.php`.
- Inventory and dispensing: `resources/views/medicine/`, `app/Http/Controllers/MedicineController.php`.
- Theme/build: `resources/sass/_variables.scss`, `resources/sass/app.scss`, `resources/css/app.css`, `resources/js/app.js`, `vite.config.js`.
- Data schema: `database/migrations/`.
