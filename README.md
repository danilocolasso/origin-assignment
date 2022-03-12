[![Maintenance Status][status-image]][status-url]

Origin Backend Take-Home Assignment
===================

## Before install
Make sure you have installed Docker Desktop. If you don't, follow the <a href="https://www.docker.com/get-started" target="_blank">Get Started with Docker</a>.

## Technologies used

- [Docker](https://www.docker.com/) - Containerize the Application.
- [Composer](https://getcomposer.org/) - A Dependency Manager for PHP.
- [Laravel 8.x](https://laravel.com/docs/8.x) - Backend PHP Framework.
- [xdebug 3.x](https://xdebug.org/) - For a better debug, specially with [PHPStorm](https://www.jetbrains.com/phpstorm/).
- [PHPUnit](https://phpunit.readthedocs.io/en/latest/) - A programmer-oriented testing framework for PHP.
- [Data Transfer Objects](https://github.com/spatie/data-transfer-object) - To construct objects from arrays for a cleaner and more consistent code.

## Installation guide

#### Download and unzip the project or clone it from my GitHub
    $ git clone https://github.com/danilocolasso/origin-assignment
    
    $ cd origin-assignment

#### Start the project
    $ make start
Just wait the containers be up and the project build :)

#### The only endpoint is
    Method: POST
    http://localhost:8000/api/insurance/risk
It also requires a header exaclty like that
    
    x-api-key: some-hash

... Or just import cURL on your favorite API Platform tester

    curl --location --request POST 'localhost:8000/api/insurance/risk' \
    --header 'x-api-key: some-hash' \
    --header 'Content-Type: text/plain' \
    --data-raw '{
        "age": 35,
        "dependents": 2,
        "house": {"ownership_status": "owned"},
        "income": 0,
        "marital_status": "married",
        "risk_questions": [0, 1, 0],
        "vehicle": {"year": 2018}
    }'


## Decisions made
- First, I decided to use PHP because I am more familiar with it, as I work with it daily.
- I chose Laravel for the same reason, also because It is one of the most popular PHP frameworks, easy to work and have a clean architeture.
- I decided to split the Service into some business rules for better simplicity, readability and maintainability.
- All the validations are being done in the `InsuranceRequest`, for a cleanner Controller, without any logic.
- Data Transfer Objects make PHP code more consistent since you don't need to worry about a missing index on array. You know exactly what you will have and its type. Also, can have automated casts to Objects and index mapping to/from json.
- No database were used, since we don't have to persist or select anything.
- No authentication was added, just a header token (cross api like) because it's not the assignment focus (I guess). But Lavavel provides some easy to work and worth auth vendors like [Passport](https://laravel.com/docs/8.x/passport) and [Fortify](https://laravel.com/docs/8.x/fortify).

<p align="center">Hope y'all like it</p>
<h4 align="center">
    Made with ♡ by <a href="https://www.linkedin.com/in/danilocolasso/" target="_blank">Danilo Colasso</a>
</h4>

[status-url]: https://github.com/danilocolasso/origin-assignment/pulse
[status-image]: https://img.shields.io/github/last-commit/danilocolasso/origin-assignment
