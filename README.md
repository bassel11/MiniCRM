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

1- requirements : xampp, php 8.2 ,vscode ,php composer 
2- create new Repository in GitHub MiniCRM
3- in htdocs directory create CRM folder inside it Clone https://github.com/bassel11/CRMSystem.git
3- inside CRM/MiniCRM run :
  - composer create-project laravel/laravel CRMSystem
4- run : 
  - git add. 
  - git commit -m "initial version"
  - git push
5- inside CRMSystem Directory run :
  - composer require laravel/sanctum
  - composer require spatie/laravel-permission
  - composer require barryvdh/laravel-ide-helper --dev
6-run git commands:
  - git add .
  - git commit -m "add clients, communications, and follow_ups migrations"
7- run php artisan migrate:fresh --seed
8- test APIs using postman
9- run php artisan make:controller Api/ClientController --api
10- run command :
  - php artisan make:request StoreClientRequest
  - php artisan make:request UpdateClientRequest
11- make Resources:
  - php artisan make:resource ClientResource
12- run php artisan make:policy ClientPolicy --model=Client
13- run php artisan make:controller Api/DashboardController
14- run: php artisan make:controller Api/CommunicationController --api
15- php artisan make:request StoreCommunicationRequest
16- php artisan make:resource CommunicationResource
17- php artisan make:event CommunicationCreated
18- php artisan make:listener UpdateClientAfterCommunication --event=CommunicationCreated
19- run: php artisan make:notification FollowUpDueNotification
20- run: php artisan make:command SendDueFollowUps

