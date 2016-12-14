<?php

namespace Adteam\Core\Powerbi\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoreUserTransactions
 *
 * @ORM\Table(name="core_user_transactions", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Adteam\Core\Powerbi\Repository\CoreUserTransactionsRepository")
 */
class CoreUserTransactions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="correlation_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $correlationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="balance_snapshot", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $balanceSnapshot;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="applied_at", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $appliedAt;

    /**
     * @var \Adteam\Core\Powerbi\Entity\OauthUsers
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Powerbi\Entity\OauthUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return CoreUserTransactions
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return CoreUserTransactions
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set correlationId
     *
     * @param integer $correlationId
     *
     * @return CoreUserTransactions
     */
    public function setCorrelationId($correlationId)
    {
        $this->correlationId = $correlationId;

        return $this;
    }

    /**
     * Get correlationId
     *
     * @return integer
     */
    public function getCorrelationId()
    {
        return $this->correlationId;
    }

    /**
     * Set balanceSnapshot
     *
     * @param integer $balanceSnapshot
     *
     * @return CoreUserTransactions
     */
    public function setBalanceSnapshot($balanceSnapshot)
    {
        $this->balanceSnapshot = $balanceSnapshot;

        return $this;
    }

    /**
     * Get balanceSnapshot
     *
     * @return integer
     */
    public function getBalanceSnapshot()
    {
        return $this->balanceSnapshot;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return CoreUserTransactions
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CoreUserTransactions
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set appliedAt
     *
     * @param \DateTime $appliedAt
     *
     * @return CoreUserTransactions
     */
    public function setAppliedAt($appliedAt)
    {
        $this->appliedAt = $appliedAt;

        return $this;
    }

    /**
     * Get appliedAt
     *
     * @return \DateTime
     */
    public function getAppliedAt()
    {
        return $this->appliedAt;
    }

    /**
     * Set user
     *
     * @param \Adteam\Core\Powerbi\Entity\OauthUsers $user
     *
     * @return CoreUserTransactions
     */
    public function setUser(\Adteam\Core\Powerbi\Entity\OauthUsers $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Adteam\Core\Powerbi\Entity\OauthUsers
     */
    public function getUser()
    {
        return $this->user;
    }
}

