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
    private $upload;
    private $status;

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

    /**
     * @return mixed
     */
    public function getUpload()
    {
        return $this->upload;
    }

    /**
     * @param mixed $upload
     */
    public function setUpload($upload): void
    {
        $this->upload = $upload;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function save_task()
    {
        //Database connection
        $conn = Db::getConnection();

        print_r([ $this->getUserId(),  $this->getListId(),$this->getTitle(),$this->getHours(),   $this->getDeadline() ]);
        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO tasks (user_id,list_id, title, hours, deadline, status) VALUES (:user_id,:list_id, :title, :hours,:deadline, :status)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":user_id", $this->getUserId());
        $statement->bindValue(":list_id", $this->getListId());
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":hours", $this->getHours());
        $statement->bindValue(":deadline", $this->getDeadline());
        $statement->bindValue(":status", "to do");


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

    public static function deleteUpload($task_id)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("DELETE upload FROM tasks WHERE id = :task_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":task_id", $task_id);

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }

    public function doneTask($user, $task_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("UPDATE tasks SET status = :status, user_id = :id WHERE id = :task_id");
        
        $statement->bindValue(':status', "done");
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":task_id", $task_id);

        $result = $statement->execute();

        return $result;

    }

    public function toDoTask($user, $task_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("UPDATE tasks SET status = :status, user_id = :id WHERE id = :task_id");
        
        $statement->bindValue(':status', "to do");
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":task_id", $task_id);

        $result = $statement->execute();

        return $result;

    }

    public static function averageHours($user)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the SELECT query
        $statement = $conn->prepare("SELECT AVG(hours) FROM tasks WHERE user_id = user_id ");
        

        //Bind values to parameters from prepared query

        $statement->execute();

        //Execute query
        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }

    public static function orderTasks($user, $list_id)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("SELECT *  FROM tasks  WHERE user_id = :id AND list_id = :list_id  ORDER BY hours DES " );

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":list_id", $list_id);

        $statement->execute();

        //Execute query
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public function saveUpload($task_id)
    {
        //Put all $_FILES array values in seperate variables
        $fileName = $_FILES['upload']['name'];
        $fileTmpName = $_FILES['upload']['tmp_name'];
        $fileSize = $_FILES['upload']['size'];
        $fileError = $_FILES['upload']['error'];

        //Get the file extension
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        //Make an array with allowed extensions
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'docx');

        if (!(in_array($fileActualExt, $allowed))) {
            //If the file is not a valid extension
            throw new \Exception("Can't save a file of this type.");
        } elseif ($fileSize > 2000000) {
            //If the file is too big
            throw new \Exception("Your file is too big.");
        } else {
            if ($fileError === 0) {
                define ('SITE_ROOT', realpath(dirname(__FILE__)));

                $fileDestination = '../uploads' . $fileName;
                move_uploaded_file($fileTmpName, $fileDestination);

                //Put the file path in the database
                $conn = Db::getConnection();
                $statement = $conn->prepare("UPDATE tasks SET upload = ('" . $_FILES['upload']['name'] . "') WHERE id = :task_id   ");

                $statement->bindValue(":task_id", $task_id);

                $upload = $statement->execute();
                return $upload;
            }
        }
    }

}