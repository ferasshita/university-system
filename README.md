# UIMP Core (Laravel 11)

Production-ready UIMP API core with JWT auth, RBAC, UUID entities, audit logging, notifications, and subsystem integration.

## Features
- Laravel 11 API under `/api/v1`
- JWT auth via `tymon/jwt-auth`
- RBAC: roles, permissions, `role_user`, `permission_role`
- UUID primary keys + soft deletes + audit columns on shared entities
- Entities: users, students, employees, faculties, departments, campuses, buildings, rooms, subsystems, audit logs, notification templates/history
- Queue-based append-only audit logging (`AuditLogJob`)
- Notification queue flow (`SendNotificationJob`)
- Services: `AuditService`, `NotificationService`, `RolePermissionService`
- Middleware: `JwtAuth`, `Role`, `SetLocale`, `SessionTimeout`, optional TLS enforcement
- i18n messages in `lang/en/messages.php` and `lang/ar/messages.php`
- Subsystem Redis pub/sub placeholder via `dispatch_subsystem_event()`

## Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
php artisan serve
```

## API conventions
- Prefix: `/api/v1`
- Response envelope:
```json
{ "status": "success|error", "data": {}, "message": "..." }
```
- Language from `Accept-Language` (`en`/`ar`)

## Main endpoints
- Auth: `POST /auth/login`, `POST /auth/register`, `GET /auth/me`, `POST /auth/logout`
- Students/Employees/Faculties/Departments/Buildings/Campuses
- Rooms CRUD + `POST /rooms/{room}/book`
- Subsystems: `POST /subsystems/register`, `POST /subsystems/{id}/activate|deactivate`, `PUT /subsystems/{id}/config`
- Audit (admin only): `GET /audit-logs`, `GET /audit-logs/{id}`
- Notifications: `POST /notifications/send`, `GET /notifications/history`
- Role assignment (admin): `POST /users/{id}/roles`

## Testing
```bash
php artisan test
```

## Seeded defaults
- Roles: `admin`, `registrar`, `operations`
- Permission set including `room:book`
- Admin user from `.env`: `ADMIN_EMAIL`, `ADMIN_PASSWORD`
