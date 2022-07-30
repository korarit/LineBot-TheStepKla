<?php
namespace KRTStudio\Function\Database;

use KRTStudio\Function\Config;

class Table {

    public function get_tablelast(string $tablename){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("SELECT * FROM $tablename ORDER BY id");
        $row = $sql->fetch_assoc();
        $conn->close();

        return $row;
    }

    public function get_table(string $tablename){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("SELECT * FROM $tablename");
        $row = $sql->fetch_assoc();
        $conn->close();

        return $row;
    }
}
?>
<?php
namespace KRTStudio\Function\Database;

use KRTStudio\Function\Config;

class User {

    public function user_add(string $user_id){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("INSERT INTO user (userid_line, level_user) VALUES ('$user_id', '0')");
        $conn->close();

        return true;

    }

    public function user_register(string $user_id){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("UPDATE user SET register='1' WHERE userid_line='$user_id'");
        $conn->close();

        return true;

    }

    public function user_update_function(string $user_id, $function){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("UPDATE user SET main_function='$function' WHERE userid_line='$user_id'");
        $conn->close();

        return true;

    }

    public function user_update_subfunction(string $user_id, $function){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("UPDATE user SET sub_function='$function' WHERE userid_line='$user_id'");
        $conn->close();

        return true;

    }

    public function user_function(string $user_id){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $result = $conn->query("SELECT * FROM user where userid_line='$user_id'");
        $row = $result->fetch_assoc();
        $data = $row['main_function'];
        $conn->close();

        return $data;
    }

    public function user_sub_function(string $line_id){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $result = $conn->query("SELECT * FROM user where userid_line='$line_id'");
        $row = $result->fetch_assoc();
        $data = $row['sub_function'];
        $conn->close();

        return $data;
    }
}
?>
<?php
namespace KRTStudio\Function\Database;

use KRTStudio\Function\Config;

class Check {

    public function check_login(string $line_id){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $result = $conn->query("SELECT * FROM user where userid_line='$line_id'");
        $row = $result->num_rows;
        $conn->close();
        if($row == 1){
            return "yes";
        }else{
            return "no";
        }
    }

    public function check_register(string $line_id){

        $config = new Config();

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $result = $conn->query("SELECT * FROM user where userid_line='$line_id'");
        $row = $result->fetch_assoc();
        $data = $row['register'];
        $conn->close();
        
        return $data;
    }
}
?>