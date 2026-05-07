# FGV Inventory Basic - System Specification

## 1) Document Purpose
This document describes the implemented system features and modules based on current routing, controllers, and views in the project. It also defines current user levels, authentication/authorization behavior, and a testing guideline focused on edge cases and scope-creep prevention.

## 2) System Scope (Current Implementation)
The application is a Laravel web app with authentication and three core business modules:
- Inventory Management
- Shop Management
- User Management

Primary implementation artifacts referenced:
- `routes/web.php`
- `app/Http/Controllers/*`
- `app/Http/Requests/*`
- `app/Policies/InventoryPolicy.php`
- `resources/views/**/*`

No API route module is currently implemented (`routes/api.php` not found).

## 3) User Levels and Access Model
Current user-level model inferred from code:

### 3.1 Guest (Unauthenticated)
- Can access public landing page (`/`).
- Can access authentication routes provided by `Auth::routes()` (login, register, password reset).
- Cannot access module routes protected by `auth` middleware.

### 3.2 Authenticated User
- Can access dashboard/home.
- Can access Inventory, Shop, and User route groups through controller-level `auth` middleware.

### 3.3 Resource Owner (Inventory-Specific)
- Inventory authorization enforces ownership checks in policy for selected actions.
- A user can `view`, `update`, and `delete` only owned inventory records.
- A user can `create` inventory only if total owned inventories is below policy threshold.

Note: No role-based levels (for example Admin/Manager/Staff) are currently implemented in persistence or middleware.

## 4) Authentication Specification
Authentication is scaffolded via Laravel Auth:
- Route registration through `Auth::routes()` in `routes/web.php`.
- Standard auth controllers present (`LoginController`, `RegisterController`, password and verification controllers).
- Auth views present under `resources/views/auth`.
- `HomeController` and module controllers apply `auth` middleware (constructor-level protection).

### 4.1 Authenticated Entry Point
- Implemented post-login route is `/home`.

### 4.2 Session and Logout
- Logout is handled through Laravel auth flow and protected endpoint.

## 5) Authorization Specification
Authorization is partially implemented.

### 5.1 Implemented Policy
- `InventoryPolicy` controls:
  - `create`: user can create while count of owned inventories is below limit.
  - `view`, `update`, `delete`: user must own the inventory (`user_id` match).
- `InventoryController` uses `$this->authorize(...)` for several actions.

### 5.2 Modules Without Full Authorization
- `ShopController`: authenticated access exists, but object-level authorization is not enforced consistently.
- `UserController`: authenticated users can access user management routes without policy/gate restriction.

### 5.3 Authorization Gaps (Current Risks)
- Inventory `restore` and `forceDelete` actions do not enforce policy authorization in controller.
- State-changing operations currently use GET routes in several places (`delete`, `restore`, `force-delete`), increasing misuse risk.
- Request classes currently return `true` in `authorize()` and do not add role/resource checks.

## 6) Functional Modules

## 6.1 Inventory Module
### Features
- List inventories (active and deleted sections in index view).
- Create inventory.
- View inventory details.
- Edit/update inventory.
- Soft delete inventory.
- Restore soft-deleted inventory.
- Force delete inventory.

### Primary Routes
- `GET /inventories`
- `GET /inventories/create`
- `POST /inventories/create`
- `GET /inventories/{inventory}`
- `GET /inventories/{inventory}/edit`
- `POST /inventories/{inventory}/edit`
- `GET /inventories/{inventory}/delete`
- `GET /inventories/{inventory}/restore`
- `GET /inventories/{inventory}/force-delete`

### Controllers and Views
- Controller: `InventoryController`
- Views:
  - `resources/views/inventories/index.blade.php`
  - `resources/views/inventories/create.blade.php`
  - `resources/views/inventories/show.blade.php`
  - `resources/views/inventories/edit.blade.php`

### Business Rules (Observed)
- Ownership rule for read/update/delete.
- Create limit rule by owned inventory count.

## 6.2 Shop Module
### Features
- List shops.
- Create shop.
- View shop details.
- Edit/update shop.
- Delete shop.

### Primary Routes
- `GET /shops`
- `GET /shops/create`
- `POST /shops/create`
- `GET /shops/{shop}`
- `GET /shops/{shop}/edit`
- `POST /shops/{shop}/edit`
- `GET /shops/{shop}/delete`

### Controllers and Views
- Controller: `ShopController`
- Views:
  - `resources/views/shops/index.blade.php`
  - `resources/views/shops/create.blade.php`
  - `resources/views/shops/show.blade.php`
  - `resources/views/shops/edit.blade.php`

### Security Note
- Authentication is enabled, but object-level authorization is not fully specified in policy/gate.

## 6.3 User Module
### Features
- List users.
- Create user.
- View user details.
- Edit/update user.
- Delete user.

### Primary Routes
- `GET /users`
- `GET /users/create`
- `POST /users/create`
- `GET /users/{user}`
- `GET /users/{user}/edit`
- `POST /users/{user}/edit`
- `GET /users/{user}/delete`

### Controllers and Views
- Controller: `UserController`
- Views:
  - `resources/views/users/index.blade.php`
  - `resources/views/users/create.blade.php`
  - `resources/views/users/show.blade.php`
  - `resources/views/users/edit.blade.php`

### Security Note
- Any authenticated user can access these operations under current implementation.

## 7) Non-Functional and Governance Notes
- No API boundary module currently defined.
- Authorization consistency is incomplete across modules.
- Some model `fillable` definitions may not fully match controller-assigned attributes.
- Route semantics should prefer HTTP verbs aligned with mutation intent (POST/PATCH/DELETE).

## 8) Test Case Guideline (Edge Cases + Scope Creep Control)

## 8.1 Test Design Principles
- Build test cases from actual route/controller/view behavior.
- Separate tests by level:
  - Request validation tests
  - Controller/authorization tests
  - Feature tests (end-to-end web flow)
- Every bug fix must include a regression test.

## 8.2 Coverage Baseline by Module
For each Inventory, Shop, and User module include:
- Positive path (valid request, expected success response).
- Authentication guard path (guest blocked from protected routes).
- Authorization path (owner/non-owner behavior where applicable).
- Validation failure path (required fields, invalid types, limits).
- Data integrity path (record state after create/update/delete/restore).

## 8.3 Edge Case Checklist
Use this checklist for each endpoint:
- Missing required fields.
- Boundary values (`quantity` min/max, very long `name`/`description`).
- Invalid identifiers (non-existent ID, soft-deleted ID).
- Cross-user access attempt (user A tries to access user B resource).
- Duplicate submissions (double-click create/update).
- Concurrent updates (stale data overwrite risk).
- Unauthorized state transitions (restore/force-delete by non-owner).
- CSRF and method misuse (mutation through GET links).

## 8.4 Authentication and Authorization Test Guidelines
- Verify guest cannot access module routes.
- Verify authenticated user can access allowed pages.
- Inventory policy tests:
  - Owner can view/update/delete.
  - Non-owner denied.
  - Create denied when ownership count threshold reached.
- Explicitly test `restore` and `forceDelete` protections (currently risk area).
- Add tests to prove no privilege escalation through URL manipulation.

## 8.5 Scope Creep Control in Testing
Define and freeze a release test scope before implementation:

### In Scope
- Existing route contracts and current module behavior.
- Security-critical fixes (auth/authz, mass assignment, validation).
- Regressions affecting existing features.

### Out of Scope (Unless Approved Change Request)
- New role hierarchy (Admin/Manager/etc.) if not in approved backlog.
- New API module and integrations.
- UI redesign unrelated to defect or accepted story.
- Refactor-only changes with no functional impact.

### Scope Control Procedure
- Link every test case to a single requirement or bug ID.
- If a discovered issue is outside approved scope, log it as backlog item.
- Use change request approval before expanding test matrix.
- Maintain a release checklist with "must pass" and "deferred" items.

## 8.6 Recommended Priority Test Set
- Priority 1: Authentication guard tests for all module routes.
- Priority 1: Authorization tests for Inventory owner/non-owner.
- Priority 1: Regression tests for delete/restore/force-delete flows.
- Priority 2: Validation matrix tests for create/update forms.
- Priority 2: User and Shop unauthorized access tests.
- Priority 3: UX and navigation consistency tests.

## 9) Suggested Improvement Backlog (From Analysis)
- Introduce explicit RBAC levels (for example Admin, Staff, Viewer) if required by business.
- Implement `ShopPolicy` and `UserPolicy` and enforce in controllers/routes.
- Convert mutation routes to proper HTTP verbs and form submissions with CSRF.
- Align model `fillable` with validated and persisted attributes.
- Add API route structure only when API scope is formally approved.

---

Document status: Draft generated from current codebase behavior and should be updated whenever routes, policies, controllers, or views change.
