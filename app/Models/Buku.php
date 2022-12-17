<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model {
    protected $fillable = array('buku_id', 'judul_buku', 'penulis', 'deskripsi', 'harga', 'rilis');

    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'id');
    }
}