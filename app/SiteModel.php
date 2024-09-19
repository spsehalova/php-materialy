<?php

namespace App;

class SiteModel
{
    protected int $id;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public string $name;

    public string $slug;

    public ?string $content;

    public static function mapFromDb(array $data): SiteModel
    {
        $model = new self();

        $model->id = $data['id'];
        $model->name = $data['name'];
        $model->slug = $data['slug'];
        $model->content = $data['content'];

        return $model;
    }

    public function save(): void
    {
        if (isset($this->id)) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function insert(): void
    {
        $db = (new Database())->connect();

        $sql = "INSERT INTO sites (name, slug) VALUES (:name, :slug)";

        $statement = $db->prepare($sql);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':slug', $this->slug);
        $statement->execute();

        $this->id = $db->lastInsertId();
    }

    public function update(): void
    {
        if (!isset($this->id)) {
            return;
        }

        $db = (new Database())->connect();

        $sql = "UPDATE sites SET name = :name, slug = :slug WHERE id = :id";

        $statement = $db->prepare($sql);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':slug', $this->slug);
        $statement->bindParam(':id', $this->id);

        $statement->execute();
    }

    public function delete(): void
    {
        if (!isset($this->id)) {
            return;
        }

        $db = (new Database())->connect();

        $sql = "DELETE FROM sites WHERE id = :id";

        $statement = $db->prepare($sql);
        $statement->bindParam(':id', $this->id);

        $statement->execute();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content
        ];
    }
}