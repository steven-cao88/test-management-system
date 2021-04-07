<?php

namespace App\Http\Controllers;

use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Question::class);

        $this->validateData();

        $question = Question::create($request->all());

        if ($request->filled('options')) {
            $question->options()->createMany($request->input('options'));
        }

        return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        $this->validateData();

        $question->fill($request->all());

        $question->save();

        if ($request->filled('options')) {
            $question->updateOptions($request->input('options'));
        }

        return $question;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    protected function validateData()
    {
        $validator = Validator::make(request()->all(), [
            'label' => 'required|string|max:255',
            'type' => [
                'required',
                Rule::in(QuestionType::getOptions())
            ],
            'required' => 'boolean|nullable',
            'options' => 'array|nullable',
        ]);

        $validator->after(function ($validator) {
            if ($this->optionDataIsMissing()) {
                $validator->errors()->add(
                    'options',
                    'Missing data in options'
                );
            }
        });

        $validator->validate();
    }

    protected function optionDataIsMissing()
    {
        if (!request()->filled('options')) {
            return false;
        }

        foreach (request()->input('options') as $option) {
            if (empty($option['label']) || empty($option['value'])) {
                return true;
            }
        }

        return false;
    }
}
