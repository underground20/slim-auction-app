<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Ramsey\Uuid\Uuid;

#[Entity(readOnly: true)]
#[Table(name: "auth_user_networks")]
#[UniqueConstraint(columns: ["network_name", "network_identity"])]
class UserNetwork
{
    #[Column(type: "guid")]
    #[Id]
    private string $id;

    #[ManyToOne(targetEntity: User::class, inversedBy: "networks")]
    #[JoinColumn(name: "user_id", referencedColumnName: "user_id", nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[Embedded(class: Network::class)]
    private Network $network;

    public function __construct(User $user, Network $network)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->network = $network;
    }

    public function getNetwork(): Network
    {
        return $this->network;
    }
}
