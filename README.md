# CRMSystem - Mini CRM Backend

## Overview

CRMSystem is a mini CRM backend built with **Laravel 12** and follows **Clean Architecture** principles.  
The system manages clients, communications, follow-up tasks, and supports multiple user roles (Admin, Manager, Sales Rep).  
It demonstrates professional backend practices including authentication, roles & permissions, events, jobs, notifications, scheduled tasks, and API documentation.

---

## Features

- **Authentication & Roles**
  - Laravel Sanctum token-based authentication
  - Three roles: Admin, Manager, Sales Rep
  - Role-based access middleware
- **Client Management**
  - CRUD operations on clients
  - Auto-status updates based on communication logs
  - Assigned clients per Sales Rep
- **Communication Logs**
  - Records calls, emails, meetings
  - Updates client's `last_communication_at` automatically
  - Event-driven updates
- **Follow-ups**
  - Schedule follow-up tasks
  - Automated notifications for due follow-ups
- **Dashboard**
  - Clients by status
  - Top sales reps by active clients
  - Clients needing follow-up today
  - Average communication per client
- **Clean Architecture**
  - Domain / Application / Infrastructure layers
  - Policies, Resources, Requests
- **Testing & Documentation**
  - Unit and Feature tests
  - Postman collection & optional Swagger docs
- **Queue & Scheduler**
  - Laravel queue for notifications
  - Scheduler for client status updates and follow-ups

---

## Requirements

- PHP 8.2+
- Composer
- MySQL / SQLite
- XAMPP (Windows) or equivalent environment
- Node.js (optional for frontend)

---

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/MiniCRM.git
cd MiniCRM
