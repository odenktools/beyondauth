 <?php

namespace Pribumi\BeyondAuth\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Pribumi\BeyondAuth\Exceptions\UserActivationDoesNotExist;
use Pribumi\BeyondAuth\Traits\BeyondTrait;

/**
 * @todo
 * @license MIT
 */
class UserActivation extends Model
{
    use BeyondTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * Nama Primary Key yang digunakan oleh table
     *
     * @var string
     */
    protected $primaryKey = '';

    /**
     * Eloquent `Users` model.
     *
     * @var string
     */
    protected static $usersModel = 'Pribumi\BeyondAuth\Models\User';

    /**
     * Pivot table `users_fields_domains_many`.
     *
     * @var string
     */
    protected static $usersActivationManyPivot = 'users_activation_many';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    //protected $guarded = ['activation_code'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activation_code',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table      = config('beyondauth.tables.masters.users_activations', 'users_activations');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_activations', 'id_activation');
    }

    /**
     * @todo
     *
     * <code>
     * $users_activation = \App\Models\ActivationMember::find(1)->users_activation;
     * echo json_encode($users_activation);
     *
     * or
     *
     * $users_activation = \App\Models\Domains::findByName("http://odenktools.com")->users_activation;
     * echo json_encode($users_activation);
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users_activation()
    {
        return $this->belongsToMany(static::$usersModel, static::$usersActivationManyPivot, 'user_id', 'activation_id')
            ->withTimestamps();
    }

    /**
     * Generate activation code
     * @return string
     */
    public function generateToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    /**
     * Find a member by its activation_code.
     *
     * @param string $activationCode
     *
     * @return ActivationMember
     *
     * @throws UserActivationDoesNotExist
     */
    public static function findByActivation($activationCode)
    {
        $role = static::where('activation_code', $activationCode)->first();

        if (!$role) {
            throw new UserActivationDoesNotExist();
        }
        return $role;
    }

}
