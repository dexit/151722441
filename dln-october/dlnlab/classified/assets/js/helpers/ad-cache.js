(function ($) {
    "use strict";

    var AdCache = function () {
        this.$kind     = [];
        this.$category = [];
        this.$amenity  = [];
        this.$cache    = {};
        
        this.parseCache();
        if (this.$cache && this.$cache.kind) {
            this.initKind();
        }
        if (this.$cache && this.$cache.category) {
            this.initCategory();
        }
        if (this.$cache && this.$cache.amenity) {
            this.initAmenity();
        }
    };
    
    AdCache.prototype.parseCache = function () {
        if (! $('#dln_caches').length || $('#dln_caches').text() == '')
            return false;
        this.$cache = JSON.parse($('#dln_caches').text());
    };
    
    AdCache.prototype.initKind = function () {
        this.$kind = this.$cache.kind;
        return this.$cache.kind;
    };
    
    AdCache.prototype.initCategory = function () {
        this.$category = this.$cache.category;
        return this.$cache.category;
    };
    
    AdCache.prototype.initAmenity = function () {
        this.$amenity = this.$cache.amenity;
        return this.$cache.amenity;
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
