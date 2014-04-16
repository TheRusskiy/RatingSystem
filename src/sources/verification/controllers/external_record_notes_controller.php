<?php
require_once 'app_controller.php';
//require_once '../';

class ExternalRecordNotesController extends AppController{
    function index(){
        $note = params("record");
        $all = NotesDao::all_external_notes($note);
        return json_encode($all);
    }

    function create(){
        $note = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $note = NotesDao::insert_external_note_from_object($note, $this->current_user());
        return json_encode($note);
    }


    function delete(){
        $note_id = params("note_id");
        $r = array();
        $r["id"] = $note_id;
        NotesDao::delete_external_notes(array($r));
        return "";
    }
}