(function ($) {
    "use strict";

    var AdCache = function () {
        this.$kind     = [];
        this.$category = [];
        this.$amenity  = [];
        this.data      = {};
        
        this.parseCache();
        
        if (this.data && this.data.kind) {
            this.initKind();
        }
        if (this.data && this.data.category) {
            this.initCategory();
        }
        if (this.data && this.data.amenity) {
            this.initAmenity();
        }
    };
    
    AdCache.prototype.parseCache = function () {
        if (! $('#dln_caches').length || $('#dln_caches').text() == '')
            return false;
        this.data = JSON.parse($('#dln_caches').text());
    };
    
    AdCache.prototype.initKind = function () {
        this.$kind = this.data.kind;
        return this.data.kind;
    };
    
    AdCache.prototype.initCategory = function () {
        this.$category = this.data.category;
        return this.data.category;
    };
    
    AdCache.prototype.initAmenity = function () {
        this.$amenity = this.data.amenity;
        return this.data.amenity;
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
