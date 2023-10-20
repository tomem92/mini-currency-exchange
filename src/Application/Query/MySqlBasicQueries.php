<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Application\Query;

final class MySqlBasicQueries extends BaseConnectionHandler
{
    /**
     * @param string $table
     * @param string $column
     * @param string $value
     * @return array
     */
    public function getResultsBy(string $table, string $column, string $value): array
    {
        $sql = 'SELECT * FROM :table WHERE :column = :value';
        $stmt = $this->prepare($sql);
        $stmt->execute([
            'table' => $table,
            'column' => $column,
            'value' => $value
        ]);

        return iterator_to_array($stmt->getIterator(), false);
    }

    /**
     * @param string $table
     * @param string $column
     * @param string $value
     * @return int
     */
    public function countResultsBy(string $table, string $column, string $value): int
    {
        $sql = 'SELECT * FROM :table WHERE :column = :value';
        $stmt = $this->prepare($sql);
        $stmt->execute([
            'table' => $table,
            'column' => $column,
            'value' => $value
        ]);

        return $stmt->rowCount();
    }

    /**
     * @param string $table
     * @param string $column
     * @param string $value
     * @return array
     */
    public function getScalarResultsBy(string $table, string $column, string $value): array
    {
        $sql = 'SELECT :column FROM :table WHERE :column = :value';
        $stmt = $this->prepare($sql);
        $stmt->execute([
            'table' => $table,
            'column' => $column,
            'value' => $value
        ]);

        return iterator_to_array($stmt->getIterator(), false);
    }

    /**
     * @param string $table
     * @param string $column
     * @param string $value
     * @return array
     */
    public function getOneResultBy(string $table, string $column, string $value): array
    {
        $sql = 'SELECT :column FROM :table WHERE :column = :value LIMIT 1';
        $stmt = $this->prepare($sql);
        $stmt->execute([
            'table' => $table,
            'column' => $column,
            'value' => $value
        ]);

        return $stmt->getIterator()->current();
    }
}
