

DIRECTORY STRUCTURE
-------------------

      .logs/             contains applications log files
      .runtime/          contains files generated during runtime
      commands/          contains console commands (controllers)
      config/            contains application configurations
      controllers/       contains Web controller classes
      migrations/        contains DB migration files
      models/            contains model classes

      vendor/             contains dependent 3rd-party packages
      www/                contains the entry script and Web resources


REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.4.0.


INSTALLATION
------------

1. Clone or download repository `https://github.com/flankerspb/yii2-apptica-rest`;

1. Run `composer install`;

1. Copy file `config/main-local-example.php` to `config/main-local.php` and configure real DB connection;

1. Configure your host, set web the root directory to `path/to/project/www`;

1. Apply migrations, run `yii migrate`

1. Add required test data to DB, run `yii data/init-test-data`


USAGE
------------

1. Import charts data from Apptica API, run `yii data/update-charts`

1. Get top positions of application by date, GET `http://<your_domain>/appTopCategory?date=<YYYY-MM-DD>`


AUTHOR
------------
Vitaliy Moskalyuk
