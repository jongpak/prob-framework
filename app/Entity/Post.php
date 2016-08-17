<?php

namespace App\Entity;

use \JsonSerializable;

/**
 * @Entity
 * @Table(name="posts")
 */
class Post implements JsonSerializable
{

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $title;

    /**
     * @Column(type="text", length=65535)
     */
    protected $content;


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
