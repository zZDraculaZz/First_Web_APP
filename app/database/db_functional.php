<?php

class SQLiteDB implements DBInterface
{
    public static $instance = null;
    private SQLite3 $db;
    private function __construct($db_name)
    {
        $this->db = new SQLite3($db_name, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $this->db->query
        (
            "CREATE TABLE IF NOT EXISTS \"users\"
            (
                'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                'admin' TINYINT,
                'email' VARCHAR UNIQUE NOT NULL,
                'age' TINYINT,
                'login' VARCHAR NOT NULL UNIQUE,
                'password' VARCHAR NOT NULL,
                'created' DATETIME DEFAULT CURRENT_TIMESTAMP
            )"
        );
        $this->db->query
        (
            "CREATE TABLE IF NOT EXISTS \"topics\"
            (
                'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                'name' VARCHAR UNIQUE NOT NULL,
                'description' TEXT
            )"
        );
        $this->db->query
        (
            "CREATE TABLE IF NOT EXISTS \"posts\"
            (
                'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                'user_id' INTEGER,
                'topic_id' INTEGER,
                'title' VARCHAR,
                'image' VARCHAR,
                'content' TEXT,
                'status' TINYINT,
                'created' DATETIME DEFAULT CURRENT_TIMESTAMP
            )"
        );
        $this->db->query
        (
            "CREATE TABLE IF NOT EXISTS \"comments\"
            (
                'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                'post_id' INTEGER NOT NULL,
                'user_id' INTEGER NOT NULL,
                'comment' TEXT NOT NULL,
                'created' DATETIME DEFAULT CURRENT_TIMESTAMP
            )"
        );
    }

    public static function get_instance($db_name): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new SQLiteDB($db_name);
        }
        return self::$instance;
    }

    public function search_data($column, $table_name, $column2, $column2_id): bool
    {

        $statement = $this->db->prepare("SELECT \"{$column}\" FROM \"{$table_name}\" 
                                        WHERE \"{$column2}\" = ?");
        $statement->bindValue(1, $column2_id);
        if ($statement->execute()->fetchArray(SQLITE3_NUM)[0])
        {
            return True;
        }
        else
        {
            return False;
        }

    }

    public function insert_data($table_name,$params=[]): void
    {
        $statement = "INSERT INTO \"{$table_name}\" (";
        if(!empty($params))
        {
            $i = 0;
            $prepare_params="";

            foreach ($params as $column => $data)
            {
                if ($i != count($params)-1)
                {
                    $statement = $statement . "\"{$column}\", ";
                    $prepare_params = $prepare_params . ":$column, ";
                }
                else
                {
                    $statement = $statement . "\"{$column}\") VALUES (";
                    $prepare_params = $prepare_params . ":$column)";
                    $statement = $statement.$prepare_params;
                }
                $i++;
            }

            $this->db->exec("BEGIN");
            $statement = $this->db->prepare($statement);
            foreach ($params as $column => $data)
            {
                $statement->bindValue(":$column", $data);
            }
            $statement->execute();
            $this->db->exec("COMMIT");
        }
    }

    public function take_data($select,$table_name,$params=[],$add_params=""): array
    {
        $statement = "SELECT {$select} FROM \"{$table_name}\" ";
        if(!empty($params))
        {
            $i = 0;
            $statement = $statement . "WHERE ";
            foreach ($params as $column => $data)
            {
                if ($i != count($params)-1)
                {
                    $statement= $statement . "\"{$column}\" = :$column AND ";
                }
                else
                {
                    $statement= $statement . "\"{$column}\" = :$column";
                }
                $i++;
            }
            if(!empty($add_params)){
                $statement = $statement . " $add_params";
            }

            $statement = $this->db->prepare($statement);
            foreach ($params as $column => $data)
            {
                $statement->bindValue(":$column", $data);
            }

        }

        if(!empty($add_params) and empty($params))
        {
            $statement = $statement . " $add_params";
            $statement = $this->db->prepare($statement);
        }

        if(empty($add_params) and empty($params))
        {
            $statement = $this->db->prepare($statement);
        }
        $result = $statement->execute();

        $result_array = $result->fetchArray(SQLITE3_ASSOC);
        $multi_array = array();

        while($result_array !== false)
        {
            array_push($multi_array, $result_array);
            $result_array = $result->fetchArray(SQLITE3_ASSOC);
        }
        return $multi_array;

    }

    public function get_all_table($table_name)
    {
        $result = $this->db->query("SELECT * FROM \"{$table_name}\"");

        $result_array = $result->fetchArray(SQLITE3_ASSOC);
        $multi_array = array();

        while($result_array !== false){
            array_push($multi_array, $result_array);
            $result_array = $result->fetchArray(SQLITE3_ASSOC);
        }
        return $multi_array;
    }
    public function get_array_data($table_name,$column,$column_id)
    {
        if($this->search_data($column, $table_name, $column, $column_id))
        {
            return $this->db->query("SELECT * FROM \"{$table_name}\" WHERE \"{$column}\" = \"{$column_id}\"")->fetchArray(SQLITE3_ASSOC);
        }
        else
        {
            return False;
        }
    }

    public function get_data($column,$table_name,$column2,$column2_id)
    {

        if ($this->search_data($column, $table_name, $column2, $column2_id))
        {
            return $this->db->querySingle
            ("SELECT \"{$column}\" FROM \"{$table_name}\" WHERE \"{$column2}\" = \"{$column2_id}\" ");
        }
        else
        {
            return FALSE;
        }
    }

    public function create_user($email,$login,$password,$admin): void
    {
    $this->db->exec("BEGIN");
    $statement = $this->db->prepare("INSERT INTO \"users\" (\"email\", \"login\", \"password\", \"admin\" )
                                            VALUES (:email, :login, :password, :admin)");
    $statement->bindValue(':email', $email);
    $statement->bindValue(':login', $login);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':admin', $admin);
    $statement->execute();
    $this->db->exec("COMMIT");
    }

    public function update_data($table_name, $column1, $data, $column2, $column2_id): void
    {
        if ($this->search_data($column2_id, $table_name, $column2, $column2_id))
        {
            $this->db->exec("BEGIN");
            $statement = $this->db->prepare("UPDATE \"{$table_name}\" SET \"{$column1}\" = ? 
                                            WHERE \"{$column2}\" = \"{$column2_id}\" ");
            $statement->bindValue(1, $data);
            $statement->execute();
            $this->db->exec("COMMIT");
        }
    }
    public function delete_data($table,$column,$column_id): void
    {
        if ($this->search_data($column, $table, $column, $column_id))
        {
            $this->db->exec("BEGIN");
            $this->db->query("DELETE FROM \"{$table}\" WHERE \"{$column}\" = \"{$column_id}\"");
            $this->db->exec("COMMIT");
        }
    }
//    public function equalize_table($table,$id)
//    {
//        while(empty($this->get_array_data($table,"id",$id+1)) === false)
//        {
//            $this->update_data($table,"id",$id,"id",$id+1);
//            $id+=1;
//        }
//    }
}