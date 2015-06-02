# Cli for CodeIgniter Revolution

This package provides a Cli tool for [CodeIgniterRevolution](https://github.com/CIRevolution/ci)

This includes a few commands and you can create your commands easily.

This is based on Aura.Cli_Project 2.0.

## Included Commands

~~~
generate migration ... Generates migration file skeleton.
migrate            ... Run migrations.
migrate status     ... List all migration files and versions.
seed               ... Seed the database.
run                ... Run controller.
~~~

## Folder Structure

```
codeigniter/
├── app/
    ├── console/
        ├── instance.php ... script to generate CodeIgniter instance
├── cli             ... command file
├── config/         ... config folder
└── vendor/
```

## Requirements

* PHP 5.4.0 or later
* `composer` command
* Git

## Installation

Install this project with Composer:

~~~
$ cd /path/to/codeigniter/
$ composer require cirevolution/cli:1.0.x@dev --dev
~~~

Install command file (`cli`) and config files (`config/`) to your CodeIgniter project:

~~~
$ php vendor/cirevolution/cli/install.php
~~~

* Above command always overwrites exisiting files.
* You must run it at CodeIgniter project root folder.

Fix the paths in `instance.php` if you need.

~~~php
$system_path        = $goRoot . 'vendor/cirevolution/system/src/System';
$application_folder = $goRoot . 'app';
$doc_root           = $goRoot . 'public';
~~~

## Usage

Show command list.

~~~
$ cd /path/to/codeigniter/
$ php cli
~~~

Show help for a command.

~~~
$ php cli help seed
~~~

## Create Database Seeds

Seeder class must be placed in `database/seeds` folder.

`database/seeds/ProductSeeder.php`
~~~php
<?php

class ProductSeeder extends Seeder {

	public function run()
	{
		$this->db->truncate('product');

		$data = [
			'category_id' => 1,
			'name' => 'CodeIgniter Book',
			'detail' => 'Very good CodeIgniter book.',
			'price' => 3800,
		];
		$this->db->insert('product', $data);

		$data = [
			'category_id' => 2,
			'name' => 'CodeIgniter CD',
			'detail' => 'Great CodeIgniter CD.',
			'price' => 4800,
		];
		$this->db->insert('product', $data);

		$data = [
			'category_id' => 3,
			'name' => 'CodeIgniter DVD',
			'detail' => 'Awesome CodeIgniter DVD.',
			'price' => 5800,
		];
		$this->db->insert('product', $data);
	}

}
~~~

## Create User Command

Command class name must be `*Command.php` and be placed in `application/commands` folder.

`application/commands/TestCommand.php`
~~~php
<?php

class TestCommand extends Command {

	public function __invoke()
	{
		$this->stdio->outln('<<green>>This is TestCommand class<<reset>>');
	}

}
~~~

Command Help class name must be `*CommandHelp.php` and be placed in `application/commands` folder.

`application/commands/TestCommandHelp.php`
~~~php
<?php

class TestCommandHelp extends Help {

	public function init()
	{
		$this->setSummary('A single-line summary.');
		$this->setUsage('<arg1> <arg2>');
		$this->setOptions(array(
			'f,foo' => "The -f/--foo option description",
			'bar::' => "The --bar option description",
		));
		$this->setDescr("A multi-line description of the command.");
	}

}
~~~

### Reference

* https://github.com/auraphp/Aura.Cli_Project
* http://auraphp.com/framework/2.x/en/cli/

## How to Run Tests

To run tests, you must install CodeIgniter first.

~~~
$ composer create-project cirevolution/ci codeigniter
$ cd codeigniter
$ composer require cirevolution/cli:1.0.x@dev --dev
$ php vendor/cirevolution/cli/install.php
$ cd vendor/cirevolution/cli
$ composer install
$ phpunit
~~~
