<?php

namespace classes;

class User
{
    private $id;
    private $fullname;
    private $email;
    private $password;
    private $is_admin;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $existing_emails = $statement->rowCount();

        //Check if the email is unique
        if ($existing_emails > 0) {
            return $error = "Email already in use";
        } else {

            //If it's unique, save the property
            $this->email = $email;
            return $this;
        }    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        //Encrypt the password
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $password;

        return $this;
    }

        /**
     * @return mixed
     */

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param mixed $is_admin
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    //Magic function __construct that gets called every time a new User() is made
    //Takes one argument: $email which is used to determine what user is taken from the database
    public function __construct($email)
    {

        //Select all of the user's data from the database
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_OBJ);

        //If the search returns a result, set all the objects properties to the properties taken from the database
        if (!empty($user)) {
            $this->id = $user->id;
            $this->fullname = $user->fullname;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->is_admin = $user->is_admin;

        }
    }

    public function save_user()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO users (fullname,email, password) VALUES (:fullname, :email, :password)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":fullname", $this->getFullname());
        $statement->bindValue(":email", $this->getEmail());
        $statement->bindValue(":password", $this->getPassword());

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }

    public static function checkPassword($email, $password): bool
    {
        //Prepared \PDO statement that fetches the password corresponding to the inputted email
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        //Check if the password is correct
        if (isset($result['password'])) {
            if (password_verify($password, $result['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getUsers($user)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the SELECT query
        $statement = $conn->prepare("SELECT * FROM users ");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->execute();

        //Execute query
        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }


    public static function countUsers()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the SELECT query
        $statement = $conn->prepare("SELECT COUNT(*) FROM users ");
        
        $statement->execute();

        //Execute query
        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }

}