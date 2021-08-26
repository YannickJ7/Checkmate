<?php


namespace classes;


class Lists
{
    private $id;
    private $user_id;
    private $title;
    private $description;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
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


    public function save_list()
    {
        //Database connection
        $conn = Db::getConnection();


                //Prepare the INSERT query
                $statement = $conn->prepare("INSERT INTO lists (user_id, title, description, deadline) VALUES (:user_id, :title, :description,:deadline)");

                //Bind values to parameters from prepared query
                $statement->bindValue(":user_id", $this->getUserId());
                $statement->bindValue(":title", $this->getTitle());
                $statement->bindValue(":description", $this->getDescription());
                $statement->bindValue(":deadline", $this->getDeadline());

                //Execute query
                $result = $statement->execute();

                //Return the results from the query
                return $result;

            }

    public static function getLists($user)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the SELECT query
        $statement = $conn->prepare("SELECT * FROM lists WHERE user_id = :id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->execute();

        //Execute query
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public static function deleteList($user, $list_id)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the DELETE query
        $statement = $conn->prepare("DELETE FROM lists WHERE user_id = :id AND id = :list_id");


        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":list_id", $list_id);

        //Execute query
        $result = $statement->execute();

        //Database connection
        $conn = Db::getConnection();

        //Prepare the DELETE query
        $statement = $conn->prepare("DELETE FROM tasks WHERE list_id = :list_id");


        //Bind values to parameters from prepared query
        $statement->bindValue(":list_id", $list_id);

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }

    public static function countLists()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the SELECT query
        $statement = $conn->prepare("SELECT COUNT(*) FROM lists ");
        
        $statement->execute();

        //Execute query
        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }

    public static function averageLists($user)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the SELECT query
        $statement = $conn->prepare("SELECT COUNT(*) FROM lists WHERE user_id = user_id");
        
        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());

        $statement->execute();

        //Execute query
        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }
}