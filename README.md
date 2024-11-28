## Test Project Qoden

This is my test project for Qoden to make a Laravel project of a patients API.
It has 2 API endpoints and has a command that gets Patient data from an 'external API' that should update and add new Patients to the database.
It only updates Patients if there are changes detected.


## Setup
Make sure to run the migrations using `php artisan migrate`.
I was using xampp to start the Apache/MySql server, you can start the project by using the command `php artisan serve`

## API
This API has these endpoints so far:
`/api/patients` - To get all Patients from the database 
`/api/patients/{id}` - To get a specific Patient by ID 

### Testing
For testing, having data in the database can be nice. Since i don't have the external API i made a seeder instead.
Add 5 Patients to the database: `php artisan db:seed --class=PatientSeeder`
Command to sync Patients from 'external API': `php artisan app:sync-patients {id?}`  (optional, id to get specific Patient)

Note to sync command: since there is no actual external API, getting all patients returns 3 patiens either new or existing in database already.
Adding an ID in the command returns the existing patient in the database or creates a new random one with the ID.
These functionalities obviously wouldn't exist with an actual external API connection, its to give insight how it might work.
