<?php

/**
 * The class called "Item"
 */
final class Item
{
    /**
     * Item id
     * 
     * @var int
     */
    private $id;

    /**
     * Item name
     * 
     * @var string
     */
    private $name;

    /**
     * Item status
     * 
     * @var int
     */
    private $status;

    /**
     * External change flag
     * 
     * @var bool
     */
    private $changed = false;

    /**
     * Initialization flag
     * 
     * @var boolean
     */
    private $initialized = false;

    /**
     * Raw data from database
     * 
     * @var array
     */
    private $raw_data;


    public function __construct($id)
    {
        $this->id = $id;
        $this->init();
    }

    /**
     * Get object props
     * 
     * @param mixed $propname
     * @return mixed
     */    
    public function __get($propname)
    {
        return $this->$propname;
    }

    /**
     * Set object props with empty and value type check
     * 
     * @param string $propname
     * @param mixed $propvalue
     */
    public function __set($propname, $propvalue)
    {
        // Return on empty value
        if (empty($propvalue))
            return;

        switch ($propname) {
            case 'name':
                if (is_string($propvalue)) {
                    $this->name = $propvalue;
                    $this->changed = true;
                }
                break;
            case 'status':
                if (is_int($propvalue)) {
                    $this->status = $propvalue;
                    $this->changed = true;
                }
                break;
            case 'changed':
                if (is_bool($propvalue)) {
                    $this->changed = $propvalue;
                }
                break;
        }
    }

    /**
     * Item initialization
     *
     * Receives an object data from the database and writes
     * the obtained values ​​to the object properties
     */
    private function init()
    {
        if ($this->initialized) {
            return;
        }
       
        // Pseudo-query returned array
        $result = get_item_from_db('objects', ['name', 'status'], $this->id);

        if ($result) {
            $this->raw_data = $result;
            $this->name = $result['name'];
            $this->status = $result['status'];
            $this->initialized = true;
        }
    }

    /**
     * Save item to database
     */
    public function save()
    {
        if ($this->changed) {
            // Pseudo-query
            update_item_in_db('objects', ['name' => $this->name, 'status' => $this->status], $this->id);
        }
    }
}