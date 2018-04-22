<?php
/**
 * Created by PhpStorm.
 * User: rom1
 * Date: 22/04/18
 * Time: 19:52
 * PHP version 7
 */

namespace Model;

/**
 * Class Comment
 *
 */
class Comment
{
    private $id;

    private $author;

    private $comment;

    private $created_at;

    private $updated_at;

    private $createdAtFormat;

    private $updatedAtFormat;

    public function __construct()
    {
          $this->setCreatedAtFormat($this->setDateFormat($this->getCreatedAt())); //transformation de la date récupérée en base
          $this->setUpdatedAtFormat($this->setDateFormat($this->getUpdatedAt())); //transformation de la date récupérée en base
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): Comment
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): Comment
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): Comment
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;//created_at et non createdAt car champ doit etre le reflet de la base
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($created_at): Comment
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getCreatedAtFormat()
    {
        return $this->createdAtFormat;
    }

    /**
     * @param mixed $createdAtFormat
     */
    public function setCreatedAtFormat($createdAtFormat)
    {
        $this->createdAtFormat = $createdAtFormat;
    }

    public function getUpdatedAtFormat()
    {
        return $this->updatedAtFormat;
    }

    /**
     * @param mixed $updatedAtFormat
     */
    public function setUpdatedAtFormat($updatedAtFormat)
    {
        $this->updatedAtFormat = $updatedAtFormat;
    }


    /**
     * @param $dateToFormat
     *
     */
    public function setDateFormat($dateToFormat)
    {
        $attr = null;

        if (isset($dateToFormat)) { //$dateToFormat NULL = date du jour
            $dateFormat = new \DateTime($dateToFormat);
            $attr = $dateFormat->format('d/m/Y H:i');
        }

        return $attr;
    }
}
