<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    public function showAllForms()
    {
        $questions = null;
        $result = DB::table('forms')->select('id', 'name');
        $ids = $result->pluck('id');
        $names = $result->pluck('name', 'id');
        $questions_result = DB::table('questions')->whereIn('form_id', $ids)->get();
        foreach ($questions_result as $item) {
            $questions[$item->form_id][] = $item->question;
        }
        return view('forms', compact('questions', 'ids', 'names'));
    }
    public function fill($id)
    {
        $result = DB::table('forms')->find($id);
        $questions = DB::table('questions')->where('form_id', $id)->pluck('question', 'id');
        return view('fill_in_form', ['form_id' => $id, 'name'=> $result->name , 'questions'=>$questions]);
    }
    public function filling($id)
    {
        $leadId = DB::table('leads')->insertGetId(
            ['form_id' => $id, 'created_at' => Carbon::now('Europe/Moscow'), 'updated_at' => Carbon::now('Europe/Moscow')]
        );
        foreach ($_POST as $key=>$item){
            if(str_contains($key, 'question_')) {
                $questionId = str_replace('question_', '', $key);
                DB::table('answers')->insert(
                    ['question_id' => $questionId, 'lead_id' => $leadId, 'value' => $item]
                );
            }
        }
        return redirect()->route('forms');
    }
    public function create()
    {
        return view('edit_form');
    }
    public function editing($id=null)
    {
        if(!$id)
            $formId = DB::table('forms')->insertGetId(
                ['name' => $_POST['name'], 'user_id' => Auth::user()->id]
            );
        else {
            $formId = $id;
            DB::table('forms')->where('id', $formId)->update(['name' => $_POST['name'], 'user_id' => Auth::user()->id]);
        }
        if($_POST['new_question'])
            DB::table('questions')->insert(
                ['question' => $_POST['new_question'], 'form_id' => $formId]
            );
        foreach ($_POST as $key=>$item){
            if(str_contains($key, 'question_')) {
                $questionId = str_replace('question_', '', $key);
                DB::table('questions')->where('id', $questionId)->update(
                    ['question' => $item]
                );
            }
        }
        return redirect()->route('edit_form', ['id' => $formId]);
    }
    public function creating()
    {
        $formId = DB::table('forms')->insertGetId(
            ['name' => $_POST['name'], 'user_id' => Auth::user()->id]
        );
        if($_POST['question'])
            DB::table('questions')->insert(
                ['question' => $_POST['question'], 'form_id' => $formId]
            );
        return redirect()->route('edit_form', ['id' => $formId]);
    }
    public function editForm($id)
    {
        $result = DB::table('forms')->find($id);
        $questions = DB::table('questions')->where('form_id', $id)->pluck('question', 'id');
        return view('edit_form', ['form_id' => $id, 'name'=> $result->name , 'questions'=>$questions]);
    }
    public function results($id)
    {
        $answers = null;
        $answersId = DB::table('leads')->where('form_id', $id)->pluck('id');
        $answers_result = DB::table('answers')->select()->whereIn('lead_id', $answersId)->get();
        foreach ($answers_result as $item) {
            $answers[$item->lead_id][] = ['question_id'=>$item->question_id, 'answer'=>$item->value];
        }
        $questions = DB::table('questions')->where('form_id', $id)->pluck('question', 'id');
        $name = DB::table('forms')->find($id)->name;
        return view('form_results', ['answers'=>$answers, 'name' => $name, 'questions'=>$questions]);
    }
}
