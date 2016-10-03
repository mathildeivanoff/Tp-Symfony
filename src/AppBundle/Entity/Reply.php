<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table()
 */

class Reply
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */

    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $comment;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $voteReply;

    /**
    * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkHost = true,
     *     checkMX = true
     *)
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="replies")
     *
     * @var string
     */
    private $subject;
    
    public function __construct()
    {
        $this->voteReply=0;
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVoteReply()
    {
        return $this->voteReply;
    }

    public function setVoteReply($voteReply)
    {
        $this->voteReply = $voteReply;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return text
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param text $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

     /**
     * @param Subject $subject
     */
    public function setSubject(Subject $subject)
    {
         $this->subject = $subject;
    }

    /**
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }



}
