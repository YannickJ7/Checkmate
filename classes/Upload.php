<?php


namespace classes;


class Upload
{
    private $id;
    private $task_id;
    private $name;


        /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($task_id): void
    {
        $this->task_id = $task_id;
    }
   /**
     * Get the value of status
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of status
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function save_upload()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO uploads (task_id, name) VALUES (:task_id,:name)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":task_id", $this->getTaskId());
        $statement->bindValue(":name", $this->getName());



        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }









}
?>