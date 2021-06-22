<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
// class UsersExport implements FromCollection,WithHeadings
class UsersExport implements FromCollection, WithHeadings,WithMapping
{

    public $count;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('name','email','created_at')->get();
        // return User::all();
        // return User::select('name')->get();
    }
    // use Exportable;


    public function headings(): array
    {
        return ["No", "Name", "E-mail","Data / Time"];
    }
    public function map($user): array
    {
        $this->count++;
        return [
            $this->count,
            $user->name,
            $user->email,
            $user->created_at,
           
        ];
    }

}
