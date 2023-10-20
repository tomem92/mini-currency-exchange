<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Application\Query;

class BaseConnectionHandler extends \PDO
{
    private const DSN = 'mysql:dbname=fakedb;host=127.0.0.1';
    private const USER = 'fakeuser';
    private const PASSWORD = 'fakepass';

    public function __construct()
    {
        parent::__construct(self::DSN, self::USER, self::PASSWORD);

        $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
