<?php


class Database
{
    public function connect()
    {
        try {
            require_once '/home/mabsherg/config.php';
            //Instantiate a database object
            $dbh = new PDO(DB_DSN, DB_USERNAME,
                DB_PASSWORD);
            //echo "Connected to database!!!";
            return $dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }
    }

    public static function insertMember($newMem)
    {
        $newAdd = $newMem;
        $premium = 0;
        if (get_class($newAdd) == 'PremiumMember'){
            $premium = 1;
            $interests = array_merge($newAdd->getInDoorInterests(),$newAdd->getOutDoorInterests());
            $interests = implode(",", $interests);
        }else{
            $interests = "";
        }
        //$interests = array_merge((array)$newAdd->indoors, (array)$newAdd->outdoors);


        global $dbh;
        //1. define the query
        $sql = "INSERT INTO Members (fname, lname, age, gender, phone, email, state, seeking, bio, interests, premium)
            VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :interests, :premium)";
       /* $sql = "INSERT INTO Members (fname, lname, age, gender, phone, email, state, seeking, bio, interests, premium)
            VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :interests, :premium)";*/
        //2. prepare the statement

        $statement = $dbh->prepare($sql);
        //3. bind parameters
        $statement->bindParam(':fname', $newAdd->getFName(), PDO::PARAM_STR);
        $statement->bindParam(':lname', $newAdd->getLName(), PDO::PARAM_STR);
        $statement->bindParam(':age', $newAdd->getAge(), PDO::PARAM_STR);
        $statement->bindParam(':gender', $newAdd->getGender(), PDO::PARAM_STR);
        $statement->bindParam(':phone', $newAdd->getPhone(), PDO::PARAM_STR);
        $statement->bindParam(':email', $newAdd->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':state', $newAdd->getState(), PDO::PARAM_STR);
        $statement->bindParam(':seeking', $newAdd->getSeeking(), PDO::PARAM_STR);
        $statement->bindParam(':bio', $newAdd->getBio(), PDO::PARAM_STR);
        $statement->bindParam(':interests', $interests, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_STR);

        //4. execute the statement
        $success = $statement->execute();
        //5. return the result
        return $success;
    }

    /**
     * @return array
     */
    public static function getMembers()
    {
        global $dbh;
        //1. define the query
        $sql = "SELECT * FROM Members ORDER BY lname";
        //2. prepare the statement
        $statement = $dbh->prepare($sql);
        //3. bind parameters

        //4. execute the statement
        $statement->execute();
        //5. return the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //print_r($result);
//        if ($result[premium] == 1){
//            $admin = new PremiumMember($result[],$result[],$result[],$result[],$result[],);
//        }else{
//            $admin = new Member($result[],$result[],$result[],$result[],$result[],$result[]);
//        }

        return $result;
    }

    public static function getMemberID($member)
    {

        global $dbh;
        //1. define the query
        $sql = "SELECT member_id FROM Members WHERE fname=:fName, lname=:lName";
        //2. prepare the statement
        $statement = $dbh->prepare($sql);
        //3. bind parameters
        $statement->bindParam(':fName', $member->getFName(), PDO::PARAM_STR);
        $statement->bindParam(':lName', $member->getLName(), PDO::PARAM_STR);
        //4. execute the statement
        $statement->execute();
        //5. return the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //print_r($result);
        return $result;
    }


}