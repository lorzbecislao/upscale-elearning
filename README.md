# Upscale E-Learning
An advanced e-learning platform powered by Tiptap, a versatile and feature-rich WYSIWYG editor. Designed for seamless content creation and interactive learning experiences, this platform ensures flexibility and a modern user interface tailored for educators and learners alike.

## Technologies Used:
- Laravel 10
- Vue.js 3
- Inertia.js
- Tiptap vue3
- Tailwind CSS

## Installation
1. Install PHP Dependencies: `composer install`
2. Install frontend packages with npm: `npm install`
3. Set Up Environment Variables
   - Duplicate the .env.example file and rename it to .env. Update the following details:
   - Database credentials (e.g., DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
   - Other configurations as needed.
4. Set up the database schema and populate initial data: `php artisan migrate:fresh --seed`
5. Compile and serve the frontend assets for development: `npm run dev`

##
