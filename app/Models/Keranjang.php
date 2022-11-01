<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model {
    protected $fillable = array('id', 'judul_buku', 'jumlah_produk', 'total_harga');
}