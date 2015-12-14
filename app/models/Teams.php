<?php

/**
 * Teams
 * 
 * @autogenerated by Phalcon Developer Tools
 * @date 2015-12-14, 10:26:53
 */
class Teams extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $shorthandle;

    /**
     *
     * @var string
     */
    public $flag;

    /**
     *
     * @var string
     */
    public $link;

    /**
     *
     * @var string
     */
    public $season_id;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Matchs', 'team_a', array('alias' => 'Matchs'));
        $this->hasMany('id', 'Matchs', 'team_b', array('alias' => 'Matchs'));
        $this->belongsTo('season_id', 'Seasons', 'id', array('alias' => 'Seasons'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'teams';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Teams[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Teams
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
