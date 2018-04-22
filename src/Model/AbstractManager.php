<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */

namespace Model;

use App\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected $pdoConnection; //variable de connexion

    protected $table;
    protected $className;

    /**
     *  Initializes Manager Abstract class.
     *
     * @param string $table Table name of current model
     */
    public function __construct(string $table)
    {
        $connexion = new Connection();
        $this->pdoConnection = $connexion->getPdoConnection();
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdoConnection->query('SELECT * FROM ' . $this->table, \PDO::FETCH_CLASS, $this->className)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdoConnection->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Get all rows from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectAllById(int $id)
    {
        // prepared request
        $statement = $this->pdoConnection->prepare("SELECT * FROM $this->table WHERE item_id =:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * DELETE on row in database by ID
     *
     * @param int $id
     */
    public function delete(int $id)
    {
       if(isset($id)) {
           $statement = $this->pdoConnection->prepare("DELETE FROM $this->table WHERE id=:id");
           $statement->bindValue('id', $id, \PDO::PARAM_INT);
           $statement->execute();
       }
    }

    /**
     * INSERT one row in dataase
     *
     * @param Array $data
     */
    public function insert(array $data)
    {
        if (isset($data['title'])) {
            //echo "INSERT INTO $this->table (title) VALUES (:title)";
            $statement = $this->pdoConnection->prepare("INSERT INTO $this->table (title) VALUES (:title)");
            $statement->bindValue('title', $data['title'], \PDO::PARAM_STR);
            $statement->execute();
        }

        if (isset($data['comment'])) {
            //echo "INSERT INTO $this->table (item_id, author, comment, created_at) VALUES (".$data['itemId'].", ".$data['author'].", ".$data['comment'].", ".$data['createdAt'].")";
            $statement = $this->pdoConnection->prepare("INSERT INTO $this->table (item_id, author, comment, created_at, updated_at) VALUES (:item_id, :author, :comment, :created_at, :updated_at)");
            $statement->bindValue('item_id', $data['itemId'], \PDO::PARAM_INT);
            $statement->bindValue('author', $data['author'], \PDO::PARAM_STR);
            $statement->bindValue('comment', $data['comment'], \PDO::PARAM_STR);
            $statement->bindValue('created_at', $data['createdAt'], \PDO::PARAM_STR);
            $statement->bindValue('updated_at', $data['createdAt'], \PDO::PARAM_STR);
            $statement->execute();
        }
    }


    /**
     * @param int   $id   Id of the row to update
     * @param array $data $data to update
     */
    public function update(int $id, array $data)
    {
        if (isset($data['title'])) {
            //echo 'UPDATE ' . $this->table . ' SET title = ' . $data['title'] . ' WHERE id = ' . $id;
            $statement = $this->pdoConnection->prepare("UPDATE $this->table SET title = :title WHERE id = :id");
            $statement->bindValue('id', $id, \PDO::PARAM_INT);
            $statement->bindValue('title', $data['title'], \PDO::PARAM_STR);
            $statement->execute();
        }

        if (isset($data['comment'])) {
            $statement = $this->pdoConnection->prepare("UPDATE $this->table SET item_id =:item_id, author =:author, comment =:comment, created_at =:created_at, updated_at =:updated_at WHERE id =:id");
            $statement->bindValue('id', $data['commentId'], \PDO::PARAM_INT);
            $statement->bindValue('item_id', $data['itemId'], \PDO::PARAM_INT);
            $statement->bindValue('author', $data['author'], \PDO::PARAM_STR);
            $statement->bindValue('comment', $data['comment'], \PDO::PARAM_STR);
            $statement->bindValue('created_at', $data['createdAt'], \PDO::PARAM_STR);
            $statement->bindValue('updated_at', $data['updatedAt'], \PDO::PARAM_STR);
            $statement->execute();
        }

    }
}
