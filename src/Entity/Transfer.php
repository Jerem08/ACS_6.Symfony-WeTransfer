<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransferRepository")
 */
class Transfer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $receiverMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dataLink;

    /**
    * @ORM\Column(type="string")
    */
    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorMail(): ?string
    {
        return $this->authorMail;
    }


    public function setAuthorMail(string $authorMail): self
    {
        $this->authorMail = $authorMail;

        return $this;
    }

    public function getReceiverMail(): ?string
    {
        return $this->receiverMail;
    }

    public function setReceiverMail(string $receiverMail): self
    {
        $this->receiverMail = $receiverMail;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDataLink(): ?string
    {
        return $this->dataLink;
    }

    public function setDataLink(string $dataLink): self
    {
        $this->dataLink = $dataLink;

        return $this;
    }

    public function getFile()
    {
      return $this->file;
    }

    public function setFile($file)
    {
      $this->file = $file;

      return $this;
    }
}
