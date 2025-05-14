<?php

namespace App\Models;

use App\Libraries\DB;

abstract class Model
{
    protected string $table;

    protected string $primaryKey = 'id';

    protected array $columns = ['*'];

    protected array $wheres = [];

    protected array $orderBy = [];

    /**
     * Get the columns to be selected.
     *
     * @param string ...$columns
     * @return Model
     */
    public function select(string ...$columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Set where conditions.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return Model
     */
    public function where(string $column, string $operator, mixed $value): static
    {
        $this->wheres[] = [$column, $operator, $value];

        return $this;
    }

    /**
     * Set the order by clause.
     *
     * @param string $column
     * @param string $direction
     * @return Model
     */
    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $this->orderBy[] = [$column, strtoupper($direction)];

        return $this;
    }

    /**
     * Set the order by clause to oldest.
     *
     * @param string $column
     * @return Model
     */
    public function oldest(string $column = 'created_at'): static
    {
        return $this->orderBy($column);
    }

    /**
     * Set the order by clause to newest.
     *
     * @param string $column
     * @return Model
     */
    public function latest(string $column = 'created_at'): static
    {
        return $this->orderBy($column, 'DESC');
    }

    /**
     * Get all records from the table.
     *
     * @return array
     */
    public function all(): array
    {
        $columns = implode(', ', $this->columns);

        $sql = "SELECT {$columns} FROM {$this->table}";

        // Add WHERE clauses if any
        $bindings = [];
        if (!empty($this->wheres)) {
            $whereClauses = array_map(function ($w) {
                return "{$w[0]} {$w[1]} ?";
            }, $this->wheres);

            $sql .= ' WHERE ' . implode(' AND ', $whereClauses);
            $bindings = array_map(fn($w) => $w[2], $this->wheres);
        }

        // Add ORDER BY if any
        if (!empty($this->orderBy)) {
            $orderByParts = array_map(function ($o) {
                return "{$o[0]} {$o[1]}";
            }, $this->orderBy);

            $sql .= ' ORDER BY ' . implode(', ', $orderByParts);
        }

        return DB::query($sql, $bindings);
    }

    /**
     * Find a record by its primary key.
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $columns = implode(', ', $this->columns);

        $sql = "SELECT {$columns} FROM {$this->table} WHERE {$this->primaryKey} = ?";

        return DB::first($sql, [$id]);
    }

    /**
     * Create a new record in the table.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        $stmt = DB::connection()->prepare($sql);

        return $stmt->execute(array_values($data));
    }

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $set = implode(', ', array_map(fn($key) => "{$key} = ?", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";

        $stmt = DB::connection()->prepare($sql);

        return $stmt->execute([...array_values($data), $id]);
    }

    /**
     * Delete a record by its primary key.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = DB::connection()->prepare($sql);

        return $stmt->execute([$id]);
    }

    /**
     * Perform a custom query.
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query(string $sql, array $params = []): array
    {
        return DB::query($sql, $params);
    }

    /**
     * Perform a custom query and get the first result.
     *
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function first(string $sql, array $params = []): ?array
    {
        return DB::first($sql, $params);
    }

    /**
     * Get the count of records in the table.
     *
     * @return int
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) AS count FROM {$this->table}";

        $bindings = [];
        if (!empty($this->wheres)) {
            $whereClauses = array_map(function ($w) {
                return "{$w[0]} {$w[1]} ?";
            }, $this->wheres);

            $sql .= ' WHERE ' . implode(' AND ', $whereClauses);
            $bindings = array_map(fn($w) => $w[2], $this->wheres);
        }

        $result = DB::first($sql, $bindings);

        return $result['count'] ?? 0;
    }
}