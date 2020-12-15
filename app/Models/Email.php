<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from',
        'to',
        'subject',
        'text_content',
        'html_content',
        'status'
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
