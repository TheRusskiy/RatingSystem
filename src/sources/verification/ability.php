<?php
class Ability {
    public function __construct(){
    }

    public function is_allowed($user, $controller, $action){
        if(!isset($user) || $user == null){
            return false;
        }
        if ($user->role=='admin'){
            return true;
        }
        $allowed_controllers = array('sessions', 'teachers');
        if (in_array($controller, $allowed_controllers)){
            return true;
        }
        if ($controller == 'criteria'){
            if (in_array($action, array('index', 'with_records', 'show', 'fetch_types'))){
                return true;
            }
        }
        if ($controller == 'users'){
            if (in_array($action, array('current'))){
                return true;
            }
        }
        if ($controller == 'record_notes' || $controller == 'external_record_notes'){
            if (in_array($action, array('index'))){
                return true;
            }
            if (in_array($action, array('delete'))){
                $note = NotesDao::find(params("note_id"), $controller == 'external_record_notes');
                if ($note['user_id']==$user->id){
                    return true;
                }
            }
            if (in_array($action, array('create'))){
                return true;
            }
        }
        if ($controller == 'records'){
            $criteria_id = null;
            if (in_array($action, array('index', 'search', 'count', 'search_count'))){
                $criteria_id = params("criteria_id");
            }
            if (in_array($action, array('create', 'update'))){
                $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
                $criteria_id = $record->criteria_id;
            }
            if (in_array($action, array('create'))){
                $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
                $criteria_id = $record->criteria_id;
            }
            if (in_array($action, array('delete'))){
                $record = RecordsDao::find(params("record_id"));
                $criteria_id = $record['criteria_id'];
            }
            if ($criteria_id != null && isset($user->permissions->$criteria_id) && $user->permissions->$criteria_id){
                return true;
            }
        }
        if ($controller == 'external_records'){
            $criteria_id = null;
            if (in_array($action, array('index', 'all'))){
                $criteria_id = params("criteria_id");
            }
            if (in_array($action, array('approve', 'reject'))){
                $record = ExternalRecordsDao::find(params("id"));
                $criteria_id = $record['criteria_id'];
            }
            if ($criteria_id != null && isset($user->permissions->$criteria_id) && $user->permissions->$criteria_id){
                return true;
            }
        }
        return false;
    }
}