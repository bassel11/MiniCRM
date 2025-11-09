# CRMSystem - Mini CRM Backend

## Table of Contents
1. [Overview](#overview)
2. [Features](#features)
3. [Requirements](#requirements)
4. [Installation & Setup](#installation--setup)
5. [Artisan Commands Used](#artisan-commands-used)
6. [Usage Notes](#usage-notes)

---

## Overview

**CRMSystem** is a mini CRM backend built with **Laravel 12** following **Clean Architecture** principles.  
It manages clients, communications, follow-up tasks, and supports multiple user roles (Admin, Manager, Sales Rep).  

The system demonstrates professional backend practices including:  
authentication, roles & permissions, events, jobs, notifications, scheduled tasks, and API documentation.

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
- VSCode or preferred IDE

---

## Installation & Setup

1. **Environment Setup**
   - Install XAMPP, PHP 8.2, Composer, VSCode

2. **Create GitHub Repository**
   - Create a new repository named `MiniCRM`  

3. **Clone Project**
   ```bash
   cd C:/xampp/htdocs/CRM
   git clone https://github.com/bassel11/CRMSystem.git
   cd CRMSystem

4. **Install Laravel Project**
    - composer create-project laravel/laravel CRMSystem

5. **Install Required Packages**
    - composer require laravel/sanctum
    - composer require spatie/laravel-permission
    - composer require barryvdh/laravel-ide-helper --dev

6. **Database Setup & Migration**
    - php artisan migrate:fresh --seed

7. **Test APIs Using Postman**
8. **Artisan Commands Used**
9. **Controllers**
    - php artisan make:controller Api/ClientController --api
    - php artisan make:controller Api/DashboardController
    - php artisan make:controller Api/CommunicationController --api    
10. **Form Requests**
    - php artisan make:request StoreClientRequest
    - php artisan make:request UpdateClientRequest
    - php artisan make:request StoreCommunicationRequest   
11. **Resources**
    - php artisan make:resource ClientResource
    - php artisan make:resource CommunicationResource  
12. **Policies**
    - php artisan make:policy ClientPolicy --model=Client
13. **Events & Listeners**
    - php artisan make:event CommunicationCreated
    - php artisan make:listener UpdateClientAfterCommunication --event=CommunicationCreated 
14. **Notifications**
    - php artisan make:notification FollowUpDueNotification
15. **Commands**
    - php artisan make:command SendDueFollowUps                