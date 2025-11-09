# CRMSystem - Mini CRM Backend

## Project Overview
CRMSystem is a mini CRM backend built with **Laravel 12**, designed for a remote sales team.  
It tracks **clients**, **communications**, and **follow-up tasks** with multiple user roles (**Admin, Manager, Sales Rep**).  
This system demonstrates **professional architecture**, **Clean Architecture practices**, **events & jobs**, and automated business logic.

---

## Features

### Authentication & Roles
- Token-based authentication using **Laravel Sanctum**
- User roles:
  - **Admin:** full access to all data
  - **Manager:** view all clients, edit team’s clients
  - **Sales Rep:** only access their assigned clients
- Role-based middleware protection for APIs

### Client Management
- CRUD operations for clients
- Fields: `name`, `email`, `phone`, `status`, `assigned_to`, `last_communication_at`
- Automatic status updates:
  - **Hot** → if 3+ communications in the last week
  - **Inactive** → if no communication for 30+ days
- Policies ensure correct access per role

### Communication Logs
- Tracks client interactions: calls, emails, meetings
- Fields: `client_id`, `type`, `date`, `notes`, `created_by`
- Updates `last_communication_at` automatically
- Event-driven updates to client status

### Follow-up Tasks
- Sales Reps can schedule follow-ups
- Automatic notifications for due follow-ups using **Laravel Notifications & Queue**

### Dashboard
Provides key metrics via API endpoints:
- Total clients by status
- Top 5 Sales Reps by active clients
- Clients needing follow-up today
- Average communications per client

---

## Tech Stack
- **Backend:** Laravel 12 (PHP 8.2)
- **Database:** MySQL (XAMPP)
- **Authentication:** Laravel Sanctum
- **Roles/Permissions:** Spatie Laravel Permission
- **Queue/Jobs:** Laravel Queues (database driver)
- **Notifications:** Email/Database
- **Testing:** PHPUnit / Pest
- **Documentation:** Postman collection / optional Swagger (Scribe)
- **Architecture:** Clean Architecture (Domain / Application / Infrastructure)

---

## Setup Instructions

1. Clone the repo:
```bash
git clone https://github.com/yourusername/MiniCRM.git
cd MiniCRM
