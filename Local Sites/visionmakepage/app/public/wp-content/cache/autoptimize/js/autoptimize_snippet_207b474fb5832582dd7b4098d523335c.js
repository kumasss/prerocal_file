(function($){$.fn.autoHeight=function(options){var op=$.extend({column:0,clear:0,height:'minHeight',reset:'',descend:function descend(a,b){return b-a;}},options||{});var self=$(this);var n=0,hMax,hList=new Array(),hListLine=new Array();hListLine[n]=0;self.each(function(i){if(op.reset=='reset'){$(this).removeAttr('style');}
var h=$(this).height();hList[i]=h;if(op.column>1){if(h>hListLine[n]){hListLine[n]=h;}
if((i>0)&&(((i+1)%op.column)==0)){n++;hListLine[n]=0;};}});hList=hList.sort(op.descend);hMax=hList[0];var ie6=typeof window.addEventListener=="undefined"&&typeof document.documentElement.style.maxHeight=="undefined";if(op.column>1){for(var j=0;j<hListLine.length;j++){for(var k=0;k<op.column;k++){if(ie6){self.eq(j*op.column+k).height(hListLine[j]);}else{self.eq(j*op.column+k).css(op.height,hListLine[j]);}
if(k==0&&op.clear!=0){self.eq(j*op.column+k).css('clear','both');}}}}else{if(ie6){self.height(hMax);}else{self.css(op.height,hMax);}}};})(jQuery);