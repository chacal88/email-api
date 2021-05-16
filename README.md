<h1>Email API</h1>

## Motivation

A API to send transaction emails with a high degree of certainty.

- HTTP or CLI
- Send emails using Markdown, text or HTML format
- Powerful Service Mailers Fallback engine

## Code Design

#### Code
<i>app/Core</i>

the core is responsible for how the layers can communicate, in this layer it is possible to define interfaces and structures used
#### Domain
<i>app/Domain</i>

The domain is where are the business rules. Here we have framework agnostic classes.

#### Application
<i>app/Application</i>

The application layer is where are the Laravel framework related code.
Like handling Http requests, exceptions, queueing...

#### External
<i>app/External</i>

The external layer is where are the adapters to integrate the domain
with external tools.
Like mail services, the database, logger, messages...

To integrate with a new mail service we would create
a new Mailer class and add the type in the service interface

```php
<?php
declare(strict_types=1);

namespace App\Code\Mailer;

use App\Core\Mailer\EmailToSendInterface;
use App\Core\Mailer\MailerInterface;
use App\Core\Mailer\MailerStrategyInterface;

class NewMailer implements MailerInterface {
    public function send(EmailToSendInterface $emailToSend): bool{
    
    }

    public function getMailerStrategy(): MailerStrategyInterface{
    
    }

    public function setMailerStrategy(MailerStrategyInterface $mailerStrategy): void{
    
    }
}
```


Implement a new Strategy to print the body

```php
use App\Core\Mailer\EmailToSendInterface;
use App\Core\Mailer\MailerStrategyInterface;
class MarkdownStrategy implements MailerStrategyInterface
{
    public function getBody(EmailToSendInterface $emailToSend): string
    {
        return '';
    }

    public function getKey(): string
    {
        return 'text/html';
    }
}
```

## Instructions for running

You can choose to run in two ways

First of all, enter the lumen folder and rename the `.env.example` file to` .env` in order to ensure that the environment variables are right like this as with testing.
### 1) Run the `run.sh` file from the root folder, which can be via terminal with for example:
`sh ./run.sh`

This command will perform a series of steps that you can follow via the terminal, referring to:
1) Build
2) Install the lumen framework dependencies
3) Run migrations to create the tables
4) The environment can be accessed at http://localhost Perform the following steps separately on your terminal within the project folder

### 2) Perform the following steps separately on your terminal within the project folder:

## create the database

`CREATE SCHEMA `mailer`;`

`docker-compose up --build -d`

`docker run --rm --interactive --tty -v $PWD/lumen:/app composer install`

`docker exec -it email-api-php php /var/www/html/artisan migrate`

The environment can be accessed at http: // localhost

### Important

Always be aware that there is no other process running on ports 80, 9000 and 3306 as these will be the ports used when running the docker
## Packages

* Lumen Application framework
* Mailjet: Mailjet driver to send emails
* Sendgrid: Sendgrid driver to send emails

## Running

This are the vars that you will need to set in order to use Mailjet and SendGrid

    MJ_APIKEY_PUBLIC=
    MJ_APIKEY_PRIVATE=
    SENDGRID_API_KEY=

## Sending emails

But basically:

POST /email/send
```json
{
    "from": "no-reply@server.com",
    "to": "test@foo.com",
    "cc": ["test2@foo.com"],
    "format": "markdown",
    "subject": "test",
    "body": "Body text"
}
```

sending by command
docker exec -it email-api-php php /var/www/html/artisan email:start-transaction

## executing the queue
docker exec -it email-api-php php /var/www/html/artisan queue:work 