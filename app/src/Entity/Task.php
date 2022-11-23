<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $title = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	private ?\DateTimeInterface $startDate = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	private ?\DateTimeInterface $endDate = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	private ?\DateTimeInterface $dueDate = null;

	#[ORM\ManyToOne(inversedBy: 'tasks')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Todolist $todolist = null;

	#[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'tasks')]
	private Collection $tags;

	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getStartDate(): ?\DateTimeInterface
	{
		return $this->startDate;
	}

	public function setStartDate(?\DateTimeInterface $startDate): self
	{
		$this->startDate = $startDate;

		return $this;
	}

	public function getEndDate(): ?\DateTimeInterface
	{
		return $this->endDate;
	}

	public function setEndDate(?\DateTimeInterface $endDate): self
	{
		$this->endDate = $endDate;

		return $this;
	}

	public function getDueDate(): ?\DateTimeInterface
	{
		return $this->dueDate;
	}

	public function setDueDate(?\DateTimeInterface $dueDate): self
	{
		$this->dueDate = $dueDate;

		return $this;
	}

	public function getTodolist(): ?Todolist
	{
		return $this->todolist;
	}

	public function setTodolist(?Todolist $todolist): self
	{
		$this->todolist = $todolist;

		return $this;
	}

	/**
	 * @return Collection<int, Tag>
	 */
	public function getTags(): Collection
	{
		return $this->tags;
	}

	public function addTag(Tag $tag): self
	{
		if (!$this->tags->contains($tag))
		{
			$this->tags->add($tag);
			$tag->addTask($this);
		}

		return $this;
	}

	public function removeTag(Tag $tag): self
	{
		if ($this->tags->removeElement($tag))
			$tag->removeTask($this);

		return $this;
	}
}