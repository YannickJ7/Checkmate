<?php


namespace classes;


class Task
{
    private $id;
    private $user_id;
    private $list_id;
    private $title;
    private $hours;
    private $deadline;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param mixed $list_id
     */
    public function setListId($list_id): void
    {
        $this->list_id = $list_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * @param mixed $hours
     */
    public function setHours($hours): void
    {
        $this->hours = $hours;
    }

    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline): void
    {
        $this->deadline = $deadline;
    }

    public function save_task()
    {
        //Database connection
        $conn = Db::getConnection();

        print_r([ $this->getUserId(),  $this->getListId(),$this->getTitle(),$this->getHours(),   $this->getDeadline() ]);
        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO tasks (user_id,list_id, title, hours, deadline) VALUES (:user_id,:list_id, :title, :hours,:deadline)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":user_id", $this->getUserId());
        $statement->bindValue(":list_id", $this->getListId());
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":hours", $this->getHours());
        $statement->bindValue(":deadline", $this->getDeadline());

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }

    public static function getTasks($user, $list_id)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("SELECT *  FROM tasks  WHERE user_id = :id AND list_id = :list_id  ORDER BY deadline ASC " );

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":list_id", $list_id);

        $statement->execute();

        //Execute query
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public static function deleteTask($user, $task_id)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("DELETE FROM tasks WHERE user_id = :id AND id = :task_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":task_id", $task_id);

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }
}