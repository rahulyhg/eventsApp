<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 06/05/18
 * Time: 22:45
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSubscription extends Model
{
    protected $table = 'event_subscription';

    protected $fillable = [
      'event_id',
      'subscriber_id',
    ];
}