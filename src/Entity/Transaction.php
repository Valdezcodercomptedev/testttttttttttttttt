<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Service entity class
 */
class Transaction
{
    private $id;
    private $month;
    private $year;
    private $amounts;

    /**
     * ## Validates Service
     * Check if all required fields has been provided
     * 
     * @return array Array of errors
     */

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     *
     * @return self
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     *
     * @return self
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmounts()
    {
        return $this->amounts;
    }

    /**
     * @param mixed $amounts
     *
     * @return self
     */
    public function setAmounts($amounts)
    {
        $this->amounts = $amounts;

        return $this;
    }
}
