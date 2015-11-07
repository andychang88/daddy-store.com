// JavaScript Document
$.fn.infiniteCarouse_center = function () {

    function repeat(str, num) {
		return str;
//        return new Array( num + 1 ).join( str );
    }
  
    return this.each(function () {
        var $wrapper = $('> div', this).css('overflow', 'hidden'),
            $slider = $wrapper.find('> ul'),
            $items = $slider.find('> li'),
            $single = $items.filter(':first'),
            
            singleWidth = $single.outerWidth(), 
            visible = (Math.ceil($wrapper.innerWidth() / singleWidth))-1,  /// note: doesn't include padding or border*/
            //visible=ppp;
			currentPage = 1,
            pages = Math.ceil($items.length / visible);            
        //alert(visible);

        // 1. Pad so that 'visible' number will always be seen, otherwise create empty items
        if (($items.length % visible) != 0) {
            $slider.append(repeat('<li class="empty" />', visible - ($items.length % visible)));
            $items = $slider.find('> li');
        }

        // 2. Top and tail the list with 'visible' number of items, top has the last section, and tail has the first
        $items.filter(':first').before($items.slice(- visible).clone().addClass('cloned'));
        $items.filter(':last').after($items.slice(0, visible).clone().addClass('cloned'));
        $items = $slider.find('> li'); // reselect
        
        // 3. Set the left position to the first 'real' item
        $wrapper.scrollLeft(singleWidth * visible);
        
        // 4. paging function
        function gotoPage(page) {
            var dir = page < currentPage ? -1 : 1,
                n = Math.abs(currentPage - page),
                left = singleWidth * dir * visible * n;
            
            $wrapper.filter(':not(:animated)').animate({
                scrollLeft : '+=' + left
            }, 500, function () {
                if (page == 0) {
                    $wrapper.scrollLeft(singleWidth * visible * pages);
                    page = pages;
                } else if (page > pages) {
                    $wrapper.scrollLeft(singleWidth * visible);
                    // reset back to start position
                    page = 1;
                } 

                currentPage = page;
            });                
            
            return false;
        }
        
        $wrapper.after('<a class="arrow back"></a><a class="arrow forward"></a>');
        
        // 5. Bind to the forward and back buttons
        $('a.back', this).click(function () {
            return gotoPage(currentPage - 1);                
        });
        
        $('a.forward', this).click(function () {
            return gotoPage(currentPage + 1);
        });
        
        // create a public interface to move to a specific page
        $(this).bind('goto', function (event, page) {
            gotoPage(page);
        });
    });  
};
$.fn.infiniteCarousel_bottom = function () {

    function repeat(str, num) {
		return str;
        //return new Array( num + 1 ).join( str );
    }
  
    return this.each(function () {
        var $wrapper = $('> div', this).css('overflow', 'hidden'),
            $slider = $wrapper.find('> ul'),
            $items = $slider.find('> li'),
            $single = $items.filter(':first'),
            
            singleWidth = $single.outerWidth(), 
            visible = (Math.ceil($wrapper.innerWidth() / singleWidth)),  /// note: doesn't include padding or border*/
            //visible=ppp;
			currentPage = 1,
            pages = Math.ceil($items.length / visible);            
        //alert(visible);

        // 1. Pad so that 'visible' number will always be seen, otherwise create empty items
        if (($items.length % visible) != 0) {
            $slider.append(repeat('<li class="empty" />', visible - ($items.length % visible)));
            $items = $slider.find('> li');
        }

        // 2. Top and tail the list with 'visible' number of items, top has the last section, and tail has the first
        $items.filter(':first').before($items.slice(- visible).clone().addClass('cloned'));
        $items.filter(':last').after($items.slice(0, visible).clone().addClass('cloned'));
        $items = $slider.find('> li'); // reselect
        
        // 3. Set the left position to the first 'real' item
        $wrapper.scrollLeft(singleWidth * visible);
        
        // 4. paging function
        function gotoPage(page) {
            var dir = page < currentPage ? -1 : 1,
                n = Math.abs(currentPage - page),
                left = singleWidth * dir * visible * n;
            
            $wrapper.filter(':not(:animated)').animate({
                scrollLeft : '+=' + left
            }, 500, function () {
                if (page == 0) {
                    $wrapper.scrollLeft(singleWidth * visible * pages);
                    page = pages;
                } else if (page > pages) {
                    $wrapper.scrollLeft(singleWidth * visible);
                    // reset back to start position
                    page = 1;
                } 

                currentPage = page;
            });                
            
            return false;
        }
        
        $wrapper.after('<a class="arrow back"></a><a class="arrow forward"></a>');
        
        // 5. Bind to the forward and back buttons
        $('a.back', this).click(function () {
            return gotoPage(currentPage - 1);                
        });
        
        $('a.forward', this).click(function () {
            return gotoPage(currentPage + 1);
        });
        
        // create a public interface to move to a specific page
        $(this).bind('goto', function (event, page) {
            gotoPage(page);
        });
    });  
};
$(document).ready(function () {
  $('.infiniteCarousel').infiniteCarouse_center();
  $('.infiniteCarousel_bottom').infiniteCarousel_bottom();
});

	
//页面部分的自适应
$(function(){
	function zsy_rows(){
		var maxRows,minRows,checknum,recommednum;
		var bodyWidth=document.body.offsetWidth;
		if(bodyWidth<=1200){
			maxRows=3;
			minRows=3;
			checknum=5;
		}else if(bodyWidth<=1360){
			maxRows=4;
			checknum=6;
			minRows=4;
		}else if(bodyWidth<=1600){
			maxRows=5;
			minRows=4
			checknum=7;
		}else if(bodyWidth<=1920){
			maxRows=6;
			checknum=8;
			minRows=5;
		}else if(bodyWidth<=2560){
			maxRows=7;
			checknum=9;
			minRows=6;
		}else{
			maxRows=8;
			checknum=10;
			minRows=7
		}
		if(bodyWidth <=1200){
			recommednum = 2;
		}else if(bodyWidth<=1700){
			recommednum =3;
		}else{
			recommednum =4;
		}
		var wrpsrow1=$(".godsbox");
                var wrpsrow3=$(".flist_box");
	
		if(wrpsrow1.length != 0){
			wrpsrow1.attr("class",AssignmentClass(".godsbox")+" rows"+maxRows);
		}
                
                if(wrpsrow3.length !=0 ){
			wrpsrow3.attr("class",AssignmentClass(".flist_box")+" rows"+(minRows));
		}
 		
		
	}
	function AssignmentClass(objclass){
		var getmename=$(objclass).attr("class");
		var newsname=getmename.replace(/rows\d/,"");
		return newsname;	
	}

	zsy_rows();
	var ts=0;
	$(window).resize(function(){
		var nowme=new Date();
		nowme=nowme.getTime();
		if(nowme-ts>200){
			ts=nowme;
			zsy_rows();
		}
	});
});	