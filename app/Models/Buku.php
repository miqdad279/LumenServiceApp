<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model {
    protected $fillable = array('id', 'judul_buku', 'harga');
}