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

    private $createdAt;

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
        return $this->created_at;//created_at et non createdAt car en base le champ se nomme created_at
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): Comment
    {
        $this->createdAt = $createdAt;
    }



}
