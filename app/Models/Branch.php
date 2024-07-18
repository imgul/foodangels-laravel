<?php

namespace App\Models;

use DB;
use App\User;
use App\Models\QrCode;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\RatingsService;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Schema;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Branch extends BaseModel implements HasMedia
{
    use WatchableTrait, InteractsWithMedia, HasSlug;
    protected $table       = 'branches';
    protected $guarded     = ['id'];
    protected $auditColumn     = true;

    protected $fakeColumns = [];

    protected $casts = [
        'status' => 'int',
        'current_status' => 'int',
        'user_id' => 'int',
        'delivery_status' => 'int',
        'pickup_status' => 'int',
        'delivery_charge' => 'int',
        'table_status' => 'int',
        'applied' => 'int',
        'creator_id' => 'int',
        'editor_id ' => 'int',
    ];

    public function getRouteKeyName()
    {
        return request()->segment(1) === 'admin' ? 'id' : 'slug';
    }

    public function avgRating($restaurantID)
    {
        $rating = new RatingsService();
        return $rating->avgRating($restaurantID);
    }
    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'branch_cuisines');
    }

    public function coupons()
    {
        if (Schema::hasColumn('coupons', 'slug')) {
            return $this->hasMany(Coupon::class);
        }
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'branch_id','id');
    }

    public function branchPostalCode()
    {
        return $this->hasOne(BranchPostalCode::class);
    }

    public function postalCode()
    {
        return BranchPostalCode::where(['branch_id'=>$this->id])->first();
        // 'postal_code'=>session('postal_code')
    }

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('branch'))) {
            return asset($this->getFirstMediaUrl('branch'));
        }


        return asset('frontend/images/default/restaurant.jpg');
    }
    public function getLogoAttribute()
    {
        if (!empty($this->getFirstMediaUrl('restaurant_logo'))) {
            return asset($this->getFirstMediaUrl('restaurant_logo'));
        }
        return asset('frontend/images/default/logo.png');
    }

    public function getavgRatingsAttribute()
    {
        $rating      = new RatingsService();
        $ratingArray = $rating->avgRating($this->id);
        if (!blank($ratingArray)) {
            return $ratingArray;
        }
        return null;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeBranchowner($query)
    {
        if (Auth::check() && auth()->user()->branch_id != 0) {
            $query->where('user_id', auth()->user()->branch_id);
        }
    }

    public function OnModelCreated()
    {
        $qrCode                = new QrCode();
        $qrCode->branch_id = $this->id;
        $qrCode->creator_type  = $this->creator_type;
        $qrCode->creator_id    = $this->creator_id;
        $qrCode->editor_type   = $this->editor_type;
        $qrCode->editor_id     = $this->editor_id;
        $qrCode->save();
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(BranchRating::class);
    }
    public function deleteMedia($branch, $mediaName, $mediaId)
    {
        $media = Media::where([
            'file_name' => $mediaName,
            'collection_name' => 'branch',
            'model_id' => $mediaId,
            'model_type' => Branch::class,
        ])->first();

        if ($media) {
            $media->delete();
        }
    }
}
