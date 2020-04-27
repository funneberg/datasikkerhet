<?php

//require __DIR__ . '/vendor/autoload.php';

require '/../../../home/datasikkerhet/vendor/autoload.php';


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\LogglyHandler;
use Monolog\Formatter\LogglyFormatter;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;

use Monolog\Handler\GelfHandler;
use Gelf\Message;
use Monolog\Formatter\GelfMessageFormatter;


//use KarelWintersky\Monolog;

$logger = new Logger('sikkerhet');

/* fillogging */

//$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/log.txt', Logger::DEBUG));   //Logger::DEBUG fortelelr om hvilket niv� skal logges
$logger->pushHandler(new StreamHandler(__DIR__.'/test_log/log.txt', Logger::DEBUG));   //Logger::DEBUG fortelelr om hvilket niv� skal logges

/* Graylog / gelf */

//$transport = new Gelf\Transport\UdpTransport("127.0.0.1", 12201 /*, Gelf\Transport\UdpTransport::CHUNK_SIZE_LAN*/);
$transport = new Gelf\Transport\UdpTransport("127.0.0.1", 12201 /*, Gelf\Transport\UdpTransport::CHUNK_SIZE_LAN*/);
$publisher = new Gelf\Publisher($transport);
$handler = new GelfHandler($publisher,Logger::DEBUG);

$logger->pushHandler($handler);

/* Loggly

$logger->pushHandler(new LogglyHandler('37bd52c9-726b-4ba1-9973-ed42a15392a4/tag/monolog', Logger::INFO));

*/


/* FingersCrossed  - all logging aktiveres n�r et element p� et visst niv� er aktivert (men skriver ogs� tidligere ting fra samme "sesjon".*/

/*
$printer = new StreamHandler(__DIR__ . '/logs/fingers.log');
$fingers = new FingersCrossedHandler($printer, new ErrorLevelActivationStrategy(Logger::ERROR));
$logger->pushHandler($fingers);
*/

/**/



/* Legge til info i alle records */

$logger->pushProcessor(function ($record) {
    $record['extra']['user'] = 'tomhnatt';

    return $record;
});



/**/

/* Mysql-logging  - midlertidig ute av drift...

$db = new PDO('mysql:host=localhost;dbname=monologsimple', "monolog", "monologpass");

$mysqlhandler = new KWPDOHandler($db, 'log', [
        'user' => 'VARCHAR(32)'
], [], Logger::INFO);


$logger->pushHandler($mysqlHandler);

*/

$logger->info('First message');


$logger->warning('First message',['brukernavn' => 'tomhnatt', 'system' => 'testmodul']);


$logger->info('Andre info');

$logger->error('noe gikk skikkelig dritt!');

$logger->info('Tredje info');

?>
