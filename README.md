# Setup Project
## Create .env File
Copy .env.example file and replace name with .env instead.
## Install Packages
```bash
composer install
```
## Build migration file and migrate database
```bash
php artisan migrate:fresh --seed
```
## User email list for test login
```bash
admin@example.com
```
```bash
blogger@example.com
```
```bash
test@example.com
```
## Same password for test login
```bash
password
```
## Run Server
```bash
php artisan server
```
## Open browser
```bash
http://127.0.0.1:8000
```
