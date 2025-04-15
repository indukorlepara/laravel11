php artisan test --filter PostControllerTest
php artisan config:clear
php artisan cache:clear
>php artisan route:clear
php artisan cache:clear
php artisan make:factory PostFactory --model=Post
>php artisan make:test PostControllerTest
php artisan make:export UsersExport --model=User
php artisan tinker
composer require maatwebsite/excel --ignore-platform-reqs

DB::select('SELECT name FROM sqlite_master WHERE type="table"');
DB::table('users')->get();
