<?php
/*
 * Copyright (c) 2012 Szurovecz János
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace mf4php\beanstalk\integration;

require_once __DIR__ . '/../../../bootstrap.php';
require_once __DIR__ . '/../SampleObject.php';
require_once 'Config.php';

use lf4php\LoggerFactory;
use lf4php\log4php\Log4phpLoggerFactory;
use mf4php\beanstalk\BeanstalkMessage;
use mf4php\beanstalk\SampleObject;
use mf4php\MessageException;

LoggerFactory::setILoggerFactory(new Log4phpLoggerFactory());

$config = new Config();
$message = new BeanstalkMessage(new SampleObject('szjani@szjani.hu'));
try {
    $config->getDispatcher()->send($config->getQueue(), $message);
} catch (MessageException $e) {
    echo $e->getMessage() . PHP_EOL;
}