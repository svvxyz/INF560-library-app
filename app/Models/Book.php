<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'publisher',
        'publish_year',
        'pages',
        'language',
        'description',
        'cover_url',
        'total_copies',
        'available_copies',
        'status',
        'category_id'
    ];

    protected $casts = [
        'publish_year' => 'integer',
        'pages' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer'
    ];

    public function getIsAvailableAttribute(): bool
    {
        return $this->available_copies > 0;
    }

    public function decrementCopies(): bool
    {
        if ($this->available_copies <= 0){
            return false;
        }
        
        $this->decrement('available_copies');
        $this->refresh();

        if ($this->available_copies === 0){
            $this->update(['status' => 'unavailable']);
        }

        return true;
    }

    public function incrementCopies(): void
    {
        if ($this->available_copies < $this->total_copies){
            $this->increment('available_copies');
            $this->refresh();

            if ($this->status !== 'available'){
                $this->update(['status' => 'available']);
            }
        }
    }

    /* Relacion N-M con la tabla Authors mediante la tabla pivote authors_books*/
    public function authors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withPivot('role')->withTimestamps();
    }

    /* Relacion 1-1 con la tabla Category */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /* Relacion 1-N con la tabla Loans */
    public function loans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Loan::class);
    }
    
    /* Relacion: prestamos activos del libro */
    public function activeLoans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Loan::class)->where('status', 'active');
    }
}
