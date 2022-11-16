## Project Specifications

**Environment**  

- PHP version: 8.0
- Laravel version: 8.75
- Default Port: 9099
- Config DATABASE in .env
- Swagger URL http://127.0.0.1:9099/api/documentation

**Commands**
- install: 
```bash
composer install
```
- run: 
```bash
php artisan migrate --seed
```
- or restart all: 
```bash
php artisan migrate:refresh --seed
```

```bash
php artisan serve --host=0.0.0.0 --port=9099
```

- test: 
```bash
php artisan test
```
![alt text](https://raw.githubusercontent.com/DanteCuevas/geopagos-tennis-game/main/public/tests.png)