<?php
class Item extends BaseModel {





{
    

    protected $primaryKey = 'itemid';
    public $timestamps = false; 

    /**
     * Get the service type associated with the item.
     */
    public function serviceType()
    {
        return $this->belongsTo(ItemServiceType::class, 'servicetypeid', 'itemservicetypeid');
    }

    /**
     * Get the bid type associated with the item.
     * Note: 'itembid' table has 'bidtypeid' as part of its *composite* primary key, but 'items' refers to a general bid type.
     * Assuming there's a simpler 'BidType' table or relationship for the general type. Using 'BidType' model for the table 'bidtype'.
     */
    public function bidType()
    {
        // Note: The 'bidtype' table has a composite key, but 'items' only uses 'bidtypeid'.
        // This is an unusual foreign key setup; we'll define a basic relationship.
        return $this->belongsTo(BidType::class, 'bidtypeid', 'bidtypeid');
    }

    /**
     * Get the item type associated with the item.
     */
    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'itemtypeid', 'itemtypeid');
    }

    /**
     * Get the ownership type associated with the item.
     */
    public function ownershipType()
    {
        return $this->belongsTo(OwnershipType::class, 'ownershiptypeid', 'ownershiptypeid');
    }

    /**
     * Get the project type associated with the item.
     */
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'projecttypeid', 'projecttypeid');
    }

    /**
     * Get the investment option associated with the item.
     */
    public function investOption()
    {
        return $this->belongsTo(InvestOption::class, 'investoptionid', 'investoptionid');
    }

    /**
     * Get the title type associated with the item.
     */
    public function titleType()
    {
        return $this->belongsTo(TitleType::class, 'titletypeid', 'titletypeid');
    }

    /**
     * Get the country associated with the item.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'countryid', 'countryid');
    }

    /**
     * Get the state associated with the item.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'stateid', 'stateid');
    }

    /**
     * Get the sub-location associated with the item.
     */
    public function subLocation()
    {
        // Note: The column 'sublocationid' in 'items' is VARCHAR(75), but in 'sublocations' it is INT (AUTO_INCREMENT).
        // Assuming the value stored in 'items.sublocationid' is the string representation of the INT ID.
        return $this->belongsTo(Sublocation::class, 'sublocationid', 'sublocationid');
    }

    /**
     * Get the currency used for the item's price.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyid', 'currencyid');
    }

    /**
     * Get the status of the item.
     */
    public function itemStatus()
    {
        return $this->belongsTo(ItemStatus::class, 'itemstatusid', 'itemstatusid');
    }

    /**
     * Get the inspection status of the item.
     */
    public function inspectionStatus()
    {
        return $this->belongsTo(InspectionStatus::class, 'inspectionstatusid', 'inspectionstatusid');
    }

    /**
     * Get the inspection task associated with the item.
     */
    public function inspectionTask()
    {
        // Note: 'inspectiontaskid' is NOT NULL in 'items', but 'itemid' is NULLABLE in 'inspectiontask'.
        // Assuming a one-to-one or one-to-many relationship where 'items' refers to a specific task.
        return $this->belongsTo(InspectionTask::class, 'inspectiontaskid', 'inspectiontaskid');
    }

    /**
     * Get the item bid associated with the item (for the winner/main bid).
     */
    public function itemBid()
    {
        return $this->belongsTo(ItemBid::class, 'itembidid', 'itembidid');
    }

    // Relationships to 'users' table (assuming a 'User' model for seller, buyer, financee, attorney, entryby, modifyby)
    // NOTE: You'll need to define the User model or adjust the class names.

    /**
     * Get the seller of the item.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerid', 'userid');
    }

    /**
     * Get the buyer of the item.
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyerid', 'userid');
    }

    /**
     * Get the financee for the item.
     */
    public function financee()
    {
        return $this->belongsTo(User::class, 'financeeid', 'userid');
    }

    /**
     * Get the attorney for the item.
     */
    public function attorney()
    {
        return $this->belongsTo(User::class, 'attorneyid', 'userid');
    }

    /**
     * Get all bids placed on this item.
     */
    public function itemBids()
    {
        return $this->hasMany(ItemBid::class, 'itemid', 'itemid');
    }

    /**
     * Get all inspection tasks for this item.
     */
    public function inspectionTasks()
    {
        return $this->hasMany(InspectionTask::class, 'itemid', 'itemid');
    }

    /**
     * Get all item documents for this item.
     */
    public function itemDocs()
    {
        return $this->hasMany(ItemDoc::class, 'itemid', 'itemid');
    }

    /**
     * Get all item pictures for this item.
     */
    public function itemPics()
    {
        return $this->hasMany(ItemPics::class, 'itemid', 'itemid');
    }

    /**
     * Get all item profiles for this item.
     */
    public function itemProfiles()
    {
        return $this->hasMany(ItemProfile::class, 'itemid', 'itemid');
    }

    /**
     * Get all sub-items for this item.
     */
    public function subItems()
    {
        return $this->hasMany(SubItem::class, 'itemid', 'itemid');
    }

}