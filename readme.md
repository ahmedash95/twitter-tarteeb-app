# Tarteeb Application

Tarteeb is a twitter bot to collect users tweets in a thread. 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development.

### Prerequisites

All you need to have is [Composer](https://getcomposer.org/)  



### Installing

This installation will take you to use Tarteeb bot 

First clone the project:

```
git clone https://github.com/ahmedash95/twitter-tarteeb-app
```

then change directory to `twitter-tarteeb-app` and do 

```
composer install
```

update `config.php` file with your twitter  credentials , then start  server:

```
php -S localhost:8888 index.php
```



## Built With

* [Twitter Streaming API](https://github.com/spatie/twitter-streaming-api) - Library to work with Twitter streaming API
* [Twitter PHP](https://github.com/dg/twitter-php) - PHP library for sending messages to Twitter

