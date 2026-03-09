<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\EntityManagerInterface;

use function PHPUnit\Framework\isEmpty;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post')]
    private Collection $comments;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->comments = new ArrayCollection();
        $this->em = $em;
    }

    public function getApprovedComments(): Collection
    {
        return $this->comments->filter(function(Comment $comment){// фильтрациия коллекции по входящей функции
            return $comment->isApproved() === true;
        });   
    }


    public function getCommentWithMaxLikes(): ?Comment
    {
        if ($this->comments.isEmpty()) return null;

        $comments = $this->comments->toArray();
        usort($comments,function (Comment $a, Comment $b) { //пользовательская сортировка, можно сортировать даже строки по алфавиту : usort($comments, fn($a, $b) => strcmp($a->getText(), $b->getText()));
            return $b->getLikes() <=> $a->getLikes(); // b<=>a (от большего к меньшему), a<=>b (от меньшего к большему):  15 <=> 5 -> 1, 5 <=> 15 -> -1 , 5 <=> 5 -> 0
        });

        return $comments[0];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }
}
