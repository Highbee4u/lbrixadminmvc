<?php
class ItemBid extends BaseModel {




{
    protected $table = 'itembids';
    protected $primaryKey = 'itembidid';
    public $timestamps = false;

    /**
     * Get the item this bid is for.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }

    /**
     * Get the currency used for the bid.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyid', 'currencyid');
    }

    public function bidType()
    {
        return $this->belongsTo(BidType::class, 'bidtypeid', 'bidtypeid');
    }

    public function attorney()
    {
        return $this->belongsTo(User::class, 'attorneyid', 'userid');
    }

    /**
     * Get the bidder (user who made the bid).
     */
    public function bidder()
    {
        return $this->belongsTo(User::class, 'bidderid', 'userid');
    }
}
