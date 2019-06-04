# Laravel 5.8  Boilerplate

## Important Note

- The Project is Not yet Completed I was working on the UI part To Integrate the Bootstrap Theme

## Road map

Laravel Biolerplate  is still under heavy development, I decided to ship it in this early stage so you can help me make it better.

Here's the plan for what's coming:

- [ ] Integrate the bootstrap Theme.
- [ ] Add One More Crud To Demonstrate How the Roles and Permisison Works
- [ ] Create Own Crud Generator.
- [ ] Add Model Scopes.
- [ ] Add tests.
- [ ] Much More

## What's inside

- Users/Roles/permissions management function (based on our own code similar to Spatie Roles-Permissions)
- Everything that is needed for CRUDs: model+migration+controller+requests+views

| Email | Password |
| ------ | ------ |
| superuser@application.com | ``` Will be generated During the Time of Seeding  ``` |
| admin@admin.com | ``` secret ``` |

## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL or go to __/login__ and login with default credentials

-   __superuser@application.com__ - __Generated Password While Seeding__  for the super user
-  __admin@admin.com__ - __password__  for the administrator


## License

Basically, feel free to use and re-use any way you want.
