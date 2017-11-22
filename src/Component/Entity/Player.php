<?php

namespace Component\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;
use Component\Entity\Achievement\AchievementDefinitionInterface;
use Component\Entity\Achievement\PersonalAchievementInterface;
use Component\Entity\Achievement\PersonalActionCollection;

class Player implements PlayerInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $username;

    /** @var string */
    protected $email;

    /** @var string */
    protected $imageUrl;

    /** @var PersonalActionCollection */
    protected $personalActions;

    /**
     * @var array|PersonalAchievementInterface[]
     */
    protected $personalAchievements;

    /** @var int */
    protected $score = 0;

    public function __construct()
    {
        $this->personalActions = new ArrayCollection();
        $this->personalAchievements = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPersonalActions(): CollectionInterface
    {
        return $this->personalActions;
    }

    public function getPersonalAchievements(): CollectionInterface
    {
        return $this->personalAchievements;
    }

    public function hasPersonalAchievement(AchievementDefinitionInterface $achievementDefinition): bool
    {
        /** @var PersonalAchievementInterface $personalAchievement */
        foreach ($this->getPersonalAchievements() as $personalAchievement) {
            if ($personalAchievement->getAchievementDefinition()->getName() == $achievementDefinition->getName()) {
                return true;
            }
        }

        return false;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function refreshScore(): int
    {
        $score = 0;
        foreach ($this->getPersonalAchievements() as $personalAchievement) {
            $score += $personalAchievement->getAchievementDefinition()->getPoints();
        }

        $this->setScore($score);

        return $this->getScore();
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }
}