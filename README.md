# Support Ticketing System
Support Ticketing System (STS) is a platform for managing customer's tickets. It was created just for improving development skills, practise microservices concept and development approaches.

STS is a project with three modules created as independent services with separate concerns (SoC). There are `User`, `Auth` and `Ticket` microservices. Each microservice is created in different way and with using different tools.

All is working together thanks to Vagrant (Homestead) environment. More information about a setup is available below.

## Ticket microservice
Ticket microservice is the core of whole application and is the most powerful as well. It contains most valuable business logic of the project. This microservice is responsible for managing tickets (create ticket/category, comment ticket, resolve/close ticket).

Used technologies, libraries and approaches:
- PHP 7.4
- Symfony Framework
- PostgreSQL (write models)
- MongoDB (read models)
- Doctrine ORM
- PHPUnit
- CQRS & CommandBus (Tactician)
- DDD

## User microservice
With this microservice we can create a new user account. There are two types of accounts: 
- Admin - can be created through CLI Command
- Customer - can be created through API resource

User microservice fires events and informs other microservices about new user. Cron job publishes messages (events) every minute using MessagePublisher.

Used technologies and libraries:
- PHP 7.4
- Lumen Framework
- MySQL
- Doctrine ORM
- RabbitMQ

## Auth microservice
Auth microservice is responsible for authenticating users through API and generating JWT tokens. With JWT token, user can be authenticated in each microservice. 

Auth module receives events about new user and saves account credentials in cache.

Used technologies and libraries:
- PHP 7.4
- Lumen Framework
- MySQL
- Doctrine DBAL
- RabbitMQ

# Installation
Requirements:
- Composer
- Vagrant
- VirtualBox

1. Clone git repository
2. Go to `.homestead` directory `cd support-ticketing-system/.homestead`
3. Run command `composer install`
4. Run command `vagrant up`

# Postman resources
There is a file in main project directory called `postman.json`. There are all API endpoints for STS app.

# Feedback
Any feedback is welcomed. Just let me know if you have any ideas or have some questions.
