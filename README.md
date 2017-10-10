#Base project register job offer


* This project was created for explain a friend how would I do this description under. 

------ xx -----

Create a webpage where a visitor can leave a job vacancy (title and job description). Save al these vacancies in a database. Also make a page where the administrator can look at the vacancies and where he can edit or delete the vacancies. You have to use Frameworks and external libaries; the emphasis is on safety and simplicity. Design is not important

------ xx -----

----- Yesterday October 9th, 2017 -----

## Setup

```
composer install
```

**Setup the Database**


```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

If you get an error that the database exists, that should
be ok. But if you have problems, completely drop the
database (`doctrine:database:drop --force`) and try again.

**Start the built-in web server**

You can use Nginx or Apache, but the built-in web server works
great:

```
php bin/console server:run
```


# I created this way.
* Admin - Can see and edit all jobs - login: admin@gmail.com - pass:123123
* Normal Users can edit only your own Jobs offer

All users including anonymous can see all jobs offer but not edit.

* OBS for users I did not use FOS USER BUNDLE but in general is good - https://symfony.com/doc/current/bundles/FOSUserBundle/index.html
