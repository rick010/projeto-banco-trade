<?php

namespace App\Entity;

use App\Repository\ContaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContaRepository::class)]
class Conta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $numeroConta = null;

    #[ORM\Column(nullable: true)]
    private ?float $saldo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'contas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'contas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agencia $agencia = null;

    #[ORM\ManyToOne(inversedBy: 'contas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Perfil $tipoPerfil = null;

    #[ORM\OneToMany(mappedBy: 'destino', targetEntity: Transacao::class, cascade: ['remove'])]
    private Collection $transacoes;

    public function __construct()
    {
        $this->transacoes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroConta(): ?string
    {
        return $this->numeroConta;
    }

    public function setNumeroConta(string $numeroConta): self
    {
        $this->numeroConta = $numeroConta;

        return $this;
    }

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(?float $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAgencia(): ?Agencia
    {
        return $this->agencia;
    }

    public function setAgencia(?Agencia $agencia): self
    {
        $this->agencia = $agencia;

        return $this;
    }

    public function getTipoPerfil(): ?Perfil
    {
        return $this->tipoPerfil;
    }

    public function setTipoPerfil(?Perfil $tipoPerfil): self
    {
        $this->tipoPerfil = $tipoPerfil;

        return $this;
    }

    /**
     * @return Collection<int, Transacao>
     */
    public function getTransacoes(): Collection
    {
        return $this->transacoes;
    }

    public function addTransaco(Transacao $transaco): self
    {
        if (!$this->transacoes->contains($transaco)) {
            $this->transacoes->add($transaco);
            $transaco->setDestino($this);
        }

        return $this;
    }

    public function removeTransaco(Transacao $transaco): self
    {
        if ($this->transacoes->removeElement($transaco)) {
            // set the owning side to null (unless already changed)
            if ($transaco->getDestino() === $this) {
                $transaco->setDestino(null);
            }
        }

        return $this;
    }
}
