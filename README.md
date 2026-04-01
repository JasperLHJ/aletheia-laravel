# CMS Template Reusability Guide

This document describes how to reuse this CMS template in other repositories and how to add new data types.

## Overview

The CMS template follows a consistent structure:

- **Backend**: Laravel controllers, models, migrations
- **Frontend**: Inertia.js + Vue 3 + PrimeVue
- **Pattern**: Resource routes with Index (DataTable), View, Create, Edit, and Delete

## Adding a New Data Type

Follow these steps to add a new manageable data type (e.g., "Pages", "Tags", etc.).

### 1. Database

Create a migration:

```bash
php artisan make:migration create_pages_table
```

Define your table schema, then run:

```bash
php artisan migrate
```

### 2. Model

Create a model (with factory if you need seeding):

```bash
php artisan make:model Page -f
```

Add `$fillable` and any relationships in the model.

### 3. Controller

Create a resource controller:

```bash
php artisan make:controller PageController --resource
```

Implement `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` following the pattern in `CategoryController`, `PostController`, or `ProductController`:

- `index()`: Return `Inertia::render('Pages/Index', ['pages' => ...])`
- `create()`: Return form with any dropdown data (e.g. categories)
- `store()`: Validate, create, redirect with `->with('success', '...')`
- `show()`: Load model with relations, render View page
- `edit()`: Return form with model and dropdown data
- `update()`: Validate, update, redirect with success flash
- `destroy()`: Delete, redirect with success flash

### 4. Routes

In `routes/web.php`, inside the auth middleware group:

```php
Route::resource('pages', PageController::class);
```

### 5. Vue Pages

Create the following files under `resources/js/Pages/Pages/`:

| File       | Purpose                                      |
| ---------- | -------------------------------------------- |
| `Index.vue`  | PrimeVue DataTable + DataTableActions + Add button |
| `View.vue`   | Card showing all fields, Edit button         |
| `Create.vue` | Form (use `useForm`, PrimeVue inputs)         |
| `Edit.vue`   | Form pre-filled with model data              |

**Reusable components:**

- `DataTableActions.vue` – View, Edit, Delete buttons for each row. Pass:
  - `viewRoute`, `editRoute`, `deleteRoute`
  - `itemId`, `itemName` (for delete confirmation)

- `AuthenticatedLayout.vue` – Use as the layout for all CRUD pages

### 6. Dashboard & Navigation

**Dashboard**: Add a new card in `resources/js/Pages/Dashboard.vue`:

```vue
<Link :href="route('pages.index')" class="block">
  <Card class="h-full transition hover:shadow-md">
    <template #header>
      <div class="flex items-center gap-3 p-4">
        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
          <i class="pi pi-file text-2xl text-primary"></i>
        </span>
        <div>
          <h3 class="font-semibold text-gray-900">Pages</h3>
          <p class="text-sm text-gray-500">Manage static pages</p>
        </div>
      </div>
    </template>
  </Card>
</Link>
```

**Navigation**: Add a `NavLink` and `ResponsiveNavLink` in `resources/js/Layouts/AuthenticatedLayout.vue` for both desktop and mobile menus.

## Code Structure Summary

```
app/
├── Http/Controllers/
│   ├── CategoryController.php
│   ├── PostController.php
│   └── ProductController.php
├── Models/
│   ├── Category.php
│   ├── Post.php
│   └── Product.php

resources/js/
├── Components/
│   └── DataTableActions.vue    # Reusable row actions
├── Layouts/
│   └── AuthenticatedLayout.vue # Layout + Toast for flash messages
└── Pages/
    ├── Categories/  (Index, View, Create, Edit)
    ├── Posts/       (Index, View, Create, Edit)
    └── Products/    (Index, View, Create, Edit)
```

## Flash Messages

Success messages use Laravel's flash session. The `HandleInertiaRequests` middleware shares `flash.success`, and `AuthenticatedLayout` displays it via PrimeVue Toast. Use:

```php
return Redirect::route('pages.index')->with('success', 'Page created.');
```

## Authentication

All CMS routes use `auth` and `verified` middleware. Ensure users are logged in before accessing any CRUD pages.
