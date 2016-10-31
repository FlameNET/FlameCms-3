jQuery(document).ready(function($){
	(function( $ ){
		$.fn.hasAttr=function(tocheck){
			var $this=$(this);
			var attr=$this.attr(tocheck);
			return (typeof attr !== typeof undefined && attr !== false);
		};
		$.fn.id=function(){
			var $this=$(this);
			if($this.hasAttr('id')){
				return $this.attr('id');
			}
			else{
				return '';
			}
		};
		$.fn.name=function(){
			var $this=$(this);
			if($this.hasAttr('name')){
				return $this.attr('name');
			}
			else{
				return '';
			}
		};
		$.keycript=function(u,successCallback,errorCallback,errorCallback){
			if((typeof completeCallback)=='undefined'){
				completeCallback=function(){};
			}
			if((typeof errorCallback)=='undefined'){
				errorCallback=function(){};
			}
			var data={};
			var form=$(this);
			var method='';
			if(form.hasAttr('method')){
				method=form.attr('method');
			}
			else{
				method='POST';
			}
			form.find('input,textarea,select').each(function(){
				var t=$(this);
				if((t.hasAttr('type')==true) && ((t.attr('type')=='checkbox') || (t.attr('type')=='password')))
				{
					if(t.attr('type')=='checkbox'){
						var temp_checked=false;
						if(t.is(":checked")){
							temp_checked=true;
						}
						data_temp[t.id()]=temp_checked;
					}
					else{
						data_temp[t.id()]=CryptoJS.MD5(t.val()).toString();
					}
				}
				else{
					if((t.attr('type')!='submit'))
						data_temp[t.id()]=t.val();
				}
			});
			$.ajax({
			    url:u,
			    data:data,
			    method:method,
			    success:successCallback,
			    complete:completeCallback,
			    error:errorCallback
			});
		};
	})(jQuery);
	$(document).foundation();
});
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};
