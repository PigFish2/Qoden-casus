## Test Project Qoden

This is my test project for Qoden to make a Laravel project of a patients API.


## Setup
Make sure to run the migrations using `php artisan migrate`.

## API
This API has these endpoints so far:
`/api/patients` - To get all Patients from the database 
`/api/patients/{id}` - To get a specific Patient by ID 

### Testing
For testing, having data in the database can be nice. Since i don't have the external API i made a seeder instead.
Add 5 Patients to the database: `php artisan db:seed --class=PatientSeeder`
