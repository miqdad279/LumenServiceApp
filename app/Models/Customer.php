<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    protected $fillable = array('id', 'username', 'email');
}