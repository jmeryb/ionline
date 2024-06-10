<?php

namespace App\Models\Sigfe;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\File;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Documents\Approval;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class PdfBackup extends Model
{
    use SoftDeletes;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'sigfe_pdfs';

    protected $fillable = [
        'id', 'dte_id', 'type',
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }
}
