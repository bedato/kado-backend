# Praktische Projektarbeit : Web Application (WBD5204.1) Kado App

## Summary

Kado is an app in which users can register items they have and can get a randomized outfit from those items.
The goal is to solve the "What should i wear today?" problem everybody faces daily.

## Backend-Setup

Requirements for the local setup

-   Docker
-   Terminal to use the .sh scripts
-   Local Laravel Installation (https://laravel.com/docs/8.x/installation)

If you have those installed follow this guide:

1. Start Docker
2. cd into the Project from the Terminal
3. From the Project root (backend) type in scripts/install.sh and let the script install the docker dependencies
4. Migrate and seed the Database with php artisan migrate --seed
5. To checkout the DB use the credentials in the .env fiel
6. The API is setup! The base URL for this api is local.kado.com/api/

**IMPORTANT**
The API-Key is auto generated and can be found in the table "merchants" under api_token.
This API has tokens since it was made with API development principles.

## About the Project structure

This API was made with the Laravel PHP Framework. The API makes use of the MvC-Principle with strict-typed OOP-PHP.

API-Structure - Workflow on this Project

Routes

-   When creating a new endpoint, i started by creating the route. When possible, i worked with apiResources which handles the needed requests (GET, POST, DELETE...). Else a binding to a Controller and the corresponding function is needed. Doing that guides the request into the Meat and Potatos of the API. Like What kind of request is it? What should happen during that request? what kind of validation is needed? which databases will be used.

Model

-   The Model has all the Data logic in it. Basically it defines how the data is inserted / displayed in the Database, if it has Relations and what kind of Relations.

Controller

-   The Controller contains the logic and functions. The methods defined in the controller handle the requests like how should it be saved in the DB? Through which requests does it go? Which validations should be applied? Etc... When the request goes through the controller it will be ready to be sent to the view or in this case as JSON Response.

Request

-   In the Request part (ex. SearchItemsRequest, CreateItemsRequest) is in which the validation is done. Laravel has a easy way to define the validation right in the arrays of the request, for example the password validation on a LoginRequest "'password' => ['required', 'min:6', 'regex:/^(?=._[a-z])(?=._[A-Z])(?=.\*\d).+\$/'],". Here it will check if it is a required field, the max length and the regex it has to go through.
