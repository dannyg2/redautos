<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ContactImport implements ToModel , WithCustomCsvSettings , WithValidation , WithHeadingRow , SkipsOnFailure
{
    private $fieldsFile = [];
    private $user = null;
    public function __construct($fields,$user){
       
        $this->fieldsFile = json_decode($fields,true);
        $this->user = $user;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       
        return new Contact([
            "name"=>$row[$this->fieldsFile["name"]],
            'date_birth'=>$row[$this->fieldsFile["date"]],
            'phone'=>$row[$this->fieldsFile["phone"]],
            'address'=>$row[$this->fieldsFile["address"]],
            'credit_card'=>$row[$this->fieldsFile["credit_card"]],
            'franchise'=>$row[$this->fieldsFile["franchise"]],
            'email'=>$row[$this->fieldsFile["email"]],
            "user_id"=>$this->user->id

        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            //'input_encoding' => 'ISO-8859-1',
            'delimiter' => ";"
        ];
    }

    public function rules(): array
    {
        $validateBd = [
            'name'=>'required|string',
            'date'=>'required',
            'phone'=>'required|numeric',
            'address'=>'required',
            'credit_card'=>'required',
            'franchise'=>'required',
            'email' => ["required","email",function ($attribute, $value, $fail)  {
               
                    $email = Contact::where(['email' => $value, 'user_id' => $this->user->id])->first();
                    if ($email) {
                        $fail('Email ya existente.');
                    }
                
            }],
            
            
        ];
        $validateFile = [];
        foreach ($this->fieldsFile as $key => $value) {
            $validateFile[$value] = $validateBd[$key];
        }
        //dd($validateFile);
        
        return $validateFile;
    }

     /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
       
            $d = new log();
            $d->fill([
                    "row"=>json_encode($failure->row()),
                    "attribute"=>json_encode($failure->attribute()),
                    "errors"=>json_encode($failure->errors()),
                    "values"=>json_encode($failure->values()),
                    "user_id"=>$this->user->id
        
                ]);
                $d->save();
         
            
            //$failure->row(); // row that went wrong
            //$failure->attribute(); // either heading key (if using heading row concern) or column index
            //var_dump($failure->errors()); // Actual error messages from Laravel validator
            //$failure->values(); // The values of the row that has failed.
       }
    }
}
