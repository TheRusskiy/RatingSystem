<?php
require_once 'app_controller.php';
//require_once '../';

class RecordNotesController extends AppController{
    function index(){
        $note = params("record");
        $all = RecordsDao::all_notes($note);
        return json_encode($all);
    }

    function create(){
        $note = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $note = RecordsDao::insert_note_from_object($note, $this->current_user());
        return json_encode($note);
    }


    function delete(){
        $note_id = params("note_id");
        $r = array();
        $r["id"] = $note_id;
        RecordsDao::delete_notes(array($r));
        return "";
    }
}