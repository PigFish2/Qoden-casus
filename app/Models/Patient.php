<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $fillable = ['id', 'name', 'date_of_birth', 'address'];

    /**
     * This is to convert model into a asociative array so that getting data from api and model hashes into the same hash if they contain the same values.
     */
    public function convertToArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address
        ];
    }
}
