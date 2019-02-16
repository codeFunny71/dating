<?php

/**
 * Class PremiumMember
 */
class PremiumMember extends Member
{
    private $_inDoorInterests = [];
    private $_outDoorInterests = [];

    /**
     * PremiumMember constructor.
     * @param array $_inDoorInterests
     * @param array $_outDoorInterests
     * Member constructor.
     * @param $_fName
     * @param $_lName
     * @param $_age
     * @param $_gender
     * @param $_phone
     * @param $_email
     * @param $_state
     * @param $_seeking
     * @param $_bio
     */
    public function __construct($_fName, $_lName, $_age, $_gender, $_phone, $_email="", $_state="", $_seeking="", $_bio="", array $_inDoorInterests=[], array $_outDoorInterests=[])
    {
        parent::__construct($_fName, $_lName, $_age, $_gender, $_phone, $_email, $_state, $_seeking, $_bio);
        $this->_inDoorInterests = $_inDoorInterests;
        $this->_outDoorInterests = $_outDoorInterests;
    }

    /**
     * @return array
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param array $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return array
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param array $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }


}