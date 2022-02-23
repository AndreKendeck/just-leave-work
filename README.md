# justleave.work Leave Management Systsem

[![JustLeave.work](https://github.com/AndreKendeck/just-leave-work/actions/workflows/justleave.yml/badge.svg)](https://github.com/AndreKendeck/just-leave-work/actions/workflows/justleave.yml)

This is a web application that allows SMMEs to record and request leave.
Technologies used:
🧶 Laravel 7 (PHP)
🦭 Maria DB (Database)
⚛️ React  (Frontend)

## Installation

1. Clone this repo

```bash 
git clone https://github.com/AndreKendeck/just-leave-work.git justleavework
```
2. Install the composer dependencies

```bash 
composer install -vvv 
```

3. Create an .env file
```bash 
cp .env.example .env
``` 

4. Install the JS dependencies

```bash
npm install
```

5. Compile the JS and CSS

```bash
npm run-dev
```

6. Run the application locally
```bash 
php artisan serve
``` 

**if you use valet you can just link it and run it locally**

```bash
valet link && valet open
```


### Testing
Run the artisan test 🧪 command to run the tests
```bash
php artisan test
```

## Credits

-   [Andre Kendeck](https://github.com/adecks)

