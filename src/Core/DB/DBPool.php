<?php

namespace App\Core\DB;

use App\Core\Abstracts\Singleton;
use PDO;

class DBPool extends Singleton
{
    /** @var PDO[] */
    protected $dbPool = [];
    protected $default = null;

    public function addDb($alias, PDO $pdo)
    {
        $this->dbPool[$alias] = $pdo;

        return $this;
    }

    public function setDefault(PDO $pdo) {
        $this->default = $pdo;

        return $this;
    }

    /**
     * @param string $alias
     * @return PDO
     */
    public function get($alias = null)
    {
        if ($alias === null) {
            return $this->default;
        } elseif (isset($this->dbPool[$alias])) {
            return $this->dbPool[$alias];
        } else {
            throw new \RuntimeException("DB Failure");
        }
    }
}