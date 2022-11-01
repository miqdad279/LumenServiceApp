<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model {
    protected $fillable = array('id', 'judul_ebook', 'harga');
}