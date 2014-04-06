<?php
class UsersDao {
    static function find($id){
        $id = mysql_real_escape_string($id);
        $query = mysql_query("
            SELECT s.id as id, s.name as name,
                   p.id as permission_id, p.role as role, p.permissions as permissions
            FROM user s
            LEFT OUTER JOIN rating_user_permissions p ON s.id = p.id
            WHERE
            s.id_group = 19
            AND s.id = $id
            ");
        $row = mysql_fetch_array($query);
        if (!isset($row["permission_id"]) or $row["permission_id"]==null){
            self::create_default_permission($row["id"]);
        }
        return new User($row);
    }
    static function all(){
        $users_query = "
            SELECT s.id as id, s.name as name,
                   p.id as permission_id, p.role as role, p.permissions as permissions
            FROM user s
            LEFT OUTER JOIN rating_user_permissions p ON s.id = p.id
            WHERE s.id_group = 19
        ";
        $users_query = mysql_query($users_query);
        $users = array();
        while ($row = mysql_fetch_array($users_query)){
            if (!isset($row["permission_id"]) or $row["permission_id"]==null){
                self::create_default_permission($row["id"]);
            }
            array_push($users, new User($row));
        }
        return $users;
    }

    static function update_permissions($user){
        $id = mysql_real_escape_string($user->id);
        $role = mysql_real_escape_string($user->role);
        $permissions = mysql_real_escape_string(User::permissions_to_string($user->permissions));
        $query = "
            UPDATE rating_user_permissions
            SET role = '$role',
            permissions= '$permissions'
            WHERE id=$id
            ";
        $result = mysql_query($query);
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function create_default_permission($id){
        $query = "
            INSERT INTO rating_user_permissions(id, permissions, role)
            VALUES($id, '', 'operator')
            ";
        $result = mysql_query($query);
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
    }
}