# 📋 DevTrack

> A modern project and task management tool for development teams - Mini Jira clone built with Laravel

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📖 Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [User Roles](#user-roles)
- [API Documentation](#api-documentation)
- [Screenshots](#screenshots)
- [Team](#team)
- [License](#license)

---

## 🎯 About

**DevTrack** is a lightweight project and task management application designed for small development teams. Built as a Solicode Laravel training project, it demonstrates advanced Laravel concepts including **Policies**, **Soft Deletes**, **Accessors**, **Form Requests**, and **RESTful APIs**.

### Problem Statement

A startup in Technopark Agadir struggled with scattered task tracking across WhatsApp, Excel, and notes. Developers lacked clarity on assigned tasks and project progress.

### Solution

DevTrack centralizes project management, enabling Team Leads to create projects, assign tasks, and track progress while Developers focus on updating their task statuses.

---

## ✨ Features

### Core Functionality

- ✅ **User Authentication** - Register, login, logout (Laravel Breeze)
- ✅ **Project Management** - Create, edit, archive, and restore projects
- ✅ **Task Management** - Full CRUD operations with status tracking
- ✅ **Team Collaboration** - Add/remove members with role-based access
- ✅ **Role-Based Authorization** - Team Lead vs Developer permissions
- ✅ **Soft Deletes** - Archive projects without permanent deletion
- ✅ **RESTful API** - JSON endpoint for tasks with accessors
- ✅ **Real-Time Dashboard** - Project overview with task completion stats

### Technical Highlights

- 🛡️ **Policy-Based Authorization** - Zero manual `abort(403)` calls
- 📊 **Zero N+1 Queries** - Eager loading verified with Debugbar
- 🔄 **Accessors & Mutators** - Clean data transformation
- ✅ **Form Request Validation** - Centralized validation rules
- 📱 **Responsive Design** - Tailwind CSS for modern UI
- 🔍 **Debugging Tools** - Laravel Telescope & Debugbar

---

## 🛠️ Tech Stack

| Category | Technology |
|----------|------------|
| **Framework** | Laravel 11 |
| **Language** | PHP 8.2+ |
| **Database** | MySQL 8.0 |
| **Authentication** | Laravel Breeze |
| **Frontend** | Blade Templates + Tailwind CSS |
| **Debugging** | Laravel Telescope, Debugbar |
| **Version Control** | Git + GitHub |
| **Project Management** | Jira |

---

## 🚀 Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL 8.0
- Node.js & NPM

### Step 1: Clone Repository

```bash
git clone https://github.com/YOUR-USERNAME/devtrack.git
cd devtrack