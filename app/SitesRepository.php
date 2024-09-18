<?php

namespace App;

use PDO;

class SitesRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();

        $this->db->exec("CREATE TABLE IF NOT EXISTS sites (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            content TEXT
        )");
    }

    /**
     * @return SiteModel[]
     */
    public function getSites(): array
    {
        $sql = "SELECT * FROM sites";
        $statement = $this->db->query($sql);

        $data = $statement->fetchAll();

        foreach ($data as $key => $site)
        {
            $data[$key] = SiteModel::mapFromDb($site);
        }

        return $data;
    }

    public function findById(int $id): ?SiteModel
    {
        $sql = "SELECT * FROM sites WHERE id = :id";

        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();

        $data = $statement->fetch();

        if (!$data)
        {
            return null;
        }

        return SiteModel::mapFromDb($data);
    }

    public function findBySlug(string $slug): ?SiteModel
    {
        $sql = "SELECT * FROM sites WHERE slug = :slug";

        $statement = $this->db->prepare($sql);
        $statement->bindParam(':slug', $slug);
        $statement->execute();

        $data = $statement->fetch();

        if (!$data)
        {
            return null;
        }

        return SiteModel::mapFromDb($data);
    }

}