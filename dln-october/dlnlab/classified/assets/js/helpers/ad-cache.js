(function ($) {
    "use strict";

    var AdCache = function () {
        this.$kind     = [];
        this.$category = [];
        this.$amenity  = [];
        
        this.initKind();
        this.initCategory();
        this.initAmenity();
    };
    
    AdCache.prototype.initKind = function () {
        if (! $('#dln_kind').length || $('#dln_kind').text() == '')
            return false;
        
        this.$kind     = JSON.parse($('#dln_kind').text());
        return this.$kind;
    };
    
    AdCache.prototype.initCategory = function () {
        if (! $('#dln_category').length || $('#dln_category').text() == '')
            return false;
        
        this.$category = JSON.parse($('#dln_category').text());
        return this.$category;
    };
    
    AdCache.prototype.initAmenity = function () {
        if (! $('#dln_amenity').length || $('#dln_amenity').text() == '')
            return false;
        
        this.$amenity = JSON.parse($('#dln_amenity').text());
        return this.$amenity;
    };
    
    AdCache.prototype.getKindOptions = function () {
        var self = this;
        
        return self.commentForeach(this.$kind);
    };
    
    AdCache.prototype.getCategoryOptions = function () {
        var self = this;
        
        return self.commentForeach(this.$category);
    };
    
    AdCache.prototype.getAmenityOptions = function () {
        var self = this;
        
        return self.commentForeach(this.$amenity);
    };
    
    AdCache.prototype.commentForeach = function (values) {
        var options = [];
        $.each(values, function (id, data) {
            var option = {};
            option.value = data.id;
            option.text  = data.name;
            options.push(option);
        });
        
        return options;
    }
   
    $(document).ready(function () {
       window.ad_cache = new AdCache();
    });

}(window.jQuery));
