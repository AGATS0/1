<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\EntityManagerInterface;


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
        $qb = $this->em->createQueryBuilder();
        $qb->select('c')
            ->from(Comment::class, 'c')
            ->where('c.post = :post')
            ->andWhere('c.isApproved = 1')
            ->setParameter('post', $this);
            
        $comments = $qb->getQuery()->getResult();

        return new ArrayCollection($comments);
    }


    public function getCommentWithMaxLikes(): Comment
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('c')
            ->from(Comment::class, 'c')
            ->where('c.post = :post')
            ->setParameter('post', $this)
            ->orderBy('c.likes', 'DESC')
            ->setMaxResults(1);

        $comment = $qb->getQuery()->getOneOrNullResult();

        return $comment;
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
