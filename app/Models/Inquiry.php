<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use App\Enums\InquiryTopic;
use Database\Factories\InquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    /** @use HasFactory<InquiryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company',
        'topic',
        'message',
        'status',
        'internal_notes',
    ];

    protected $attributes = [
        'status' => 'new',
    ];

    protected function casts(): array
    {
        return [
            'topic' => InquiryTopic::class,
            'status' => InquiryStatus::class,
            'notified_at' => 'datetime',
        ];
    }
}
